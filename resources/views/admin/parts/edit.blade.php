@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.part.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.parts.update", [$part->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.part.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $part->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.part.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="price">{{ trans('cruds.part.fields.price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $part->price) }}" step="0.01" required>
                    @if($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.part.fields.price_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="task_id">{{ trans('cruds.part.fields.task') }}</label>
                    <select class="form-control select2 {{ $errors->has('task') ? 'is-invalid' : '' }}" name="task_id" id="task_id">
                        @foreach($tasks as $id => $task)
                            <option value="{{ $id }}" {{ (old('task_id') ? old('task_id') : $part->task->id ?? '') == $id ? 'selected' : '' }}>{{ $task }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('task'))
                        <div class="invalid-feedback">
                            {{ $errors->first('task') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.part.fields.task_helper') }}</span>
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
