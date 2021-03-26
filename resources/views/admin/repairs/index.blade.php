@extends('layouts.admin')
@section('content')
    @can('repair_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.repairs.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.repair.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.repair.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Repair">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.car') }}
                        </th>
                        <th>
                            {{ trans('cruds.car.fields.vin') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.station') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.mileage') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.approved') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.canceled') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.started_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.calculated_finish') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.finished_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.repair.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($cars as $key => $item)
                                    <option value="{{ $item->plates }}">{{ $item->plates }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($service_stations as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($repairs as $key => $repair)
                        <tr data-entry-id="{{ $repair->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $repair->id ?? '' }}
                            </td>
                            <td>
                                {{ $repair->car->plates ?? '' }}
                            </td>
                            <td>
                                {{ $repair->car->vin ?? '' }}
                            </td>
                            <td>
                                {{ $repair->station->name ?? '' }}
                            </td>
                            <td>
                                {{ $repair->mileage ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $repair->approved ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $repair->approved ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $repair->canceled ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $repair->canceled ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $repair->started_at ?? '' }}
                            </td>
                            <td>
                                {{ $repair->calculated_finish ?? '' }}
                            </td>
                            <td>
                                {{ $repair->finished_at ?? '' }}
                            </td>
                            <td>
                                {{ $repair->created_at ?? '' }}
                            </td>
                            <td>
                                @can('repair_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.repairs.show', $repair->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('repair_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.repairs.edit', $repair->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('repair_delete')
                                    <form action="{{ route('admin.repairs.destroy', $repair->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('repair_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.repairs.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            let table = $('.datatable-Repair:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
            });
            table.on('column-visibility.dt', function(e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        })

    </script>
@endsection
