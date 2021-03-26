@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.part.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.parts.store") }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.part.fields.name') }}</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.part.fields.name_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="price">{{ trans('cruds.part.fields.price') }}</label>
                                <input class="form-control" type="number" name="price" id="price" value="{{ old('price', '') }}" step="0.01" required>
                                @if($errors->has('price'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('price') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.part.fields.price_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="task_id">{{ trans('cruds.part.fields.task') }}</label>
                                <select class="form-control select2" name="task_id" id="task_id">
                                    @foreach($tasks as $id => $task)
                                        <option value="{{ $id }}" {{ old('task_id') == $id ? 'selected' : '' }}>{{ $task }}</option>
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

            </div>
        </div>
    </div>
@endsection
