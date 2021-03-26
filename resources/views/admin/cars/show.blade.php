@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.car.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.cars.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.car.fields.id') }}
                        </th>
                        <td>
                            {{ $car->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.car.fields.brand') }}
                        </th>
                        <td>
                            {{ $car->brand }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.car.fields.model') }}
                        </th>
                        <td>
                            {{ $car->model }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.car.fields.engine') }}
                        </th>
                        <td>
                            {{ $car->engine }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.car.fields.vin') }}
                        </th>
                        <td>
                            {{ $car->vin }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.car.fields.plates') }}
                        </th>
                        <td>
                            {{ $car->plates }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.car.fields.user') }}
                        </th>
                        <td>
                            {{ $car->user->username ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.car.fields.bought_mileage') }}
                        </th>
                        <td>
                            {{ $car->bought_mileage }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.car.fields.bought_at') }}
                        </th>
                        <td>
                            {{ $car->bought_at }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.cars.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#car_repairs" role="tab" data-toggle="tab">
                    {{ trans('cruds.repair.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#car_upcomings" role="tab" data-toggle="tab">
                    {{ trans('cruds.upcoming.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="car_repairs">
                @includeIf('admin.cars.relationships.carRepairs', ['repairs' => $car->carRepairs])
            </div>
            <div class="tab-pane" role="tabpanel" id="car_upcomings">
                @includeIf('admin.cars.relationships.carUpcomings', ['upcomings' => $car->carUpcomings])
            </div>
        </div>
    </div>

@endsection
