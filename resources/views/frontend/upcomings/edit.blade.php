@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.edit') }} {{ trans('cruds.upcoming.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.upcomings.update", [$upcoming->id]) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label class="required" for="car_id">{{ trans('cruds.upcoming.fields.car') }}</label>
                                <select class="form-control select2" name="car_id" id="car_id" required>
                                    @foreach($cars as $id => $car)
                                        <option value="{{ $id }}" {{ (old('car_id') ? old('car_id') : $upcoming->car->id ?? '') == $id ? 'selected' : '' }}>{{ $car }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('car'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('car') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.upcoming.fields.car_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ trans('cruds.upcoming.fields.description') }}</label>
                                <textarea class="form-control ckeditor" name="description" id="description">{!! old('description', $upcoming->description) !!}</textarea>
                                @if($errors->has('description'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.upcoming.fields.description_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="mileage">{{ trans('cruds.upcoming.fields.mileage') }}</label>
                                <input class="form-control" type="number" name="mileage" id="mileage" value="{{ old('mileage', $upcoming->mileage) }}" step="1">
                                @if($errors->has('mileage'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('mileage') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.upcoming.fields.mileage_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="repair_at">{{ trans('cruds.upcoming.fields.repair_at') }}</label>
                                <input class="form-control datetime" type="text" name="repair_at" id="repair_at" value="{{ old('repair_at', $upcoming->repair_at) }}" required>
                                @if($errors->has('repair_at'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('repair_at') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.upcoming.fields.repair_at_helper') }}</span>
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
    <script>
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '/admin/upcomings/ckmedia', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() { reject(genericErrorText) });
                                        xhr.addEventListener('abort', function() { reject() });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({ default: response.url });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $upcoming->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }
        });
    </script>

@endsection
