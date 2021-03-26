@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.repair.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.repairs.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.id') }}
                        </th>
                        <td>
                            {{ $repair->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.car') }}
                        </th>
                        <td>
                            {{ $repair->car->plates ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.station') }}
                        </th>
                        <td>
                            {{ $repair->station->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.description') }}
                        </th>
                        <td>
                            {!! $repair->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.customer_comments') }}
                        </th>
                        <td>
                            {!! $repair->customer_comments !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.mileage') }}
                        </th>
                        <td>
                            {{ $repair->mileage }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $repair->approved ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.canceled') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $repair->canceled ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.started_at') }}
                        </th>
                        <td>
                            {{ $repair->started_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.calculated_finish') }}
                        </th>
                        <td>
                            {{ $repair->calculated_finish }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.finished_at') }}
                        </th>
                        <td>
                            {{ $repair->finished_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.repair.fields.created_at') }}
                        </th>
                        <td>
                            {{ $repair->created_at }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.repairs.index') }}">
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
                <a class="nav-link" href="#repair_tasks" role="tab" data-toggle="tab">
                    {{ trans('cruds.task.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="repair_tasks">
                @includeIf('admin.repairs.relationships.repairTasks', ['tasks' => $repair->repairTasks])
            </div>
        </div>
    </div>

@endsection
