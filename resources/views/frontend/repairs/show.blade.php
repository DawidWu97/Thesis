@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.repair.title_singular') }} - {{$repair->car->plates}}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @if ($repair->approved == false AND $repair->canceled == false AND $test!=0)
                            <div class="form-group col-4">
                                <button class="btn btn-success" id="approve">
                                    {{ trans('global.approve') }}
                                </button>
                            </div>
                            <div class="form-group col-4">
                                <button class="btn btn-danger" id="cancel">
                                    {{ trans('global.cancel') }}
                                </button>
                            </div>
                            @endif
                          </div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.car.fields.brand') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.car.fields.model') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.car.fields.engine') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.car.fields.plates') }}
                                    </th>
                                    <th colspan="2">
                                        {{ trans('cruds.car.fields.vin') }}
                                    </th>
                                    </tr>
                                    <tr>
                                    <td>
                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('brand') ?? '' }}
                                    </td>
                                    <td>
                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('model') ?? '' }}
                                    </td>
                                    <td>
                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('engine') ?? '' }}
                                    </td>
                                    <td>
                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('plates') ?? '' }}
                                    </td>
                                    <td colspan="2">
                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('vin') ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                @if($repair->car->user_id == auth()->user()->id)
                                    <th>
                                        {{ trans('cruds.repair.fields.station') }}
                                    </th>
                                    <td colspan="2">
                                        {{ Illuminate\Support\Facades\DB::table('service_stations')->where('id', $repair->station_id)->value('name') ?? '' }}
                                    </td>
                                @else
                                        <th>
                                            {{ trans('cruds.user.fields.phone') }}
                                        </th>
                                        <td colspan="2">
                                            {{ Illuminate\Support\Facades\DB::table('users')->where('id', $repair->car->user_id)->value('phone') ?? '' }}
                                        </td>
                                @endif
                                    <th>
                                        {{ trans('cruds.repair.fields.mileage') }}
                                    </th>
                                    <td colspan="2">
                                        {{ $repair->mileage }}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        {{ trans('cruds.repair.fields.customer_comments') }}
                                    </th>
                                    <td colspan="4">
                                        {!! $repair->customer_comments !!}
                                    </td>
                                </tr>
                                @if ($repair->approved == true)
                                <tr>
                                    <th colspan="2">
                                        {{ trans('cruds.repair.fields.description') }}
                                    </th>
                                    <td colspan="4">
                                        {!! $repair->description !!}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th colspan="2">
                                        {{ trans('cruds.repair.fields.started_at') }}
                                    </th>
                                    <td>
                                        {{ $repair->started_at }}
                                    </td>
                                @if($repair->approved == true AND $repair->finished_at == null)
                                    <th colspan="2">
                                        {{ trans('cruds.repair.fields.calculated_finish') }}
                                    </th>
                                    <td>
                                        {{ $repair->calculated_finish }}
                                    </td>
                                @elseif($repair->finished_at != null)
                                    <th colspan="2">
                                        {{ trans('cruds.repair.fields.finished_at') }}
                                    </th>
                                    <td>
                                        {{ $repair->finished_at }}
                                    </td>
                                @else
                                            <th colspan="2">
                                            </th>
                                            <td>
                                            </td>
                                @endif
                                </tr>
                                <tr>
                                    <th colspan="6">
                                        <center>{{ trans('cruds.task.title') }}</center>
                                    </th>
                                </tr>
                                @foreach($repair->repairTasks as $task)
                                <tr>
                                    <th>
                                        {{ trans('cruds.task.fields.name') }}
                                    </th>
                                    <td colspan="3">
                                        {{$task->name}}
                                    </td>
                                    <th>
                                        {{ trans('cruds.task.fields.duration') }}
                                    </th>
                                    <td>
                                        {{$task->duration}}
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
        <script>
            $(document).ready(function () {
                $('#approve').on('click', function () {

                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                        }
                    })

                    $.ajax({
                        type:'PATCH',
                        data: {"id": {{$repair->id}} },
                        url: '{{ route('frontend.repairs.approve') }}',
                        beforeSend: function() {
                            return confirm('{{ trans('global.areYouSure') }}');
                        }
                    })
                        .done(function (response)
                        {
                            window.location.reload();
                        });
                });
            });

            $(document).ready(function () {
                $('#cancel').on('click', function () {

                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                        }
                    })

                    $.ajax({
                        type:'PATCH',
                        data: {"id": {{$repair->id}} },
                        url: '{{ route('frontend.repairs.cancel') }}',
                        beforeSend: function() {
                            return confirm('{{ trans('global.areYouSure') }}');
                        }
                    })
                        .done(function (response)
                        {
                            window.location.reload();
                        });
                });
            });

        </script>
@endsection

