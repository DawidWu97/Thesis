@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.repair.title') }} {{ trans('global.list') }}
                    </div>

                    @can("User")
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Repair">
                                <thead>
                                <tr>
                                    <th>

                                    </th>
                                    <th>
                                        {{ trans('cruds.car.fields.plates') }}
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
                                        Status
                                    </th>
                                    <th>
                                        {{ trans('cruds.repair.fields.started_at') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.repair.fields.finished_at') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($repairs as $key => $repair)
                                    <tr data-entry-id="{{ $repair->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $repair->car->plates ?? '' }}
                                        </td>
                                        <td>
                                            {{ $repair->car->vin ?? '' }}
                                        </td>
                                        <td>
                                            {{ Illuminate\Support\Facades\DB::table('service_stations')->where('id', $repair->station_id)->value('name') ?? '' }}
                                        </td>
                                        <td>
                                            {{ $repair->mileage ?? '' }}
                                        </td>
                                        <td>
                                            @if($repair->finished_at != null)
                                                <button class="btn btn-xs btn-success">Zakończona</button>
                                            @elseif($repair->canceled == true)
                                                <button class="btn btn-xs btn-danger">Anulowana</button>
                                            @elseif(($repair->approved == true) AND (date_create($repair->started_at) < Carbon\Carbon::now()) AND ($repair->suspend == false))
                                                <button class="btn btn-xs btn-primary">Realizowana</button>
                                            @elseif(($repair->approved == true) AND (date_create($repair->started_at) > Carbon\Carbon::now()))
                                                <button class="btn btn-xs btn-info">Nadchodząca</button>
                                            @elseif(($repair->approved == true) AND (date_create($repair->started_at) < Carbon\Carbon::now()) AND ($repair->suspend == true))
                                                <button class="btn btn-xs btn-outline-primary" style="color: primary;">Zawieszona</button>
                                            @else
                                                <button class="btn btn-xs btn-warning" style="color: white;">Oczekująca</button>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $repair->started_at ?? '' }}
                                        </td>
                                        <td>
                                            {{ $repair->finished_at ?? '' }}
                                        </td>
                                        <td>
                                            @can('repair_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.repairs.show', $repair->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endcan
                    @can("Company")

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-striped table-hover datatable datatable-Repair">
                                    <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.car.fields.plates') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.car.fields.vin') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.repair.fields.mileage') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.repair.fields.started_at') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.repair.fields.finished_at') }}
                                        </th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vin_repairs as $key => $repair)
                                        @if($repair->finished_at != null)
                                        <tr data-entry-id="{{ $repair->id }}">
                                            <td>
                                                {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('plates') ?? '' }}
                                            </td>
                                            <td>
                                                {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('vin') ?? '' }}
                                            </td>
                                            <td>
                                                {{ $repair->mileage ?? '' }}
                                            </td>
                                            <td>
                                                {{ $repair->started_at ?? '' }}
                                            </td>
                                            <td>
                                                {{ $repair->finished_at ?? '' }}
                                            </td>
                                            <td>
                                                @can('repair_show')
                                                    <a class="btn btn-xs btn-primary" href="{{ route('frontend.repairs.show', $repair->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endcan
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
            let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
            let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
            let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
            let printButtonTrans = '{{ trans('global.datatables.print') }}'
            let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
            let selectAllButtonTrans = '{{ trans('global.select_all') }}'
            let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

            let languages = {
                'pl': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Polish.json',
                'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
            };

            $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    url: languages['{{ app()->getLocale() }}']
                },
                columnDefs: [{
                    orderable: false,
                    searchable: false,
                    targets: -1
                }],
                select: {
                    style:    'multi+shift',
                    selector: 'td:first-child'
                },
                order: [],
                scrollX: true,
                pageLength: 100,
                dom: 'lBfrtip<"actions">',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn-default',
                        text: copyButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn-default',
                        text: csvButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-default',
                        text: excelButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        text: pdfButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        text: printButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn-default',
                        text: colvisButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });

            $.fn.dataTable.ext.classes.sPageButton = '';
        });

    </script>
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('repair_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('frontend.repairs.massDestroy') }}",
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
                order: [[ 4, 'desc' ]],
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
