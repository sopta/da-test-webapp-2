@component('components.admin_modal', ['id' => "studentCancel", 'heading' => trans('students.cancel.heading')])
    <form action="{{ route('admin.students.cancel', $student) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="anyErrorPushId" value="studentCancel">

        <p>@lang('students.cancel.status') <strong>{{ trans('students.cancel.'.($student->canceled ? 'is' : 'isnot')) }}</strong></p>

        <div class="form-group">
            <span class="custom-control custom-checkbox">
                <input type="checkbox" id="canceled_yes" name="canceled_yes" value="1" class="custom-control-input" {{ oldChecked('canceled_yes', '1', empty($student->canceled) ? '' : '1') }}>
                <label class="custom-control-label" for="canceled_yes">@lang('students.cancel.canceled')</label>
            </span>
            <input name="canceled" class="form-control mt-2{{ $errors->has('canceled') ? ' is-invalid' : '' }}" id="canceled" required value="{{ old('canceled', $student->canceled) }}" required>
            @error('canceled')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('canceled') }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group border-top pt-2">
            <span class="custom-control custom-checkbox">
                <input type="checkbox" id="send_notification_cancel" name="send_notification" value="1" class="custom-control-input" {{ oldChecked('send_notification', '1', '1') }}>
                <label class="custom-control-label" for="send_notification_cancel">@lang('students.modal.send_notification')</label>
            </span>
        </div>

        <input type="submit" class="btn btn-primary" value="@lang('students.form.submit_general_update')">
        <button type="button" class="btn btn-info" data-dismiss="modal">@lang('app.modal.close')</button>
    </form>
@endcomponent