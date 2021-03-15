@component('components.admin_modal', ['id' => "addStudentPayment", 'heading' => trans('students.payments.insert.heading')])
    <form action="{{ route('admin.students.add_payment', $student) }}" method="POST">
        @csrf
        <input type="hidden" name="anyErrorPushId" value="addStudentPayment">
        <table class="table table-twocols">
            <tr>
                <td>@lang('students.payments.insert.direction')</td>
                <td>
                    <span class="custom-control custom-radio{{ $errors->has('direction') ? ' is-invalid' : '' }}">
                        <input type="radio" id="direction_income" name="direction" value="income" class="custom-control-input" {{ oldChecked('direction', 'income', 'income') }}>
                        <label class="custom-control-label" for="direction_income">@lang('students.payments.income')</label>
                    </span>
                    <span class="custom-control custom-radio{{ $errors->has('direction') ? ' is-invalid' : '' }}">
                        <input type="radio" id="direction_return" name="direction" value="return" class="custom-control-input" {{ oldChecked('direction', 'return') }}>
                        <label class="custom-control-label" for="direction_return">@lang('students.payments.return')</label>
                    </span>
                </td>
            </tr>
            <tr>
                <td>@lang('students.payments.insert.type')</td>
                <td>
                    @foreach (\CzechitasApp\Models\Enums\StudentPaymentType::getAvailableValues(true) as $paymentType)
                        <span class="custom-control custom-radio{{ $errors->has('payment') ? ' is-invalid' : '' }}">
                            <input type="radio" id="payment_{{ $paymentType }}" name="payment" value="{{ $paymentType }}" class="custom-control-input" {{ oldChecked('payment', $paymentType) }} required>
                            <label class="custom-control-label" for="payment_{{ $paymentType }}">@lang('students.payments.'.$paymentType)</label>
                        </span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>@lang('students.payments.insert.price')</td>
                <td>
                    <div class="input-group">
                        <input id="price" type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" min="1" name="price" value="{{ old('price') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">@lang('app.price_czk')</div>
                        </div>
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @enderror
                    </div>
                </td>
            </tr>

            <tr>
                <td>@lang('students.payments.insert.date')</td>
                <td>
                    <span class="custom-control custom-checkbox">
                        <input type="checkbox" id="override_received_at" name="override_received_at" value="1" class="custom-control-input" {{ oldChecked('override_received_at', '1') }}>
                        <label class="custom-control-label" for="override_received_at">@lang('students.payments.insert.received')</label>
                    </span>
                    <div class="js-receivedAtWrap mt-2">
                        @lang('students.payments.insert.date_note')
                        <div class="input-group">
                            <input id="received_at" type="text" class="js-datepicker form-control{{ $errors->has('received_at') ? ' is-invalid' : '' }}" name="received_at" value="{{ old('received_at') }}" required>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            @error('received_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('received_at') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>@lang('students.payments.insert.note')</td>
                <td>
                    <input id="note" type="text" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" name="note" value="{{ old('note') }}">
                    @error('note')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('note') }}</strong>
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td class="text-center" colspan="2">
                    <input type="submit" class="btn btn-primary" value="@lang('students.payments.insert.submit')">
                </td>
            </tr>
        </table>
    </form>
@endcomponent
