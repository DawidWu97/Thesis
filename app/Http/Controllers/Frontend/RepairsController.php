<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRepairRequest;
use App\Http\Requests\StoreRepairRequest;
use App\Http\Requests\UpdateRepairRequest;
use App\Models\Car;
use App\Models\Repair;
use App\Models\ServiceStation;
use App\Models\Task;
use App\Models\UserAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class RepairsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('repair_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cars = Car::where('user_id', auth()->user()->id)->wherenull('deleted_at')->pluck('id');

        $repairs = Repair::whereIn('car_id', $cars)->get();

        $active_stations = Auth::user()->userServiceStations()->where("approved",true)->where('deleted_at', null)->get();
        $id_services = $active_stations->pluck('id');
        $repair_query = Repair::whereIn('station_id',$id_services)->where('finished_at', null)->where('canceled', false)->get();
        $vin = array();
        foreach ($repair_query as $query)
        {
           $number= DB::table('cars')->where('id', $query->car_id)->value('vin');
           array_push($vin,$number);
        }
        $vin_unique = array_unique($vin, $flags = SORT_NUMERIC);
        $vin_cars = DB::table('cars')->whereIn('vin', $vin_unique)->pluck('id');
        $vin_repairs = Repair::whereIn('car_id', $vin_cars)->wherenotnull('finished_at')->get();

        $service_stations = ServiceStation::get();

        return view('frontend.repairs.index', compact('vin_repairs','repairs', 'cars', 'service_stations'));
    }

    public function create()
    {
        abort_if(Gate::denies('repair_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cars = Car::all()->pluck('plates', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stations = ServiceStation::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.repairs.create', compact('cars', 'stations'));
    }

    public function store(StoreRepairRequest $request)
    {
        $services = ServiceStation::where('id', $request['station_id'])->where('approved', true)->where('deleted_at', null)->get();
        $usercars = auth()->user()->userCars()->where('id', $request['car_id'])->get();

        $max = Car::find($request['car_id'])->carRepairs()->where('canceled', false)->max('mileage');
        $mileage = Car::find($request['car_id'])->bought_mileage;

        $workplaces = ServiceStation::find($request['station_id'])->workplaces;

        $repairs = ServiceStation::find($request['station_id'])
            ->stationRepairs()->where('approved', true)->wherenull('finished_at')
            ->wherenotnull('calculated_finish')
            ->where('suspend', false)
            ->where('started_at','<=',date_create($request['started_at']))
            ->where('calculated_finish','>=',date_create($request['started_at']))
            ->get();

        $user = ServiceStation::find($request['station_id'])->user_id;

        $start = ServiceStation::find($request['station_id'])->opening;
        $closing = ServiceStation::find($request['station_id'])->closing;
        $weekend = (date_create($request['started_at'])->format('N') >= 6);
        $time = (date_create($request['started_at'])->format('H:i:s'));

        if ($request['mileage']<$max OR $request['mileage']<$mileage)
            return Redirect::back()->withErrors(['BŁĄD POLA AKTUALNY PRZEBIEG', 'Przebieg musi być większy niż ten podczas zakupu i napraw']);

        if(count($repairs)>=$workplaces)
            return Redirect::back()->withErrors(['BŁĄD DATY ROZPOCZĘCIA', 'Ta data jest już zajęta w tym warsztacie']);

        if($weekend==true)
            return Redirect::back()->withErrors(['BŁĄD DATY ROZPOCZĘCIA', 'Wybierz dzień pracujący']);

        if($time<$start OR $time>$closing)
            return Redirect::back()->withErrors(['BŁĄD GODZINY ROZPOCZĘCIA', 'Wybierz godzine pomiędzy godzinami pracy warsztatu']);

        if((count($repairs)==0 OR count($repairs)<$workplaces) AND count($usercars)!=0 AND count($services) != 0 AND $request['mileage']>$max AND $request['mileage']>$mileage AND $weekend==false AND $time>$start AND $time<$closing)
        {
        $repair = Repair::create($request->all());

            $useralert = new UserAlert();
            $useralert->alert_text = "Nowa naprawa";
            $useralert->alert_link = "/app/repairs/".$repair->id;
            $useralert->save();
            $useralert->users()->sync($user);

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $repair->id]);
        }
            return redirect()->route('frontend.repairs.index');
        }

        return Redirect::back()->withErrors(['BŁĄD AUTORYZACJI', 'Error 404']);
    }

    public function edit(Repair $repair)
    {
        abort_if(Gate::denies('repair_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cars = Car::all()->pluck('plates', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stations = ServiceStation::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $repair->load('car', 'station');

        $tasks = Task::where('repair_id', $repair->id)->get();

        return view('frontend.repairs.edit', compact('cars','tasks', 'stations', 'repair'));
    }

    public function update(Request $request, Repair $repair)
    {
        $repair->update($request->all());

        $task_name = $request->input('task_name', []);
        $task_duration = $request->input('task_duration', []);

        $tasks = Task::where('repair_id', $repair->id)->get();

        foreach ($tasks as $task_update)
        {
            $task_update->name = $request['task'.$task_update->id];
            $task_update->duration = $request['duration'.$task_update->id];
            $task_update->save();
        }

        for ($i=0; $i < count($task_name); $i++) {
            if ($task_name[$i] != '') {
                $task = new Task();
                $task->name = $task_name[$i];
                $task->duration = $task_duration[$i];
                $task->repair_id = $repair->id;
                $task->save();
            }
        }

        if($request['radio']=='auto')
        {
            $repair_tasks = Task::where('repair_id', $repair->id)->get();
            $count_duration = 0;

            foreach ($repair_tasks as $repair_task) {
                $count_duration += $repair_task->duration;
            }

            $start = $repair->station->opening;
            $end = $repair->station->closing;
            $now = Carbon::now()->format('d-m-Y');
            $start_date = date_create($now.''.$start);
            $end_date = date_create($now.''.$end);
            $diff = date_diff($end_date,$start_date);
            $between = $diff->format('%h');
            if(($diff->format('%i'))>0)
                $between++;
            $days_double = $count_duration/$between;
            $modulo = $count_duration%$between;
            $days = intval($days_double);

            $started = $repair->started_at;
            $add_days = Carbon::create($started);

            for($i=0; $i<$days; $i++){
                $add_days->addDay();

                $minutes = 60-($diff->format('%i'));

                if(($diff->format('%i'))>0)
                $add_days->addMinutes($minutes);

                if($add_days->format('H:i:s') > $repair->station->closing)
                {
                    $add_days->addDay();
                    $add_days->subHours($between);

                    if(($diff->format('%i'))>0)
                        $add_days->addMinutes($minutes);
                }

                while($add_days->format('N')>=6)
                {
                    $add_days->addDay();
                }
            }

            for($i=0; $i<$modulo; $i++)
            {
                $add_days->addHour();

                if($add_days->format('H:i:s') > $repair->station->closing)
                {
                     $add_days->addDay();
                     $add_days->subHours($between);

                    if(($diff->format('%i'))>0)
                        $add_days->addMinutes($minutes);
                }

                while($add_days->format('N')>=6)
                {
                    $add_days->addDay();
                }
            }

            $repair->calculated_finish = $add_days->format('d-m-Y H:i:s');
            $repair->save();
        }

        return redirect()->route('frontend.service-stations.index');
    }

    public function show(Repair $repair)
    {
        abort_if(Gate::denies('repair_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $active_stations = Auth::user()->userServiceStations()->where("approved",true)->where('deleted_at', null)->get();
        $id_services = $active_stations->pluck('id');
        $repair_query = Repair::whereIn('station_id',$id_services)->where('finished_at', null)->where('canceled', false)->get();
        $vin = array();
        foreach ($repair_query as $query)
        {
            $number= DB::table('cars')->where('id', $query->car_id)->value('vin');
            array_push($vin,$number);
        }
        $vin_unique = array_unique($vin, $flags = SORT_NUMERIC);

        /*foreach($vin_unique as $car_vin)
        {
            if ()
        }*/

        $test = 0 ;
        $repair->load('car', 'station', 'repairTasks');

        $station = $repair->station->user_id;
        $user = auth()->user()->id;
        if ($station==$user)
            $test++;



        return view('frontend.repairs.show', compact('repair','test'));
    }

    public function destroy(Repair $repair)
    {
        abort_if(Gate::denies('repair_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair->delete();

        return back();
    }

    public function massDestroy(MassDestroyRepairRequest $request)
    {
        Repair::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('repair_create') && Gate::denies('repair_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Repair();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function approve(Request $request)
    {
        abort_if(Gate::denies('Company'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair = Repair::find($request['id']);
        $repair->approved = true;
        $repair->save();

        if(auth()->user()->id != DB::table('cars')->where('id', $repair->car_id)->value('user_id')) {
            $useralert = new UserAlert();
            $useralert->alert_text = "Twoja naprawa została zaakceptowana";
            $useralert->alert_link = "/app/repairs/" . $repair->id;
            $useralert->save();
            $useralert->users()->sync($repair->car->user_id);
        }
    }

    public function cancel(Request $request)

    {
        $repair = Repair::find($request['id']);
        $repair->canceled = true;
        $repair->save();

        if(auth()->user()->id != DB::table('cars')->where('id', $repair->car_id)->value('user_id')) {
            $useralert = new UserAlert();
            $useralert->alert_text = "Twoja naprawa została anulowana";
            $useralert->alert_link = "/app/repairs/" . $repair->id;
            $useralert->save();
            $useralert->users()->sync($repair->car->user_id);
        }
    }

    public function suspend(Request $request)
    {
        $repair = Repair::find($request['id']);
        if($repair->suspend==false)
            $repair->suspend = true;
        else
            $repair->suspend = false;
        $repair->save();

    }

    public function fin(Request $request)
    {
        $repair = Repair::find($request['id']);
        $date = Carbon::now()->format("d-m-Y H:i:s");
        $repair->finished_at = $date;
        $repair->save();

        if(auth()->user()->id != DB::table('cars')->where('id', $repair->car_id)->value('user_id')) {
            $useralert = new UserAlert();
            $useralert->alert_text = "Twoja naprawa została zakończona";
            $useralert->alert_link = "/app/repairs/" . $repair->id;
            $useralert->save();
            $useralert->users()->sync($repair->car->user_id);
        }
    }
    public function task(Request $request)
    {
        $task = Task::find($request['id']);
        $task->delete();
    }

}
