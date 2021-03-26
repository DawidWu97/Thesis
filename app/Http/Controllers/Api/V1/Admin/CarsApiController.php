<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\Admin\CarResource;
use App\Models\Car;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('car_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarResource(Car::with(['user', 'created_by'])->get());
    }

    public function store(StoreCarRequest $request)
    {
        $car = Car::create($request->all());

        return (new CarResource($car))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Car $car)
    {
        abort_if(Gate::denies('car_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarResource($car->load(['user', 'created_by']));
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->all());

        return (new CarResource($car))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Car $car)
    {
        abort_if(Gate::denies('car_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $car->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
