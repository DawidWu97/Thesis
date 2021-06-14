@extends('layouts.app')
@section('content')
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
@endsection
@section('scripts')
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
@endsection
