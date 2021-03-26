<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreServiceStationRequest;
use App\Http\Requests\UpdateServiceStationRequest;
use App\Http\Resources\Admin\ServiceStationResource;
use App\Models\ServiceStation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceStationsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('service_station_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceStationResource(ServiceStation::with(['user', 'created_by'])->get());
    }

    public function store(StoreServiceStationRequest $request)
    {
        $serviceStation = ServiceStation::create($request->all());

        if ($request->input('photo', false)) {
            $serviceStation->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        return (new ServiceStationResource($serviceStation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ServiceStation $serviceStation)
    {
        abort_if(Gate::denies('service_station_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceStationResource($serviceStation->load(['user', 'created_by']));
    }

    public function update(UpdateServiceStationRequest $request, ServiceStation $serviceStation)
    {
        $serviceStation->update($request->all());

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

        return (new ServiceStationResource($serviceStation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ServiceStation $serviceStation)
    {
        abort_if(Gate::denies('service_station_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceStation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
