@extends('layouts.app')

@section('title', trans('users.title'))
@section('header', trans('users.breadcrumbs.edit'))

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <form action="{{ routeBack('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <table class="table table-twocols">
                        <tr>
                            <td>@lang('users.form.name'):</td>
                            <td>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>@lang('users.form.email'):</td>
                            <td>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('users.form.role'):</td>
                            <td>
                                <div class="custom-control custom-radio{{ $errors->has('role') ? ' is-invalid' : '' }}">
                                    <input type="radio" id="role-master" name="role" value="master" class="custom-control-input" {{ oldChecked('role', 'master', $user->role) }} required>
                                    <label class="custom-control-label" for="role-master">{{ trans('users.role.master') }}</label>
                                </div>
                                <div class="custom-control custom-radio{{ $errors->has('role') ? ' is-invalid' : '' }}">
                                    <input type="radio" id="role-admin" name="role" value="admin" class="custom-control-input" {{ oldChecked('role', 'admin', $user->role) }} required>
                                    <label class="custom-control-label" for="role-admin">{{ trans('users.role.admin') }}</label>
                                </div>
                                <div class="custom-control custom-radio{{ $errors->has('role') ? ' is-invalid' : '' }}">
                                    <input type="radio" id="role-parent" name="role" value="parent" class="custom-control-input" {{ oldChecked('role', 'parent', $user->role) }} required>
                                    <label class="custom-control-label" for="role-parent">{{ trans('users.role.parent') }}</label>
                                </div>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="bg-light text-center">@lang('users.form.password_change')</td>
                        </tr>

                        <tr>
                            <td>@lang('users.form.password'):</td>
                            <td>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('users.form.password_confirmation'):</td>
                            <td>
                                <input id="password_confirmation" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="btn btn-primary" value="@lang('users.form.submit_update')">
                            </td>
                        </tr>

                    </table>

                </form>
            </div>
        </div>
    </div>
@endsection
