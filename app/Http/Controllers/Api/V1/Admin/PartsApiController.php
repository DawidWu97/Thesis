<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartRequest;
use App\Http\Requests\UpdatePartRequest;
use App\Http\Resources\Admin\PartResource;
use App\Models\Part;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PartsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('part_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PartResource(Part::with(['task'])->get());
    }

    public function store(StorePartRequest $request)
    {
        $part = Part::create($request->all());

        return (new PartResource($part))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Part $part)
    {
        abort_if(Gate::denies('part_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PartResource($part->load(['task']));
    }

    public function update(UpdatePartRequest $request, Part $part)
    {
        $part->update($request->all());

        return (new PartResource($part))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Part $part)
    {
        abort_if(Gate::denies('part_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $part->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
