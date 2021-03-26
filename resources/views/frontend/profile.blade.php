@extends('layouts.frontend')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.my_profile') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.profile.update") }}">
                            @csrf
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="required" for="username">{{ trans('cruds.user.fields.username') }}</label>
                                <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username" id="username" value="{{ old('username', auth()->user()->username) }}" required>
                                @if($errors->has('username'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('username') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="required" for="title">{{ trans('cruds.user.fields.phone') }}</label>
                                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                                @if($errors->has('phone'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif
                            </div>
                            <br>
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.change_password') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.profile.password") }}">
                            @csrf
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label class="required" for="password">{{ trans('cruds.user.fields.new_password') }}</label>
                                <input class="form-control" type="password" name="password" id="password" required>
                                @if($errors->has('password'))
                                    <span class="help-block" role="alert">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="required" for="password_confirmation">{{ trans('cruds.user.fields.repeat_new_password') }}</label>
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
                            </div>
                            <div class="form-group mt-4">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.delete_account') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.profile.destroy") }}" onsubmit="return prompt('{{ __('global.delete_account_warning') }}') == '{{ auth()->user()->email }}'">
                            @csrf
                            <div class="form-group mt-2">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.delete') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @can("User")
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.beCompany') }}
                    </div>
                    <div class="card-body mt-3">
                        <button class="btn btn-success approve" type="submit">
                            {{ trans('global.approve') }}
                        </button>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
        <script>
            $(document).ready(function () {
                $('.approve').on('click', function () {

                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                        }
                    })

                    $.ajax({
                        type:'PATCH',
                        data: {"id": {{auth()->user()->id}} },
                        url: '{{ route('frontend.profile.approve') }}',
                        beforeSend: function() {
                            return confirm('{{ trans('global.areYouSure') }}');
                        }
                    })
                        .done(function (response)
                        {
                            window.location.reload();
                        });
                });
            });
        </script>
@endsection
