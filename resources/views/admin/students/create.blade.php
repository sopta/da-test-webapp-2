@extends('layouts.app')

@section('title', trans('students.title_new'))

@inject('termService', 'CzechitasApp\Services\Models\TermService')

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <script>
                    var CzechitasTermData = {};
                    @foreach ($terms as $term) CzechitasTermData[{{ $term->id }}] = @json($termService->setContext($term)->getNewApplicationTermData()); @endforeach

                </script>
                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf

                    <table class="table table-twocols">
                        <tr>
                            <td>@lang('students.form.term'):</td>
                            <td>
                                 <select name="term_id" id="term_id" class="selectpicker form-control{{ $errors->has('term_id') ? ' is-invalid' : '' }}" data-live-search="true" required>
                                    @foreach ($categories as $categoryCollection)
                                        <optgroup label="{{ $categoryCollection->get(0)->category->name }}">
                                            @foreach ($categoryCollection as $term)
                                                <option value="{{ $term->id }}" {{ oldSelected('term_id', $term->id) }} data-term-id="{{ $term->id }}">
                                                    {{ $term->term_range }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('term_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('term_id') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('students.form.parent_name'):</td>
                            <td>
                                <input id="parent_name" type="text" class="form-control{{ $errors->has('parent_name') ? ' is-invalid' : '' }}" name="parent_name" value="{{ old('parent_name', Auth::user()->name ?? null) }}" required>
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
                                <input id="forename" type="text" class="form-control{{ $errors->has('forename') ? ' is-invalid' : '' }}" name="forename" value="{{ old('forename') }}" required>
                                @error('forename')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('forename') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('students.form.surname'):</td>
                            <td>
                                <input id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname') }}" required>
                                @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('students.form.birthday'):</td>
                            <td>
                                <input id="birthday" type="text" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" name="birthday" value="{{ old('birthday') }}" placeholder="dd.mm.rrrr" required>
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
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', Auth::user()->email ?? null) }}" required>
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

                        <tr class="configurable" data-part="select_payment">
                            <td>@lang('students.form.payment'):</td>
                            <td>
                                @foreach (\CzechitasApp\Models\Enums\StudentPaymentType::getAvailableValues() as $paymentType)
                                    <span class="custom-control custom-radio{{ $errors->has('payment') ? ' is-invalid' : '' }}">
                                        <input type="radio" id="payment_{{ $paymentType }}" name="payment" value="{{ $paymentType }}" class="custom-control-input" {{ oldChecked('payment', $paymentType) }} required>
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

                        <tr>
                            <td>@lang('students.form.restrictions'):</td>
                            <td>
                                <span class="custom-control custom-checkbox">
                                    <input type="checkbox" id="restrictions_yes" name="restrictions_yes" value="1" class="custom-control-input" {{ oldChecked('restrictions_yes', '1') }}>
                                    <label class="custom-control-label" for="restrictions_yes">@lang('students.form.restrictions_yes')</label>
                                </span>
                                <textarea name="restrictions" class="form-control mt-2{{ $errors->has('restrictions') ? ' is-invalid' : '' }}" id="restrictions" rows="3" required placeholder="@lang('students.form.restrictions_desc')">{{ old('restrictions') }}</textarea>
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
                                <textarea maxlength="150" name="note" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" id="note" rows="3">{{ old('note') }}</textarea>
                                @error('note')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('students.form.note_private'):</td>
                            <td>
                                <textarea maxlength="150" name="private_note" class="form-control{{ $errors->has('private_note') ? ' is-invalid' : '' }}" id="private_note" rows="3">{{ old('private_note') }}</textarea>
                                @error('private_note')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('private_note') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="btn btn-primary" value="@lang('students.form.submit')">
                            </td>
                        </tr>

                    </table>

                </form>
            </div>
        </div>
    </div>
@endsection
