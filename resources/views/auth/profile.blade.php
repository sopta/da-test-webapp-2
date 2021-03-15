@extends('layouts.app')

@section('extra_wrapper_classes', 'd-flex flex-column justify-content-center')
@section('title', trans('auth.profile.title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-header">
                    <h5>@lang('auth.profile.header')</h5>
                    <p class="small text-muted mb-0">@lang('auth.profile.sub_header')</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('auth.registration.name')</label>

                            <div class="col-md-7">
                                <input id="name" type="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $name ?? '') }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row ">
                            <div class="col-md-8 offset-md-4">
                                <p class="small text-muted mb-1">@lang('auth.profile.fill_password')</p>
                            </div>

                            <label for="password" class="col-md-4 col-form-label text-md-right">@lang('auth.registration.password')</label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('auth.registration.password_confirm')</label>

                            <div class="col-md-7">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('auth.profile.button')
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <div class="form-group row">
                        <label for="access-token" class="col-md-4 col-form-label text-md-right">Access token</label>

                        <div class="col-md-5">
                            <input id="access-token" type="text" class="form-control" readonly onClick="this.setSelectionRange(0, this.value.length)" value="{{ $access_token }}">
                        </div>
                        <div class="col-md-2">
                            <form action="{{ route('profile.access_token') }}" method="POST">
                                @csrf
                                <button class="btn btn-danger">Přegenerovat</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
