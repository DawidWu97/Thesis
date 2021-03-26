<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCarRequest;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('car_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cars = Car::with(['user', 'created_by'])->get();

        return view('frontend.cars.index', compact('cars'));
    }

    public function create()
    {
        abort_if(Gate::denies('car_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('username', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.cars.create', compact('users'));
    }

    public function store(StoreCarRequest $request)
    {

        if (auth()->user()->id == $request['user_id'])
        $car = Car::create($request->all());

        return redirect()->route('frontend.cars.index');
    }

    public function edit(Car $car)
    {
        abort_if(Gate::denies('car_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('username', 'id')->prepend(trans('global.pleaseSelect'), '');

        $car->load('user', 'created_by');

        return view('frontend.cars.edit', compact('users', 'car'));
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->all());

        return redirect()->route('frontend.cars.index');
    }

    public function show(Car $car)
    {
        abort_if(Gate::denies('car_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $own_car = auth()->user()->userCars()->where('id', $car->id)->get();

        //$own_services = auth()->user()->userServiceStations()->pluck('id');

        $car->load('user', 'created_by', 'carRepairs', 'carUpcomings');

       /* $repair = $car->carRepairs()->whereIn('station_id', $own_services)
            ->where('canceled',false)->whereNull('finished_at')->get();*/

        if(count($own_car)!=0)
            return view('frontend.cars.show', compact('car'));
        else
            abort(403, 'Unauthorized action.');
            return Response::HTTP_FORBIDDEN;
    }

    public function destroy(Car $car)
    {
        abort_if(Gate::denies('car_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $car->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarRequest $request)
    {
        Car::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
