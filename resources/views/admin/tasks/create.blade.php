@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.task.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.tasks.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.task.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.task.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="duration">{{ trans('cruds.task.fields.duration') }}</label>
                    <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="number" name="duration" id="duration" value="{{ old('duration', '') }}" step="0.01" required max="1000">
                    @if($errors->has('duration'))
                        <div class="invalid-feedback">
                            {{ $errors->first('duration') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.task.fields.duration_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="repair_id">{{ trans('cruds.task.fields.repair') }}</label>
                    <select class="form-control select2 {{ $errors->has('repair') ? 'is-invalid' : '' }}" name="repair_id" id="repair_id" required>
                        @foreach($repairs as $id => $repair)
                            <option value="{{ $id }}" {{ old('repair_id') == $id ? 'selected' : '' }}>{{ $repair }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('repair'))
                        <div class="invalid-feedback">
                            {{ $errors->first('repair') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.task.fields.repair_helper') }}</span>
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
