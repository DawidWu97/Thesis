@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.repair.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.repairs.store") }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="form-group">
                                <label class="required" for="car_id">{{ trans('cruds.repair.fields.car') }}</label>
                                <select class="form-control select2" name="car_id" id="car_id" required>
                                    @foreach($cars as $id => $car)
                                        <option value="{{ $id }}" {{ old('car_id') == $id ? 'selected' : '' }}>{{ $car }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('car'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('car') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.car_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="station_id">{{ trans('cruds.repair.fields.station') }}</label>
                                <select class="form-control select2" name="station_id" id="station_id" required>
                                    @foreach($stations as $id => $station)
                                        <option value="{{ $id }}" {{ old('station_id') == $id ? 'selected' : '' }}>{{ $station }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('station'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('station') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.station_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ trans('cruds.repair.fields.description') }}</label>
                                <textarea class="form-control ckeditor" name="description" id="description">{!! old('description') !!}</textarea>
                                @if($errors->has('description'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.description_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="customer_comments">{{ trans('cruds.repair.fields.customer_comments') }}</label>
                                <textarea class="form-control ckeditor" name="customer_comments" id="customer_comments">{!! old('customer_comments') !!}</textarea>
                                @if($errors->has('customer_comments'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('customer_comments') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.customer_comments_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="mileage">{{ trans('cruds.repair.fields.mileage') }}</label>
                                <input class="form-control" type="number" name="mileage" id="mileage" value="{{ old('mileage', '') }}" step="1" required>
                                @if($errors->has('mileage'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('mileage') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.mileage_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <div>
                                    <input type="hidden" name="approved" value="0">
                                    <input type="checkbox" name="approved" id="approved" value="1" {{ old('approved', 0) == 1 ? 'checked' : '' }}>
                                    <label for="approved">{{ trans('cruds.repair.fields.approved') }}</label>
                                </div>
                                @if($errors->has('approved'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('approved') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.approved_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <div>
                                    <input type="hidden" name="canceled" value="0">
                                    <input type="checkbox" name="canceled" id="canceled" value="1" {{ old('canceled', 0) == 1 ? 'checked' : '' }}>
                                    <label for="canceled">{{ trans('cruds.repair.fields.canceled') }}</label>
                                </div>
                                @if($errors->has('canceled'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('canceled') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.canceled_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="started_at">{{ trans('cruds.repair.fields.started_at') }}</label>
                                <input class="form-control datetime" type="text" name="started_at" id="started_at" value="{{ old('started_at') }}" required>
                                @if($errors->has('started_at'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('started_at') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.started_at_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="calculated_finish">{{ trans('cruds.repair.fields.calculated_finish') }}</label>
                                <input class="form-control datetime" type="text" name="calculated_finish" id="calculated_finish" value="{{ old('calculated_finish') }}">
                                @if($errors->has('calculated_finish'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('calculated_finish') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.calculated_finish_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="finished_at">{{ trans('cruds.repair.fields.finished_at') }}</label>
                                <input class="form-control datetime" type="text" name="finished_at" id="finished_at" value="{{ old('finished_at') }}">
                                @if($errors->has('finished_at'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('finished_at') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.finished_at_helper') }}</span>
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
                                        xhr.open('POST', '/admin/repairs/ckmedia', true);
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
                                        data.append('crud_id', '{{ $repair->id ?? 0 }}');
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
