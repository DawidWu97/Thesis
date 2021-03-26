<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @yield('styles')
    <style>
        body {
            font-family: 'Nunito';
            background: RGB(235, 237, 239) no-repeat fixed center;
        }
    </style>
</head>
<body class="antialiased">
<!--<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
    -->
<div>
    <div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

        <div class="c-navbar-brand">
            <a class="c-navbar-brand" href="{{ route("welcome") }}">
                <img src="/storage/datecar_logo.jpg" width="100%" height="auto">
            </a>
        </div>

        <ul class="c-sidebar-nav">
            @auth
            <li class="c-sidebar-nav-item">
                <a href="{{ route("frontend.home") }}" class="c-sidebar-nav-link">
                    <i class="c-sidebar-nav-icon fas fa-fw fa-home">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @can('Admin')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                        <i class="c-sidebar-nav-icon fas fa-fw fa-user-shield">

                        </i>
                        Admin Panel
                    </a>
                </li>
            @endcan
                <li class="c-sidebar-nav-item">
                    <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                        </i>
                        {{ trans('global.logout') }}
                    </a>
                </li>
            @else
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("login") }}" class="c-sidebar-nav-link">
                        <i class="c-sidebar-nav-icon fas fa-sign-in-alt">

                        </i>
                        {{ trans('global.login') }}
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("register") }}" class="c-sidebar-nav-link">
                        <i class="c-sidebar-nav-icon fas fa-user-plus">

                        </i>
                        {{ trans('global.register') }}
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <div class="c-wrapper">
        <header class="c-header c-header-fixed px-3">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                <i class="fas fa-fw fa-bars"></i>
            </button>

            <a class="c-header-brand d-lg-none" href="#">{{ trans('panel.site_title') }}</a>

            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                <i class="fas fa-fw fa-bars"></i>
            </button>

            <ul class="c-header-nav ml-auto">
                @if(count(config('panel.available_languages', [])) > 1)
                    <li class="c-header-nav-item dropdown">
                        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ strtoupper(app()->getLocale()) }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @foreach(config('panel.available_languages') as $langLocale => $langName)
                                <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                            @endforeach
                        </div>
                    </li>
                @endif

                @auth
                <ul class="c-header-nav ml-auto">
                    <li class="c-header-nav-item dropdown notifications-menu">
                        <a href="" class="c-header-nav-link" data-toggle="dropdown">
                            <i class="far fa-bell"></i>
                            @php($alertsCount = \Auth::user()->userUserAlerts()->where('read', false)->count())
                            @if($alertsCount > 0)
                                <span class="badge badge-warning navbar-badge">
                                        {{ $alertsCount }}
                            </span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            @if(count($alerts = \Auth::user()->userUserAlerts()->withPivot('read')->limit(25)->orderBy('created_at', 'ASC')->get()->reverse()) > 0)
                                @foreach($alerts as $alert)
                                    <div class="dropdown-item">
                                        <a href="{{ $alert->alert_link ? $alert->alert_link : "#" }}" target="_blank" rel="noopener noreferrer">
                                            @if($alert->pivot->read === 0) <strong> @endif
                                                {{ $alert->alert_text }}
                                                @if($alert->pivot->read === 0) </strong> @endif
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center">
                                    {{ trans('global.no_alerts') }}
                                </div>
                            @endif
                        </div>
                    </li>
                </ul>
                @endcan
            </ul>
        </header>

        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    @if(session('message'))
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                            </div>
                        </div>
                    @endif
                    @if($errors->count() > 0)
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                        <div class="content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">

                                        <div class="card-body">
                                            @if(session('status'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ session('status') }}
                                                </div>
                                            @endif


                                                <div id="carouselExampleIndicators" class="carousel slide d-none d-sm-block" data-ride="carousel">
                                                    <ol class="carousel-indicators">
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                                    </ol>
                                                    <div class="carousel-inner">
                                                        <div class="carousel-item active">
                                                            <img class="d-block w-100" src="/storage/slide1.jpg" >
                                                            <div class="carousel-caption d-none d-sm-block" style="background-color: black; opacity:0.8;"s>
                                                                <h4>Zarządzaj swoim warsztatem</h4>
                                                                <p>Wszystkie naprawy w jednym miejscu<br>Terminowe planowanie<br>Kalendarz napraw</p>
                                                            </div>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img class="d-block w-100" src="/storage/slide2.jpg" >
                                                            <div class="carousel-caption d-none d-sm-block" style="background-color: black; opacity:0.8;">
                                                                <h4>Zarządzaj swoimi pojazdami</h4>
                                                                <p>Wszystkie naprawy w jednym miejscu<br>Informacje o naprawie w czasie rzeczywistym<br>Inteligentna wyszukiwarka warsztatów</p>
                                                            </div>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img class="d-block w-100" src="/storage/slide3.jpg" >
                                                            <div class="carousel-caption d-none d-sm-block" style="background-color: black; opacity:0.8;">
                                                                <h4>Nowoczesny sposób komunikacji</h4>
                                                                <p>Powiadomienia o zmianach statusu naprawy<br>Podgląd wszystkich poprzednich napraw</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    </a>
                                                </div>
                                            <div class="card">
                                                <div class="card-header d-flex new_head">
                                                    <h4 class="col-12">Najnowsze warsztaty</h4>
                                                    <a class="fas fa-fw fa-bars"></a>
                                                </div>
                                                <div class="row m-0 newest">
                                                 @foreach($items as $item)
                                                <div class="card col-lg-3">
                                                    @if($item->photo !=null)
                                                        <img class="card-img-top" src="{{ $item->photo->getUrl()}}" width="100%" height="auto">
                                                    @else
                                                        <img class="card-img-top" src="/storage/service_station_default.jpg" width="100%" height="auto">
                                                    @endif
                                                        <div class="card-body">
                                                        <h5 class="card-title font-weight-bold">{{$item->name}}</h5>
                                                        <p class="card-text">{!! $item->description !!}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </main>
            <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>

</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
    <script src="https://unpkg.com/@coreui/coreui@3.2/dist/js/coreui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        $(".newest").hide();

        $(".new_head").click(function(){
            if ($(".newest").is(":hidden")) {
                $(".newest").show();
            } else {
                $('.newest').hide();
            }
        });
    </script>
</body>
</html>
