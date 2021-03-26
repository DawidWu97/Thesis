@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.serviceStation.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.service-stations.update", [$serviceStation->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.serviceStation.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                        @foreach($users as $id => $user)
                            <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $serviceStation->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.user_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.serviceStation.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $serviceStation->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.serviceStation.fields.description') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $serviceStation->description) !!}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="phone">{{ trans('cruds.serviceStation.fields.phone') }}</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $serviceStation->phone) }}">
                    @if($errors->has('phone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.phone_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="photo">{{ trans('cruds.serviceStation.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                    </div>
                    @if($errors->has('photo'))
                        <div class="invalid-feedback">
                            {{ $errors->first('photo') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.photo_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="opening">{{ trans('cruds.serviceStation.fields.opening') }}</label>
                    <input class="form-control timepicker {{ $errors->has('opening') ? 'is-invalid' : '' }}" type="text" name="opening" id="opening" value="{{ old('opening', $serviceStation->opening) }}" required>
                    @if($errors->has('opening'))
                        <div class="invalid-feedback">
                            {{ $errors->first('opening') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.opening_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="closing">{{ trans('cruds.serviceStation.fields.closing') }}</label>
                    <input class="form-control timepicker {{ $errors->has('closing') ? 'is-invalid' : '' }}" type="text" name="closing" id="closing" value="{{ old('closing', $serviceStation->closing) }}" required>
                    @if($errors->has('closing'))
                        <div class="invalid-feedback">
                            {{ $errors->first('closing') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.closing_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="workplaces">{{ trans('cruds.serviceStation.fields.workplaces') }}</label>
                    <input class="form-control {{ $errors->has('workplaces') ? 'is-invalid' : '' }}" type="number" name="workplaces" id="workplaces" value="{{ old('workplaces', $serviceStation->workplaces) }}" step="1" required>
                    @if($errors->has('workplaces'))
                        <div class="invalid-feedback">
                            {{ $errors->first('workplaces') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.workplaces_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="city">{{ trans('cruds.serviceStation.fields.city') }}</label>
                    <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $serviceStation->city) }}" required>
                    @if($errors->has('city'))
                        <div class="invalid-feedback">
                            {{ $errors->first('city') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.city_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="street">{{ trans('cruds.serviceStation.fields.street') }}</label>
                    <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', $serviceStation->street) }}" required>
                    @if($errors->has('street'))
                        <div class="invalid-feedback">
                            {{ $errors->first('street') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.street_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="postcode">{{ trans('cruds.serviceStation.fields.postcode') }}</label>
                    <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}" type="text" name="postcode" id="postcode" value="{{ old('postcode', $serviceStation->postcode) }}" required>
                    @if($errors->has('postcode'))
                        <div class="invalid-feedback">
                            {{ $errors->first('postcode') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.postcode_helper') }}</span>
                </div>
                <div class="form-group">
                    <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                        <input type="hidden" name="approved" value="0">
                        <input class="form-check-input" type="checkbox" name="approved" id="approved" value="1" {{ $serviceStation->approved || old('approved', 0) === 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="approved">{{ trans('cruds.serviceStation.fields.approved') }}</label>
                    </div>
                    @if($errors->has('approved'))
                        <div class="invalid-feedback">
                            {{ $errors->first('approved') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.approved_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="categories">{{ trans('cruds.serviceStation.fields.categories') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple>
                        @foreach($categories as $id => $category)
                            <option value="{{ $id }}" {{ (in_array($id, old('categories', [])) || $serviceStation->categories->contains($id)) ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('categories'))
                        <div class="invalid-feedback">
                            {{ $errors->first('categories') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceStation.fields.categories_helper') }}</span>
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
            url: '{{ route('admin.service-stations.storeMedia') }}',
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
