@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.car.title_singular') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="javascript: history.go(-1)">
                                    {{ trans('global.back') }}
                                </a>
                            </div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.car.fields.brand') }}
                                    </th>
                                    <td>
                                        {{ $car->brand }}
                                    </td>
                                    <th>
                                        {{ trans('cruds.car.fields.model') }}
                                    </th>
                                    <td>
                                        {{ $car->model }}
                                    </td>
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
                                    <td colspan="2">
                                        {{ $car->vin }}
                                    </td>
                                    <th>
                                        {{ trans('cruds.car.fields.plates') }}
                                    </th>
                                    <td colspan="2">
                                        {{ $car->plates }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.car.fields.bought_mileage') }}
                                    </th>
                                    <td colspan="2">
                                        {{ $car->bought_mileage }}
                                    </td>
                                    <th>
                                        {{ trans('cruds.car.fields.bought_at') }}
                                    </th>
                                    <td colspan="2">
                                        {{ $car->bought_at }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                            @includeIf('frontend.cars.relationships.carRepairs', ['repairs' => $car->carRepairs])
                        </div>
                        <div class="tab-pane" role="tabpanel" id="car_upcomings">
                            @includeIf('frontend.cars.relationships.carUpcomings', ['upcomings' => $car->carUpcomings])
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
