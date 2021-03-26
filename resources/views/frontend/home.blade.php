@extends('layouts.frontend')
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


                            @can('User')
                                <div class="m-0 research">
                                    <div class="row no-gutters m-0" style="padding-top: 7rem;">
                                        <div class="col-md-4" >
                                            <div class="p-2" style="background-color: white; opacity:0.8;">
                                                <center><i class="c-sidebar-nav-icon fas fa-fw fa-calendar"></i></center>
                                            <div class="d-flex justify-content-between">
                                                <div class="col-6" style="background-color: white;">
                                                    <input class="form-check-input" type="radio" name="radiobutton" id="fastest" checked>
                                                    <label style="color:black;" class="form-check-label" for="fastest" id="fastest_label">
                                                        Najszybciej
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <input class="form-check-input" type="radio" name="radiobutton" id="possible">
                                                    <input disabled style="height: 1.64rem;" class="form-control" type="date" name="start" id="start" placeholder="Wybierz date">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-2" style="background-color: white; opacity:0.8;">
                                                <center><i class="c-sidebar-nav-icon fas fa-fw fa-tag"></i></center>

                                            <select class="categories">
                                                @foreach(App\Models\Category::all()->pluck('name', 'id') as $id => $category)
                                                    <option value="{{ $id }}">{{ $category }}</option>
                                                @endforeach
                                            </select>
                                            </div>

                                        </div>
                                        <div class="col-md-5">
                                            <div class="p-2" style="background-color: white; opacity:0.8;">
                                                <center><i class="c-sidebar-nav-icon fas fa-fw fa-search"></i></center>

                                                <select class="searchable-field">
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-4 atm_parent">
                                        <div class="card text-white bg-info">
                                            <div class="card-body pb-0">
                                                <div class="text-value">{{ count($user_repairs_active)}}<div class="d-flex justify-content-end"><i class="fas fa-fw fa-bars"></i></div></div>
                                                <div>Bieżące naprawy</div>
                                                <br />
                                            </div>
                                        </div>
                                        <table class="table table-striped atm" style="margin-top:-25px;">

                                            @foreach($user_repairs_active as $repair)
                                                <tr class="row m-0 align-items-center text-center">
                                                    <td class="col-md-2">
                                                        {{ Illuminate\Support\Facades\DB::table('service_stations')->where('id', $repair->station_id)->value('name') ?? '' }}
                                                    </td>
                                                    <td class="col-md-2">
                                                        {{$repair->car->plates ?? '' }}
                                                    </td>
                                                    <td class="col-md-2">
                                                        {{$repair->started_at}}
                                                    </td>
                                                    <td class="col-md-2">
                                                        {{$repair->calculated_finish}}
                                                    </td>
                                                    <td class="col-md-2">
                                                        @if($repair->finished_at != null)
                                                            <button class="btn btn-xs btn-success">Zakończona</button>
                                                        @elseif($repair->canceled == true)
                                                            <button class="btn btn-xs btn-danger">Anulowana</button>
                                                        @elseif(($repair->approved == true) AND (date_create($repair->started_at) < Carbon\Carbon::now()) AND ($repair->suspend == false))
                                                            <button class="btn btn-xs btn-success">Realizowana</button>
                                                        @elseif(($repair->approved == true) AND (date_create($repair->started_at) > Carbon\Carbon::now()))
                                                            <button class="btn btn-xs btn-info">Nadchodząca</button>
                                                        @elseif(($repair->approved == true) AND (date_create($repair->started_at) < Carbon\Carbon::now()) AND ($repair->suspend == true))
                                                            <button class="btn btn-xs btn-warning" style="color: white;">Zawieszona</button>
                                                        @else
                                                            <button class="btn btn-xs btn-danger" style="color: white;">Oczekująca</button>
                                                        @endif
                                                    </td>
                                                    <td class="col-md-2">
                                                        <a class="btn btn-xs btn-primary" href="{{ route('frontend.repairs.show', $repair->id) }}">
                                                            {{ trans('global.view') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="col-md-12 wait_parent">
                                        <div class="card text-white bg-warning">
                                            <div class="card-body pb-0">
                                                <div class="text-value">{{ count($user_repairs_waiting)}}<div class="d-flex justify-content-end"><i class="fas fa-fw fa-bars"></i></div></div>
                                                <div>Naprawy oczekujące na akceptacje</div>
                                                <br />
                                            </div>
                                        </div>
                                        <table class="table table-striped waiting" style="margin-top:-25px;">

                                            @foreach($user_repairs_waiting as $a_c_repair)
                                                <tr class="row m-0 align-items-center text-center">
                                                    <td class="col-md-3">
                                                        {{ Illuminate\Support\Facades\DB::table('service_stations')->where('id', $a_c_repair->station_id)->value('name') ?? '' }}
                                                    </td>
                                                    <td class="col-md-3">
                                                        {{$a_c_repair->car->plates ?? '' }}
                                                    </td>
                                                    <td class="col-md-3">
                                                        {{$a_c_repair->started_at}}
                                                    </td>
                                                    <td class="col-md-3">
                                                        <a class="btn btn-xs btn-primary" href="{{ route('frontend.repairs.show', $a_c_repair->id) }}">
                                                            {{ trans('global.view') }}
                                                        </a>
                                                        <button class="btn btn-xs btn-danger cancel" id="{{$a_c_repair->id}}cancel" style="color:white;">
                                                            {{ trans('global.cancel') }}
                                                        </button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="col-md-12 up_parent">
                                        <div class="card text-white bg-primary">
                                            <div class="card-body pb-0">
                                                <div class="text-value">{{ count($upcomings)}}<div class="d-flex justify-content-end"><i class="fas fa-fw fa-bars"></i></div></div>
                                                <div>Nadchodzące naprawy</div>
                                                <br />
                                            </div>
                                        </div>
                                        <table class="table table-striped upcomings" style="margin-top:-25px;">

                                            @foreach($upcomings as $a_c_repair)
                                                <tr class="row m-0 align-items-center text-center">
                                                    <td class="col-md-3">
                                                        {{$a_c_repair->car->plates }}
                                                    </td>
                                                    <td class="col-md-3">
                                                        {{$a_c_repair->mileage}}km
                                                    </td>
                                                    <td class="col-md-3">
                                                        {{$a_c_repair->repair_at}}
                                                    </td>
                                                    <td class="col-md-3">
                                                        <a class="btn btn-xs btn-primary" href="{{ route('frontend.upcomings.show', $a_c_repair->id) }}">
                                                            {{ trans('global.view') }}
                                                        </a>

                                                        <form action="{{ route('frontend.upcomings.destroy', $a_c_repair->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            @endcan


                            @can('Company')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card text-white bg-primary">
                                            <div class="card-body pb-0">
                                                <div class="text-value">{{ count($repairs_count)}}</div>
                                                <div>
                                                    Zakończone naprawy
                                                </div>
                                                <br />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card text-white bg-primary">
                                            <div class="card-body pb-0">
                                                <div class="text-value">{{$count}}</div>
                                                <div>
                                                    Naprawione samochody
                                                </div>
                                                <br />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 during_parent">
                                        <div class="card text-white bg-success">
                                            <div class="card-body pb-0">
                                                <div class="text-value">{{ count($active_repairs)}}<div class="d-flex justify-content-end"><i class="fas fa-fw fa-bars"></i></div></div>
                                                <div>Trwające naprawy</div>
                                                <br />
                                            </div>
                                        </div>
                                        <table class="table table-striped during" style="margin-top:-25px;">

                                            @foreach($active_repairs as $repair)
                                                    <tr class="row m-0 align-items-center text-center">
                                                        <td class="col-md-2">
                                                            {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('plates') ?? '' }}
                                                        </td>
                                                        <td class="col-md-2 offset-md-1">
                                                            {{$repair->started_at}}
                                                        </td>
                                                        <td class="col-md-2">
                                                            {{$repair->calculated_finish}}
                                                        </td>
                                                        <td class="col-md-2 offset-md-1">
                                                            @if($repair->finished_at != null)
                                                                <button class="btn btn-xs btn-success">Zakończona</button>
                                                            @elseif($repair->canceled == true)
                                                                <button class="btn btn-xs btn-danger">Anulowana</button>
                                                            @elseif(($repair->approved == true) AND (date_create($repair->started_at) < Carbon\Carbon::now()) AND ($repair->suspend == false))
                                                                <button class="btn btn-xs btn-success">Realizowana</button>
                                                            @elseif(($repair->approved == true) AND (date_create($repair->started_at) > Carbon\Carbon::now()))
                                                                <button class="btn btn-xs btn-info">Nadchodząca</button>
                                                            @elseif(($repair->approved == true) AND (date_create($repair->started_at) < Carbon\Carbon::now()) AND ($repair->suspend == true))
                                                                <button class="btn btn-xs btn-warning" style="color: white;"> Zawieszona </button>
                                                            @else
                                                                <button class="btn btn-xs btn-danger" style="color: white;">Oczekująca</button>
                                                            @endif
                                                        </td>
                                                        <td class="col-md-2">
                                                            <a class="btn btn-xs btn-primary" href="{{ route('frontend.repairs.show', $repair->id) }}">
                                                                {{ trans('global.view') }}
                                                            </a>
                                                            <a class="btn btn-xs btn-info" href="{{ route('frontend.repairs.edit', $repair->id) }}">
                                                                {{ trans('global.edit') }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        </table>
                                    </div>

                                    <div class="col-md-12 planned_parent">
                                        <div class="card text-white bg-info">
                                            <div class="card-body pb-0">
                                                <div class="text-value">{{ count($planned_repairs)}}<div class="d-flex justify-content-end"><i class="fas fa-fw fa-bars"></i></div></div>
                                                <div>Zaplanowane naprawy</div>
                                                <br />
                                            </div>
                                        </div>
                                        <table class="table table-striped planned" style="margin-top:-25px;">

                                            @foreach($planned_repairs as $repair)
                                                <tr class="row m-0 align-items-center text-center">
                                                    <td class="col-md-3">
                                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $repair->car_id)->value('plates') ?? '' }}
                                                    </td>
                                                    <td class="col-md-3">
                                                        {{$repair->started_at}}
                                                    </td>
                                                    <td class="col-md-3">
                                                        {{$repair->calculated_finish}}
                                                    </td>
                                                    <td class="col-md-3">
                                                        <a class="btn btn-xs btn-primary" href="{{ route('frontend.repairs.show', $repair->id) }}">
                                                            {{ trans('global.view') }}
                                                        </a>
                                                        <a class="btn btn-xs btn-info" href="{{ route('frontend.repairs.edit', $repair->id) }}">
                                                            {{ trans('global.edit') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        </div>

                                    <div class="col-md-12 m-0 accept_parent">
                                        <div class="card text-white bg-warning">
                                            <div class="card-body pb-0">
                                                <div class="text-value">{{ count($approvable_repairs)}}<div class="d-flex justify-content-end"><i class="fas fa-fw fa-bars"></i></div></div>
                                                <div>Naprawy do zaakceptowania</div>
                                                <br />
                                            </div>
                                        </div>
                                        <table class="table table-striped accept_child" style="margin-top:-25px;">

                                            @foreach($approvable_repairs as $a_c_repair)
                                                <tr class="row m-0 align-items-center text-center">
                                                    <td class="col-md-4">
                                                        {{ Illuminate\Support\Facades\DB::table('cars')->where('id', $a_c_repair->car_id)->value('plates') ?? '' }}
                                                    </td>
                                                    <td class="col-md-4">
                                                        {{$a_c_repair->started_at}}
                                                    </td>
                                                    <td class="col-md-4">
                                                        <a class="btn btn-xs btn-primary" href="{{ route('frontend.repairs.show', $a_c_repair->id) }}">
                                                            {{ trans('global.view') }}
                                                        </a>
                                                        @if(date_create($a_c_repair->started_at) > Carbon\Carbon::now())
                                                        <button class="btn btn-xs btn-success approve" id="{{$a_c_repair->id}}approve" style="color:white;">
                                                            {{ trans('global.approve') }}
                                                        </button>
                                                        @endif
                                                        <button class="btn btn-xs btn-danger cancel" id="{{$a_c_repair->id}}cancel" style="color:white;">
                                                            {{ trans('global.cancel') }}
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div></div>
                                </div>
                            @endcan
                            @can("Between")
                                <div class="col-md-12">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0">
                                            <div class="text-value"></div>
                                            <div>
                                                Aplikowałeś do roli przedsiębiorcy
                                                <br>
                                                Gratulujemy wyboru
                                                <br>
                                                Oczekuj potwierdzenia twojego zapytania
                                            </div>
                                            <br />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card text-white bg-info">
                                        <div class="card-body pb-0">
                                            <div class="text-value"></div>
                                            <div>
                                                Jeśli operacja ta została wykonana przez błąd lub pomyłkę
                                                <br>
                                                Kliknij poniższy przycisk
                                                <br><br>
                                                <button class="btn btn-outline-danger cancel" id="{{auth()->user()->id}}back" style="color:red;">
                                                    {{ trans('global.cancel') }}
                                                </button>
                                            </div>
                                            <br />
                                        </div>
                                    </div>
                                </div>
                            @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>

    $('#possible').click(function() {
        if($('#start').prop('disabled', true))
        {
            $('#start').prop('disabled', false);
        }
    });

    $('#fastest').click(function() {
        if($('#fastest').is(':checked'))
        {
            $('#start').prop('disabled', true);
        }
    });

    $(".atm").hide();
    $(".waiting").hide();
    $(".upcomings").hide();

    $(".atm_parent").click(function(){
        if ($(".atm").is(":hidden")) {
            $(".waiting").hide();
            $('.upcomings').hide();
            $(this).children().show();
        } else {
            $('.atm').hide();
        }
    });

    $(".wait_parent").click(function(){
        if ($(".waiting").is(":hidden")) {
            $(".atm").hide();
            $('.upcomings').hide();
            $(this).children().show();
        } else {
            $('.waiting').hide();
        }
    });

    $(".up_parent").click(function(){
        if ($(".upcomings").is(":hidden")) {
            $(".atm").hide();
            $('.waiting').hide();
            $(this).children().show();
        } else {
            $('.upcomings').hide();
        }
    });

    $(".during").hide();
    $('.planned').hide();
    $('.accept_child').hide();

    $(".planned_parent").click(function(){
        if ($(".planned").is(":hidden")) {
        $(".during").hide();
        $('.accept_child').hide();
        $(this).children().show();
        } else {
            $('.planned').hide();
        }
    });

    $(".during_parent").click(function(){
        if ($(".during").is(":hidden")) {
        $(".planned").hide();
        $('.accept_child').hide();
        $(this).children().show();
        } else {
            $('.during').hide();
        }
    });

    $(".accept_parent").click(function(){
        if ($(".accept_child").is(":hidden")) {
        $(".planned").hide();
        $(".during").hide();
        $(this).children().show();
         } else
        {
        $('.accept_child').hide();
          }
    });
</script>
   @foreach($approvable_repairs as $a_c_repair)
    <script>

        $(document).ready(function () {
            $('#{{$a_c_repair->id}}approve').on('click', function () {

                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                    }
                })

                $.ajax({
                    type:'PATCH',
                    data: {"id": {{$a_c_repair->id}} },
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
            $('#{{$a_c_repair->id}}cancel').on('click', function () {

                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                    }
                })

                $.ajax({
                    type:'PATCH',
                    data: {"id": {{$a_c_repair->id}} },
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
    @endforeach

       @foreach($user_repairs_waiting as $a_c_repair)
           <script>$(document).ready(function () {
                   $('#{{$a_c_repair->id}}cancel').on('click', function () {

                       $.ajaxSetup({
                           headers:{
                               'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                           }
                       })

                       $.ajax({
                           type:'PATCH',
                           data: {"id": {{$a_c_repair->id}} },
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
    @endforeach
       <script>
           $(document).ready(function () {
               $('#{{auth()->user()->id}}back').on('click', function () {

                   $.ajaxSetup({
                       headers:{
                           'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                       }
                   })

                   $.ajax({
                       type:'PATCH',
                       data: {"id": {{auth()->user()->id}} },
                       url: '{{ route('frontend.users.touser') }}',
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
