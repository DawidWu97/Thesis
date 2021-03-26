@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.dashboard') }}
                    </div>

                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-white bg-success">
                                    <div class="card-body pb-0">
                                        <div class="text-value">{{count($users)-1}}</div>
                                        <div>Liczba aktywnych użytkowników</div>
                                        <br />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-white bg-success">
                                    <div class="card-body pb-0">
                                        <div class="text-value">{{count($services)}}</div>
                                        <div>Liczba aktywnych warsztatów</div>
                                        <br />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-white bg-success">
                                    <div class="card-body pb-0">
                                        <div class="text-value">{{count($cars)}}</div>
                                        <div>Liczba dodanych samochodów</div>
                                        <br />
                                    </div>
                                </div>
                            </div>

                            @if(count($requests)>0)
                                <div class="col-md-12">
                                    <div class="card text-white bg-info">
                                        <div class="card-body pb-0">
                                            <div class="text-value">{{ count($requests)}}</div>
                                            <div>Wnioski o utworzenie warsztatu</div>
                                            <br />
                                        </div>
                                    </div>
                                    <table class="table table-striped" style="margin-top:-25px;">

                                        @foreach($requests as $serviceStation)
                                            <tr>
                                                <td>
                                                    {{Illuminate\Support\Facades\DB::table('users')->where('id', $serviceStation->user_id)->value('username')}}
                                                </td>
                                                <td>
                                                    {{count($serviceStation->files)}} pliki
                                                </td>
                                                <td>
                                                    {{$serviceStation->created_at}}
                                                </td>
                                                <td>
                                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.user-requests.show', $serviceStation->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                    @can('user_delete')
                                                        <form action="{{ route('admin.user-requests.destroy', $serviceStation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif

                            @if(count($approve_company)>0)
                                <div class="col-md-12">
                                    <div class="card text-white bg-warning">
                                        <div class="card-body pb-0">
                                            <div class="text-value">{{ count($approve_company)}}</div>
                                            <div>Przedsiębiorcy do zaakceptowania</div>
                                            <br />
                                        </div>
                                    </div>
                                    <table class="table table-striped" style="margin-top:-25px;">

                                        @foreach($approve_company as $serviceStation)
                                            <tr>
                                                <td>
                                                    {{$serviceStation->name}}
                                                </td>
                                                <td>
                                                    {{$serviceStation->email}}
                                                </td>
                                                <td>
                                                    {{$serviceStation->username}}
                                                </td>
                                                <td>
                                                    {{$serviceStation->created_at}}
                                                </td>
                                                <td>
                                                    <button class="btn btn-xs btn-success approve" id="{{$serviceStation->id}}approve" style="color:white;">
                                                        {{ trans('global.approve') }}
                                                    </button>
                                                    <button class="btn btn-xs btn-warning cancel" id="{{$serviceStation->id}}cancel" style="color:white;">
                                                        {{ trans('global.cancel') }}
                                                    </button>
                                                    @can('user_delete')
                                                        <form action="{{ route('admin.users.destroy', $serviceStation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif

                            <div class="{{ $chart4->options['column_class'] }}">
                                <h3>{!! $chart4->options['chart_title'] !!}</h3>
                                {!! $chart4->renderHtml() !!}
                            </div>
                            <div class="{{ $chart5->options['column_class'] }}">
                                <h3>{!! $chart5->options['chart_title'] !!}</h3>
                                {!! $chart5->renderHtml() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>{!! $chart4->renderJs() !!}{!! $chart5->renderJs() !!}


    @foreach($approve_company as $a_c)
        <script>
            $(document).ready(function () {

                $('#{{$a_c->id}}approve').on('click', function () {

                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                        }
                    })

                    $.ajax({
                        type:'PATCH',
                        data: {"id": {{$a_c->id}} },
                        url: '{{ route('admin.users.tocompany') }}',
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

                $('#{{$a_c->id}}cancel').on('click', function () {

                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                        }
                    })

                    $.ajax({
                        type:'PATCH',
                        data: {"id": {{$a_c->id}} },
                        url: '{{ route('admin.users.touser') }}',
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
    @endforeach

    @foreach($unactive_users as $a_c)
        <script>
            $(document).ready(function () {
                $('#{{$a_c->id}}users').on('click', function () {

                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                        }
                    })

                    $.ajax({
                        type:'PATCH',
                        data: {"id": {{$a_c->id}} },
                        url: '{{ route('admin.users.approve') }}',
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
    @endforeach

    @foreach($unactive_services as $a_c)
        <script>
            $(document).ready(function () {
                $('#{{$a_c->id}}services').on('click', function () {

                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                        }
                    })

                    $.ajax({
                        type:'PATCH',
                        data: {"id": {{$a_c->id}} },
                        url: '{{ route('admin.service-stations.approve') }}',
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
    @endforeach

@endsection
