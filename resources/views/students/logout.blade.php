@extends('layouts.app')

@section('title', trans('students.title_logout', ['student' => $student->name]))

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <form action="{{ routeBack('students.logout', $student) }}" method="POST">
                    @csrf

                    <table class="table table-twocols">
                        <tr >
                            <td>@lang('students.form.logged_out'):</td>
                            <td>
                                <span class="custom-control custom-radio mr-5 d-inline-block{{ $errors->has('logged_out') ? ' is-invalid' : '' }}">
                                    <input type="radio" id="logged_out_illness" name="logged_out" value="illness" class="custom-control-input" {{ oldChecked('logged_out', 'illness') }} required>
                                    <label class="custom-control-label" for="logged_out_illness">@lang('students.form.illness')</label>
                                </span>
                                <span class="custom-control custom-radio d-inline-block">
                                    <input type="radio" id="logged_out_other" name="logged_out" value="other" class="custom-control-input" {{ oldChecked('logged_out', 'other') }} required>
                                    <label class="custom-control-label" for="logged_out_other">@lang('students.form.other')</label>
                                </span>

                                @error('logged_out')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('logged_out') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr class="js-loggedOutReasonWrap">
                            <td>@lang('students.logout.reason'):<br><small class="muted">@lang('students.form.optional')</small></td>
                            <td>
                                <input name="logged_out_reason" class="form-control{{ $errors->has('logged_out_reason') ? ' is-invalid' : '' }}" id="logged_out_reason" value="{{ old('logged_out_reason', $student->logged_out_reason) }}">
                                @error('logged_out_reason')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('logged_out_reason') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="btn btn-primary" value="@lang('students.form.submit_logout')">
                            </td>
                        </tr>

                    </table>

                </form>
            </div>
        </div>
    </div>
@endsection
