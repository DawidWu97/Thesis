@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.car.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.cars.store") }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="row">
                            <div class="form-group col-md-4">
                                <label class="required" for="brand">{{ trans('cruds.car.fields.brand') }}</label>
                                <input class="form-control" type="text" name="brand" id="brand" value="{{ old('brand', '') }}" required>
                                @if($errors->has('brand'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('brand') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.car.fields.brand_helper') }}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="required" for="model">{{ trans('cruds.car.fields.model') }}</label>
                                <input class="form-control" type="text" name="model" id="model" value="{{ old('model', '') }}" required>
                                @if($errors->has('model'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('model') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.car.fields.model_helper') }}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="required" for="engine">{{ trans('cruds.car.fields.engine') }}</label>
                                <input class="form-control" type="text" name="engine" id="engine" value="{{ old('engine', '') }}" required>
                                @if($errors->has('engine'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('engine') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.car.fields.engine_helper') }}</span>
                            </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6">
                                <label class="required" for="vin">{{ trans('cruds.car.fields.vin') }}</label>
                                <input class="form-control" type="text" name="vin" id="vin" value="{{ old('vin', '') }}" required>
                                @if($errors->has('vin'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('vin') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.car.fields.vin_helper') }}</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="required" for="plates">{{ trans('cruds.car.fields.plates') }}</label>
                                <input class="form-control" type="text" name="plates" id="plates" value="{{ old('plates', '') }}" required>
                                @if($errors->has('plates'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('plates') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.car.fields.plates_helper') }}</span>
                            </div>
                            </div>
                            <input type="hidden" id="user_id" name="user_id" value="{{auth()->user()->id}}">
                            <div class="row">
                            <div class="form-group col-md-6">
                                <label class="required" for="bought_mileage">{{ trans('cruds.car.fields.bought_mileage') }}</label>
                                <input class="form-control" type="number" name="bought_mileage" id="bought_mileage" value="{{ old('bought_mileage', '') }}" step="1" required>
                                @if($errors->has('bought_mileage'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bought_mileage') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.car.fields.bought_mileage_helper') }}</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="required" for="bought_at">{{ trans('cruds.car.fields.bought_at') }}</label>
                                <input class="form-control datetime" type="text" name="bought_at" id="bought_at" value="{{ old('bought_at') }}" required>
                                @if($errors->has('bought_at'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bought_at') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.car.fields.bought_at_helper') }}</span>
                            </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                </div>

            </div>
        </div>
        </div>
    </div>
@endsection
@section('scripts')
{{--            <script>
                $(document).ready(function () {
                    $('.datetime').on('mouseleave', function () {
                        var now = new Date();

                        if(now.getDay()<28) {
                            var day = now.getDay() + 1;
                            var month = now.getMonth() + 1;
                            var valid = '0' + day + '-0' + month + '-' + now.getFullYear() + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
                            var data = $('.datetime').val().toString();
                            if ($('.datetime').val() < valid.toString()) {
                                window.alert('Data zakupu oznacza date w przeszłości');
                                $('.datetime').val("01-01-2000 00:01:01");
                            }
                        }
                    })
                })
            </script>--}}
    <script>
        $(document).ready(function () {
            $('#bought_mileage').on('mouseleave', function () {

                if($('#bought_mileage').val() < 1) {
                    window.alert("Przebieg nie może być ujemną liczbą");
                    $('#bought_mileage').val(100);
                }
            });
        });
    </script>
@endsection
