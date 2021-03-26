@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.upcoming.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.upcomings.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.upcoming.fields.id') }}
                        </th>
                        <td>
                            {{ $upcoming->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.upcoming.fields.car') }}
                        </th>
                        <td>
                            {{ $upcoming->car->plates ?? '' }}
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
                    <a class="btn btn-default" href="{{ route('admin.upcomings.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
