<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreRepairRequest;
use App\Http\Requests\UpdateRepairRequest;
use App\Http\Resources\Admin\RepairResource;
use App\Models\Repair;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepairsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('repair_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RepairResource(Repair::with(['car', 'station'])->get());
    }

    public function store(StoreRepairRequest $request)
    {
        $repair = Repair::create($request->all());

        return (new RepairResource($repair))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Repair $repair)
    {
        abort_if(Gate::denies('repair_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RepairResource($repair->load(['car', 'station']));
    }

    public function update(UpdateRepairRequest $request, Repair $repair)
    {
        $repair->update($request->all());

        return (new RepairResource($repair))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Repair $repair)
    {
        abort_if(Gate::denies('repair_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
