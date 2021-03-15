@extends('layouts.app')

@section('title', trans('students.title_edit', ['student' => $student->name]))

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">

                <form action="{{ routeBack('students.update', $student) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <table class="table table-twocols">
                        <tr>
                            <td>@lang('students.form.term'):</td>
                            <td>
                                <strong>{{ $student->term->term_range }}</strong><br>{{ $student->term->category->name }}
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('students.form.parent_name'):</td>
                            <td>
                                <input id="parent_name" type="text" class="form-control{{ $errors->has('parent_name') ? ' is-invalid' : '' }}" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}" required>
                                @error('parent_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('parent_name') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('students.form.forename'):</td>
                            <td>
                                <input id="forename" type="text" class="form-control" name="forename" value="{{ $student->forename }}" readonly>
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('students.form.surname'):</td>
                            <td>
                                <input id="surname" type="text" class="form-control" name="surname" value="{{ $student->surname }}" readonly>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                @lang('students.form.birthday'):<br>
                                <small class="text-muted">@lang('students.form.birthday_note', ['years' => config('czechitas.student.minimum_age_term_starts')])</small>
                            </td>
                            <td>
                                <input id="birthday" type="text" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" name="birthday" value="{{ old('birthday', $student->birthday->format('d.m.Y')) }}" placeholder="dd.mm.rrrr" required>
                                @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('students.form.email'):</td>
                            <td>
                                <div class="input-group">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $student->email) }}" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-at"></i></div>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </td>
                        </tr>
                        @if ($student->term->select_payment)
                            <tr>
                                <td>@lang('students.form.payment'):</td>
                                <td>
                                    @foreach (\CzechitasApp\Models\Enums\StudentPaymentType::getAvailableValues() as $paymentType)
                                        <span class="custom-control custom-radio{{ $errors->has('payment') ? ' is-invalid' : '' }}">
                                            <input type="radio" id="payment_{{ $paymentType }}" name="payment" value="{{ $paymentType }}" class="custom-control-input" {{ oldChecked('payment', $paymentType, $student->payment) }} required>
                                            <label class="custom-control-label" for="payment_{{ $paymentType }}">@lang('students.payments.'.$paymentType)<small class="text-muted"> - @lang("students.payments.{$paymentType}_desc")</small></label>
                                        </span>
                                    @endforeach
                                    @error('payment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment') }}</strong>
                                        </span>
                                    @enderror
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>@lang('students.form.restrictions'):</td>
                            <td>
                                <span class="custom-control custom-checkbox">
                                    <input type="checkbox" id="restrictions_yes" name="restrictions_yes" value="1" class="custom-control-input" {{ oldChecked('restrictions_yes', '1', $student->restrictions != null) }}>
                                    <label class="custom-control-label" for="restrictions_yes">@lang('students.form.restrictions_yes')</label>
                                </span>
                                <textarea name="restrictions" class="form-control mt-2{{ $errors->has('restrictions') ? ' is-invalid' : '' }}" id="restrictions" rows="3" required placeholder="@lang('students.form.restrictions_desc')">{{ old('restrictions', $student->restrictions) }}</textarea>
                                @error('restrictions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('restrictions') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('students.form.note'):</td>
                            <td>
                                <textarea maxlength="150" name="note" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" id="note" rows="3">{{ old('note', $student->note) }}</textarea>
                                @error('note')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="btn btn-primary" value="@lang('students.form.submit_update')">
                            </td>
                        </tr>

                    </table>

                </form>
            </div>
        </div>
    </div>
@endsection
