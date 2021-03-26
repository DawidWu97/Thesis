<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreUpcomingRequest;
use App\Http\Requests\UpdateUpcomingRequest;
use App\Http\Resources\Admin\UpcomingResource;
use App\Models\Upcoming;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpcomingsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('upcoming_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UpcomingResource(Upcoming::with(['car'])->get());
    }

    public function store(StoreUpcomingRequest $request)
    {
        $upcoming = Upcoming::create($request->all());

        return (new UpcomingResource($upcoming))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Upcoming $upcoming)
    {
        abort_if(Gate::denies('upcoming_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UpcomingResource($upcoming->load(['car']));
    }

    public function update(UpdateUpcomingRequest $request, Upcoming $upcoming)
    {
        $upcoming->update($request->all());

        return (new UpcomingResource($upcoming))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Upcoming $upcoming)
    {
        abort_if(Gate::denies('upcoming_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $upcoming->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
