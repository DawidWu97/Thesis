<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyServiceStationRequest;
use App\Http\Requests\StoreServiceStationRequest;
use App\Http\Requests\UpdateServiceStationRequest;
use App\Models\Car;
use App\Models\Category;
use App\Models\Repair;
use App\Models\ServiceStation;
use App\Models\User;
use App\Models\UserAlert;
use App\Models\UserRequest;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ServiceStationsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('service_station_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceStations = ServiceStation::with(['user','media'])->get();

        $users = User::get();

        $ids = auth()->user()->userServiceStations()->wherenull('deleted_at')->get();

        foreach ($ids as $id)
        {
            $ident = $id->id;
        }

        $requests = UserRequest::where('user_id', auth()->user()->id)->get();

        foreach ($requests as $id)
        {
            $req = $id->id;
        }

        if (count($ids)!=0)
            return redirect()->route('frontend.service-stations.show', ['service_station' => $ident]);

        if (count($requests)==0)
            return redirect()->route('frontend.user-requests.create');
        else
            return redirect()->route('frontend.user-requests.edit', ['user_request' => $req]);

    }

    public function create()
    {
        abort_if(Gate::denies('service_station_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('username', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.serviceStations.create', compact('users'));
    }

    public function store(StoreServiceStationRequest $request)
    {
        if (auth()->user()->id == $request['user_id'])
        {
        $serviceStation = ServiceStation::create($request->all());

        $useralert = new UserAlert();
        $useralert->alert_text = "Utworzono nowy warsztat";
        $useralert->alert_link = "/app/service-stations/".$serviceStation->id;
        $useralert->save();
        $useralert->users()->sync(1);

        if ($request->input('photo', false)) {
            $serviceStation->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $serviceStation->id]);
        }
        }
        return redirect()->route('frontend.service-stations.index');
    }

    public function edit(ServiceStation $serviceStation)
    {
        abort_if(Gate::denies('service_station_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all()->pluck('name', 'id');

        $users = User::all()->pluck('username', 'id')->prepend(trans('global.pleaseSelect'), '');

        $serviceStation->load('user','categories');

        return view('frontend.serviceStations.edit', compact('users', 'serviceStation','categories'));
    }

    public function update(UpdateServiceStationRequest $request, ServiceStation $serviceStation)
    {

        $serviceStation->update($request->all());
        $serviceStation->categories()->sync($request->input('categories', []));

        if ($request->input('photo', false)) {
            if (!$serviceStation->photo || $request->input('photo') !== $serviceStation->photo->file_name) {
                if ($serviceStation->photo) {
                    $serviceStation->photo->delete();
                }

                $serviceStation->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
            }
        } elseif ($serviceStation->photo) {
            $serviceStation->photo->delete();
        }


        return redirect()->route('frontend.service-stations.index');
    }

    public function show(ServiceStation $serviceStation)
    {
        abort_if(Gate::denies('service_station_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = [];

        if (auth()->user()->id == $serviceStation->user_id){
            $helper = 1;
        foreach (Repair::where('station_id', $serviceStation->id)->wherenull('finished_at')->where('approved', true)->where('canceled', false)->where('suspend', false)->get() as $model) {
            $start = $model->getAttributes()['started_at'];
            $end = $model->getAttributes()['calculated_finish'];

            if (!$end) {
                continue;
            }

            $brand = DB::table('cars')->where('id', $model->car_id)->value('brand');
            $series = DB::table('cars')->where('id', $model->car_id)->value('model');
            $engine = DB::table('cars')->where('id', $model->car_id)->value('engine');
            $plates = DB::table('cars')->where('id', $model->car_id)->value('plates');

            $events[] = [
                'title' => $helper . ') ' . $brand . ' ' . $series . ' ' . $engine . ' ' . $plates,
                'start' => $start,
                'end' => $end,
                'url' => '/app/repairs/'.$model->id,
            ];

            $helper++;
        }
    }
        else{

            $begin = Carbon::now();
            $end = Repair::where('station_id', $serviceStation->id)->wherenull('finished_at')->where('approved', true)->where('canceled', false)->where('suspend', false)->max('calculated_finish');

            if ($begin < $end) {
                $interval = DateInterval::createFromDateString('1 hour');
                $period = new DatePeriod($begin, $interval, $end);

                foreach ($period as $date) {

                }

                $day = DateInterval::createFromDateString('1 day');
                $end_year = $end;
                $end_year = date_add(date_create($end_year), date_interval_create_from_date_string('1 year'));
                $free = new DatePeriod(date_create($end), $day, $end_year);


                $test = true;
                $start = date_create($end);

                while(($start->format('N') >= 6)==true) {
                    $start = date_add($start, date_interval_create_from_date_string('1 day'));
                }
                foreach($free as $date)
                {
                    if (($date->format('N') >= 6) == true)
                        continue;

                    if (($date->format('N') == 5) == true)
                    {
                            $events[] = [
                                'title' => 'WOLNY TERMIN od '. $end,
                                'start' => $start->format('Y-m-d H:i:s'),
                                'end' => $date->format('Y-m-d H:i:s'),
                            ];

                        $test = false;
                        continue;
                    }
                    if($test == false )
                    {
                        $start = $date;
                        $test = true;
                    }
                }


            }
            else
            {

                $currentDateTime = Carbon::now();
                $newDateTime = Carbon::now()->addYear();
                $day = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($currentDateTime, $day, $newDateTime);

                $test = true;
                $start = $currentDateTime;

                while((date_create($start)->format('N') >= 6)==true){
                    $start->addDay();
                }

                foreach($period as $date)
                {
                    if ((date_create($date)->format('N') >= 6))
                        continue;

                    if ((date_create($date)->format('N') == 5))
                    {
                        $events[] = [
                            'title' => 'WOLNY TERMIN OD JUTRA',
                            'start' => $start,
                            'end' => $date,
                        ];
                        $test = false;
                        continue;
                    }
                    if($test == false )
                    {
                        $start = $date;
                        $test = true;
                    }
                }

            }


        }


        $serviceStation->load('user','stationRepairs');

        $cars = Car::where('user_id', auth()->user()->id)->get();

        return view('frontend.serviceStations.show', compact('serviceStation','cars','events'));
    }

    public function destroy(ServiceStation $serviceStation)
    {
        abort_if(Gate::denies('service_station_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceStation->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceStationRequest $request)
    {
        ServiceStation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('service_station_create') && Gate::denies('service_station_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ServiceStation();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function approve(Request $request)
    {

        $repair = ServiceStation::find($request['id']);
        $repair->approved = true;
        $repair->save();

    }

    public function cancel(Request $request)

    {
        $repair = ServiceStation::find($request['id']);
        $repair->approved = false;
        $repair->save();

    }
}
