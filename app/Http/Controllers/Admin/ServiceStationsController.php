<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyServiceStationRequest;
use App\Http\Requests\StoreServiceStationRequest;
use App\Http\Requests\UpdateServiceStationRequest;
use App\Models\Category;
use App\Models\ServiceStation;
use App\Models\User;
use App\Models\UserAlert;
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

        $serviceStations = ServiceStation::with(['user', 'media','categories'])->get();

        $users = User::get();

        return view('admin.serviceStations.index', compact('serviceStations', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_station_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('username', 'id')->prepend(trans('global.pleaseSelect'), '');
        $categories = Category::all()->pluck('name', 'id');

        return view('admin.serviceStations.create', compact('users','categories'));
    }

    public function store(StoreServiceStationRequest $request)
    {
        $serviceStation = ServiceStation::create($request->all());

        $useralert = new UserAlert();
        $useralert->alert_text = "Twój warsztat został utworzony";
        $useralert->alert_link = "/app/service-stations/".$serviceStation->id;
        $useralert->save();
        $useralert->users()->sync($serviceStation->user_id);
        $serviceStation->categories()->sync($request->input('categories', []));

        if ($request->input('photo', false)) {
            $serviceStation->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $serviceStation->id]);
        }

        return redirect()->route('admin.service-stations.index');
    }

    public function edit(ServiceStation $serviceStation)
    {
        abort_if(Gate::denies('service_station_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all()->pluck('name', 'id');
        $users = User::all()->pluck('username', 'id')->prepend(trans('global.pleaseSelect'), '');

        $serviceStation->load('user','categories');

        return view('admin.serviceStations.edit', compact('users', 'serviceStation','categories'));
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

        return redirect()->route('admin.service-stations.index');
    }

    public function show(ServiceStation $serviceStation)
    {
        abort_if(Gate::denies('service_station_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceStation->load('user', 'stationRepairs','categories');

        return view('admin.serviceStations.show', compact('serviceStation'));
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

        $useralert = new UserAlert();
        $useralert->alert_text = "Twoj warsztat został zaakceptowany";
        $useralert->alert_link = "/app/service-stations/".$repair->id;
        $useralert->save();
        $useralert->users()->sync($repair->user_id);
    }
}
