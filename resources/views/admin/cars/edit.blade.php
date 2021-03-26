@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.car.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.cars.update", [$car->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="brand">{{ trans('cruds.car.fields.brand') }}</label>
                    <input class="form-control {{ $errors->has('brand') ? 'is-invalid' : '' }}" type="text" name="brand" id="brand" value="{{ old('brand', $car->brand) }}" required>
                    @if($errors->has('brand'))
                        <div class="invalid-feedback">
                            {{ $errors->first('brand') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.car.fields.brand_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="model">{{ trans('cruds.car.fields.model') }}</label>
                    <input class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" type="text" name="model" id="model" value="{{ old('model', $car->model) }}" required>
                    @if($errors->has('model'))
                        <div class="invalid-feedback">
                            {{ $errors->first('model') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.car.fields.model_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="engine">{{ trans('cruds.car.fields.engine') }}</label>
                    <input class="form-control {{ $errors->has('engine') ? 'is-invalid' : '' }}" type="text" name="engine" id="engine" value="{{ old('engine', $car->engine) }}" required>
                    @if($errors->has('engine'))
                        <div class="invalid-feedback">
                            {{ $errors->first('engine') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.car.fields.engine_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="vin">{{ trans('cruds.car.fields.vin') }}</label>
                    <input class="form-control {{ $errors->has('vin') ? 'is-invalid' : '' }}" type="text" name="vin" id="vin" value="{{ old('vin', $car->vin) }}" required>
                    @if($errors->has('vin'))
                        <div class="invalid-feedback">
                            {{ $errors->first('vin') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.car.fields.vin_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="plates">{{ trans('cruds.car.fields.plates') }}</label>
                    <input class="form-control {{ $errors->has('plates') ? 'is-invalid' : '' }}" type="text" name="plates" id="plates" value="{{ old('plates', $car->plates) }}" required>
                    @if($errors->has('plates'))
                        <div class="invalid-feedback">
                            {{ $errors->first('plates') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.car.fields.plates_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.car.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                        @foreach($users as $id => $user)
                            <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $car->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.car.fields.user_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="bought_mileage">{{ trans('cruds.car.fields.bought_mileage') }}</label>
                    <input class="form-control {{ $errors->has('bought_mileage') ? 'is-invalid' : '' }}" type="number" name="bought_mileage" id="bought_mileage" value="{{ old('bought_mileage', $car->bought_mileage) }}" step="1" required>
                    @if($errors->has('bought_mileage'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bought_mileage') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.car.fields.bought_mileage_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="bought_at">{{ trans('cruds.car.fields.bought_at') }}</label>
                    <input class="form-control datetime {{ $errors->has('bought_at') ? 'is-invalid' : '' }}" type="text" name="bought_at" id="bought_at" value="{{ old('bought_at', $car->bought_at) }}" required>
                    @if($errors->has('bought_at'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bought_at') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.car.fields.bought_at_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection
