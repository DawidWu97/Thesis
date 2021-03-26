@extends('layouts.app')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card mx-4">
                <div class="card-body p-4">

                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <h1>{{ trans('panel.site_title') }}</h1>
                        <p class="text-muted">{{ trans('global.register') }}</p>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user fa-fw"></i>
                            </span>
                            </div>
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ trans('global.user_name') }}" value="{{ old('name', null) }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user fa-fw"></i>
                            </span>
                            </div>
                            <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ trans('global.user_username') }}" value="{{ old('username', null) }}">
                            @if($errors->has('username'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('username') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-envelope fa-fw"></i>
                            </span>
                            </div>
                            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-phone fa-fw"></i>
                            </span>
                            </div>
                            <input type="phone" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_phone') }}" value="{{ old('phone', null) }}">
                            @if($errors->has('phone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock fa-fw"></i>
                            </span>
                            </div>
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock fa-fw"></i>
                            </span>
                            </div>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="{{ trans('global.login_password_confirmation') }}">
                        </div>

                        <div class="input-group ml-4 mb-3">
                            <input class="form-check-input" type="checkbox" value="true" id="confirm" name="confirm" required>
                            <label class="form-check-label" for="confirm">
                                {{ trans('global.terms_of_service') }}
                            </label>
                            @if($errors->has('confirm'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('confirm') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group ml-4 mb-3">
                            <input class="form-check-input" type="checkbox" value="true" id="company" name="company">
                            <label class="form-check-label" for="company">
                                {{ trans('global.beCompany') }}
                            </label>
                        </div>

                        <button class="btn btn-block btn-primary">
                            {{ trans('global.register') }}
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection
