@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.serviceStation.title_singular') }}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                @if($serviceStation->photo)
                                    <a href="{{ $serviceStation->photo->getUrl() }}" target="_blank">
                                        <img src="{{ $serviceStation->photo->getUrl() }}" width="100%" height="auto">
                                    </a>
                                @else
                                        <img src="/storage/service_station_default.jpg" width="100%" height="auto">
                                @endif

                                <center>
                                            <ul class="list-group">
                                                <li class="list-group-item"><strong>{{ $serviceStation->name }}</strong></li>
                                                <li class="list-group-item">{{ trans('cruds.serviceStation.fields.phone') }}: {{ $serviceStation->phone }}</li>
                                                <li class="list-group-item">Pon/Pt w godz {{ $serviceStation->opening }} - {{ $serviceStation->closing }}</li>
                                                <li class="list-group-item">{{ trans('cruds.serviceStation.fields.city') }}: {{ $serviceStation->city }}</li>
                                                <li class="list-group-item">{{ trans('cruds.serviceStation.fields.street') }}: {{ $serviceStation->street }}</li>
                                                <li class="list-group-item">{{ trans('cruds.serviceStation.fields.postcode') }}: {{ $serviceStation->postcode }}</li>
                                                <li class="list-group-item">{!! $serviceStation->description !!}</li>
                                            </ul>
                                </center>
                            </div>
                            <div class="col-md-7">
                                @if($serviceStation->user_id == auth()->user()->id)
                                        <div class="d-flex justify-content-between mt-md-0 mt-sm-3 mb-3">
                                            @can('service_station_edit')
                                                <a class="btn btn-info" href="{{ route('frontend.service-stations.edit', $serviceStation->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan
                                                @if($serviceStation->approved == true)
                                                    <button class="btn btn-warning" id="cancel" style="color:white;">
                                                        {{ trans('global.stop') }}
                                                    </button>
                                                @else
                                                    <button class="btn btn-success" id="approve" style="color:white;">
                                                        {{ trans('global.run') }}
                                                    </button>
                                                @endif
                                                @can('service_station_delete')
                                                    <form action="{{ route('frontend.service-stations.destroy', $serviceStation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-danger" value="{{ trans('global.delete') }}">
                                                    </form>
                                                @endcan
                                        </div>
                                @endif
                                @can("User")
                                    @if($serviceStation->approved == true)
                                    <form method="POST" action="{{ route("frontend.repairs.store") }}" enctype="multipart/form-data">
                                        @method('POST')
                                        @csrf
                                        <div class="form-group">
                                            <label class="required" for="car_id">{{ trans('cruds.repair.fields.car') }}</label>
                                            <select class="form-control select2" name="car_id" id="car_id" required>
                                                @foreach($cars as $car)
                                                    <option value="{{ $car->id }}" >{{ $car->plates }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('car'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('car') }}
                                                </div>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.repair.fields.car_helper') }}</span>
                                        </div>
                                        <input type="hidden" name="station_id" id="station_id" value="{{$serviceStation->id}}">
                                        <div class="form-group">
                                            <label for="customer_comments">{{ trans('cruds.repair.fields.customer_comments') }}</label>
                                            <textarea class="form-control ckeditor" name="customer_comments" id="customer_comments">{!! old('customer_comments') !!}</textarea>
                                            @if($errors->has('customer_comments'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('customer_comments') }}
                                                </div>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.repair.fields.customer_comments_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label class="required" for="mileage">{{ trans('cruds.repair.fields.mileage') }}</label>
                                            <input class="form-control" type="number" name="mileage" id="mileage" value="{{ old('mileage', '') }}" step="1" required>
                                            @if($errors->has('mileage'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('mileage') }}
                                                </div>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.repair.fields.mileage_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label class="required" for="started_at">{{ trans('cruds.repair.fields.started_at') }}</label>
                                            <input class="form-control datetime" type="text" name="started_at" id="started_at" value="{{ old('started_at') }}" required>
                                            @if($errors->has('started_at'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('started_at') }}
                                                </div>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.repair.fields.started_at_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-danger" type="submit">
                                                {{ trans('global.save') }}
                                            </button>
                                        </div>
                                    </form>
                                    @endif
                                @endcan
                                @if(auth()->user()->id == $serviceStation->user_id)
                                @can("Company")
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
                                                            Status
                                                        </th>
                                                        <th>
                                                            &nbsp;
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
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($serviceStation->stationRepairs()->get() as $repair)
                                                        @if($repair->canceled == false )
                                                            <tr data-entry-id="{{ $repair->id }}">
                                                                <td>
                                                                    {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('plates') ?? '' }}
                                                                </td>
                                                                <td>
                                                                    {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('vin') ?? '' }}
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
                                                                        <button class="btn btn-xs btn-warning" style="color: white;">Zawieszona</button>
                                                                    @else
                                                                        <button class="btn btn-xs btn-danger" style="color: white;">Oczekująca</button>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @can('repair_show')
                                                                        <a class="btn btn-xs btn-primary" href="{{ route('frontend.repairs.show', $repair->id) }}">
                                                                            {{ trans('global.view') }}
                                                                        </a>
                                                                    @endcan
                                                                    @if($repair->finished_at == null AND $repair->approved == true)
                                                                        @can('repair_edit')
                                                                            <a class="btn btn-xs btn-info" href="{{ route('frontend.repairs.edit', $repair->id) }}">
                                                                                {{ trans('global.edit') }}
                                                                            </a>
                                                                        @endcan
                                                                    @endif
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
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                @endcan
                                @endif
                            </div>
                            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

                            <div id='calendar'></div>
                        </div>
                    </div>
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

            let languages = {
                'pl': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Polish.json',
                'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
            };

            $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    url: languages['{{ app()->getLocale() }}']
                },
                columnDefs: [ {
                    orderable: false,
                    searchable: false,
                    targets: 3
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
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script>
        $(document).ready(function () {
            // page is now ready, initialize the calendar...
            events={!! json_encode($events) !!};
            $('#calendar').fullCalendar({
                monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
                dayNamesShort: ['Nd','Pon','Wt','Śr','Czw','Pt','Sob'],
                events: events,


            })
        });
    </script>
    <script>
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '/admin/repairs/ckmedia', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() { reject(genericErrorText) });
                                        xhr.addEventListener('abort', function() { reject() });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({ default: response.url });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $repair->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }
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
                pageLength: 5,
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
                    data: {"id": {{$serviceStation->id}} },
                    url: '{{ route('frontend.service-stations.approve') }}',
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
                    data: {"id": {{$serviceStation->id}} },
                    url: '{{ route('frontend.service-stations.cancel') }}',

                })
                    .done(function (response)
                    {
                        window.location.reload();
                    });
            });
        });

    </script>

@endsection

