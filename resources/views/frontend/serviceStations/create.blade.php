@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.serviceStation.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.service-stations.store") }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
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
                                <label for="description">{{ trans('cruds.serviceStation.fields.description') }}</label>
                                <textarea class="form-control ckeditor" name="description" id="description">{!! old('description') !!}</textarea>
                                @if($errors->has('description'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.serviceStation.fields.description_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="photo">{{ trans('cruds.serviceStation.fields.photo') }}</label>
                                <div class="needsclick dropzone" id="photo-dropzone">
                                </div>
                                @if($errors->has('photo'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('photo') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.serviceStation.fields.photo_helper') }}</span>
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
            $('#closing').on('mouseleave', function () {

                if($('#closing').val() < $('#opening').val()) {
                    window.alert("Nie mozna zamknac warsztatu przed jego otwarciem");
                    var value = $('#opening').val();
                    $('#closing').val(value);
                }
            });
        });
        $(document).ready(function () {
            $('#workplaces').on('mouseleave', function () {

                if($('#workplaces').val() < 1) {
                    window.alert("Nie mozna utworzyc ujemnej liczby stanowisk");
                    $('#workplaces').val(1);
                }
            });
        });
        $(document).ready(function () {
            $('#opening').on('mouseleave', function () {

                if($('#closing').val() < $('#opening').val()) {
                    window.alert("Nie mozna zamknac warsztatu przed jego otwarciem");
                    var value = $('#opening').val();
                    $('#closing').val(value);
                }
            });
        });
    </script>
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
                                        xhr.open('POST', '/admin/service-stations/ckmedia', true);
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
                                        data.append('crud_id', '{{ $serviceStation->id ?? 0 }}');
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

    <script>
        Dropzone.options.photoDropzone = {
            url: '{{ route('frontend.service-stations.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="photo"]').remove()
                $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="photo"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                @if(isset($serviceStation) && $serviceStation->photo)
                var file = {!! json_encode($serviceStation->photo) !!}
                    this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection
