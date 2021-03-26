@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.serviceStation.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.service-stations.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.id') }}
                        </th>
                        <td>
                            {{ $serviceStation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.user') }}
                        </th>
                        <td>
                            {{ $serviceStation->user->username ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.name') }}
                        </th>
                        <td>
                            {{ $serviceStation->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.description') }}
                        </th>
                        <td>
                            {!! $serviceStation->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.phone') }}
                        </th>
                        <td>
                            {{ $serviceStation->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.photo') }}
                        </th>
                        <td>
                            @if($serviceStation->photo)
                                <a href="{{ $serviceStation->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $serviceStation->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.opening') }}
                        </th>
                        <td>
                            {{ $serviceStation->opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.closing') }}
                        </th>
                        <td>
                            {{ $serviceStation->closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.workplaces') }}
                        </th>
                        <td>
                            {{ $serviceStation->workplaces }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.city') }}
                        </th>
                        <td>
                            {{ $serviceStation->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.street') }}
                        </th>
                        <td>
                            {{ $serviceStation->street }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.postcode') }}
                        </th>
                        <td>
                            {{ $serviceStation->postcode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $serviceStation->approved ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStation.fields.categories') }}
                        </th>
                        <td>
                            @foreach($serviceStation->categories as $key => $category)
                                <span class="label label-info">{{ $category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.service-stations.index') }}">
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
                <a class="nav-link" href="#station_repairs" role="tab" data-toggle="tab">
                    {{ trans('cruds.repair.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="station_repairs">
                @includeIf('admin.serviceStations.relationships.stationRepairs', ['repairs' => $serviceStation->stationRepairs])
            </div>
        </div>
    </div>

@endsection
