@component('components.admin_modal', ['id' => "studentLogOut", 'heading' => trans('students.logout.heading')])
    <form action="{{ route('admin.students.logout', $student) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="anyErrorPushId" value="studentLogOut">

        <p>
            @lang('students.logout.status') <strong>{{ trans('students.logout.'.($student->logged_out == null ? 'isnot' : $student->logged_out)) }}</strong>
            @if ($student->logged_out && $student->alternate)
                (@lang('students.logout.alternate'): {{ $student->alternate }})
            @endif
            @if ($student->logged_out_reason)
                <br> <strong>@lang('students.logout.reason')</strong>: {{ $student->logged_out_reason }}
            @endif
            @if (!empty($student->logged_out_date))
                <br>@lang('students.logout.last_updated_at', ['logged_out_date' => $student->logged_out_date->format("d.m.Y H:i")])
            @endif
        </p>

        <div class="mb-3">
            <span class="custom-control custom-radio{{ $errors->has('logged_out') ? ' is-invalid' : '' }}">
                <input type="radio" id="logged_out_none" name="logged_out" value="" class="custom-control-input" {{ oldChecked('logged_out', null, $student->logged_out) }}>
                <label class="custom-control-label" for="logged_out_none">@lang('students.logout.will_not_be')</label>
            </span>
            <span class="custom-control custom-radio{{ $errors->has('logged_out') ? ' is-invalid' : '' }}">
                <input type="radio" id="logged_out_illness" name="logged_out" value="illness" class="custom-control-input" {{ oldChecked('logged_out', 'illness', $student->logged_out) }}>
                <label class="custom-control-label" for="logged_out_illness">@lang('students.logout.illness')</label>
            </span>
            <span class="custom-control custom-radio{{ $errors->has('logged_out') ? ' is-invalid' : '' }}">
                <input type="radio" id="logged_out_other" name="logged_out" value="other" class="custom-control-input" {{ oldChecked('logged_out', 'other', $student->logged_out) }}>
                <label class="custom-control-label" for="logged_out_other">@lang('students.logout.other')</label>
            </span>
            @error('logged_out')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('logged_out') }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group js-loggedOutReasonWrap">
            <label for="logged_out_reason">@lang('students.logout.reason') <small class="muted">@lang('students.form.optional')</small></label>
            <input name="logged_out_reason" class="form-control{{ $errors->has('logged_out_reason') ? ' is-invalid' : '' }}" id="logged_out_reason" value="{{ old('logged_out_reason', $student->logged_out_reason) }}">
            @error('logged_out_reason')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('logged_out_reason') }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group border-top pt-2">
            <span class="custom-control custom-checkbox">
                <input type="checkbox" id="send_notification_logout" name="send_notification" value="1" class="custom-control-input" {{ oldChecked('send_notification', '1', '1') }}>
                <label class="custom-control-label" for="send_notification_logout">@lang('students.modal.send_notification')</label>
            </span>
        </div>

        <input type="submit" class="btn btn-primary" value="@lang('students.form.submit_general_update')">
        <button type="button" class="btn btn-info" data-dismiss="modal">@lang('app.modal.close')</button>
    </form>
@endcomponent
