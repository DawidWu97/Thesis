@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.user.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.username') }}
                        </th>
                        <td>
                            {{ $user->username }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->approved ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.users.index') }}">
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
                <a class="nav-link" href="#user_service_stations" role="tab" data-toggle="tab">
                    {{ trans('cruds.serviceStation.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#user_cars" role="tab" data-toggle="tab">
                    {{ trans('cruds.car.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#user_user_alerts" role="tab" data-toggle="tab">
                    {{ trans('cruds.userAlert.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="user_service_stations">
                @includeIf('admin.users.relationships.userServiceStations', ['serviceStations' => $user->userServiceStations])
            </div>
            <div class="tab-pane" role="tabpanel" id="user_cars">
                @includeIf('admin.users.relationships.userCars', ['cars' => $user->userCars])
            </div>
            <div class="tab-pane" role="tabpanel" id="user_user_alerts">
                @includeIf('admin.users.relationships.userUserAlerts', ['userAlerts' => $user->userUserAlerts])
            </div>
        </div>
    </div>

@endsection
