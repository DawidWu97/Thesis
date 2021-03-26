@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.upcoming.title_singular') }}
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
                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $upcoming->car_id)->value('brand') ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.car.fields.model') }}
                                    </th>
                                    <td>
                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $upcoming->car_id)->value('model') ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.car.fields.engine') }}
                                    </th>
                                    <td>
                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $upcoming->car_id)->value('engine') ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.car.fields.plates') }}
                                    </th>
                                    <td>
                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $upcoming->car_id)->value('plates') ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.upcoming.fields.description') }}
                                    </th>
                                    <td>
                                        {!! $upcoming->description !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.upcoming.fields.mileage') }}
                                    </th>
                                    <td>
                                        {{ $upcoming->mileage }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.upcoming.fields.repair_at') }}
                                    </th>
                                    <td>
                                        {{ $upcoming->repair_at }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <a class="btn btn-default" href="javascript: history.go(-1)">
                                    {{ trans('global.back') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
