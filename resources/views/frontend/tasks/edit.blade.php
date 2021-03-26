@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.edit') }} {{ trans('cruds.task.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.tasks.update", [$task->id]) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.task.fields.name') }}</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $task->name) }}" required>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.name_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="duration">{{ trans('cruds.task.fields.duration') }}</label>
                                <input class="form-control" type="number" name="duration" id="duration" value="{{ old('duration', $task->duration) }}" step="0.01" required max="1000">
                                @if($errors->has('duration'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('duration') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.duration_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="repair_id">{{ trans('cruds.task.fields.repair') }}</label>
                                <select class="form-control select2" name="repair_id" id="repair_id" required>
                                    @foreach($repairs as $id => $repair)
                                        <option value="{{ $id }}" {{ (old('repair_id') ? old('repair_id') : $task->repair->id ?? '') == $id ? 'selected' : '' }}>{{ $repair }}</option>
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

            </div>
        </div>
    </div>
@endsection
