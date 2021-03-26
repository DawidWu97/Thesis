@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.userRequest.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="javascript: history.go(-1)">
                        {{ trans('global.back') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userRequest.fields.id') }}
                        </th>
                        <td>
                            {{ $userRequest->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userRequest.fields.files') }}
                        </th>
                        <td>
                            @foreach($userRequest->files as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ $media->file_name }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $userRequest->user->username ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>

                    @if(count($services)==0)
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.serviceStation.title_singular') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route("admin.service-stations.store") }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="{{$userRequest->user->id}}">
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.serviceStation.fields.name') }}</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.serviceStation.fields.name_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="phone">{{ trans('cruds.serviceStation.fields.phone') }}</label>
                                <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                                @if($errors->has('phone'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.serviceStation.fields.phone_helper') }}</span>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="required" for="opening">{{ trans('cruds.serviceStation.fields.opening') }}</label>
                                    <input class="form-control timepicker" type="text" name="opening" id="opening" value="{{ old('opening') }}" required>
                                    @if($errors->has('opening'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('opening') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.serviceStation.fields.opening_helper') }}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="required" for="closing">{{ trans('cruds.serviceStation.fields.closing') }}</label>
                                    <input class="form-control timepicker" type="text" name="closing" id="closing" value="{{ old('closing') }}" required>
                                    @if($errors->has('closing'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('closing') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.serviceStation.fields.closing_helper') }}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="required" for="workplaces">{{ trans('cruds.serviceStation.fields.workplaces') }}</label>
                                    <input class="form-control" type="number" name="workplaces" id="workplaces" value="{{ old('workplaces', '') }}" step="1" required>
                                    @if($errors->has('workplaces'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('workplaces') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.serviceStation.fields.workplaces_helper') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="required" for="city">{{ trans('cruds.serviceStation.fields.city') }}</label>
                                    <input class="form-control" type="text" name="city" id="city" value="{{ old('city', '') }}" required>
                                    @if($errors->has('city'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('city') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.serviceStation.fields.city_helper') }}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="required" for="street">{{ trans('cruds.serviceStation.fields.street') }}</label>
                                    <input class="form-control" type="text" name="street" id="street" value="{{ old('street', '') }}" required>
                                    @if($errors->has('street'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('street') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.serviceStation.fields.street_helper') }}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="required" for="postcode">{{ trans('cruds.serviceStation.fields.postcode') }}</label>
                                    <input class="form-control" type="text" name="postcode" id="postcode" value="{{ old('postcode', '') }}" required>
                                    @if($errors->has('postcode'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('postcode') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.serviceStation.fields.postcode_helper') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                    @endif

            </div>
        </div>
    </div>



@endsection
