<div class="form-row mt-3">
    <div class="col-md-4 form-group">
        <label for="students">@lang('orders.form.students')</label>
        <input id="students" type="number" min="1" class="form-control{{ $errors->has('xdata.students') ? ' is-invalid' : '' }}" name="xdata[students]" value="{{ old('xdata.students', $order->getXData('students')) }}" required>
        @error('xdata.students')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.students') }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-md-4 form-group">
        <label for="age">@lang('orders.form.age')</label>
        <input id="age" type="text" class="form-control{{ $errors->has('xdata.age') ? ' is-invalid' : '' }}" name="xdata[age]" value="{{ old('xdata.age', $order->getXData('age')) }}" required>
        @error('xdata.age')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.age') }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-md-4 form-group">
        <label for="adults">@lang('orders.form.adults')</label>
        <input id="adults" type="number" min="1" class="form-control{{ $errors->has('xdata.adults') ? ' is-invalid' : '' }}" name="xdata[adults]" value="{{ old('xdata.adults', $order->getXData('adults')) }}" required>
        @error('xdata.adults')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.adults') }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-md-3 form-group">
        <label for="start_time">@lang('orders.form.start_time')</label>
        <div class="input-group">
            <input id="start_time" type="text" data-enabletime data-nocalendar class="js-datepicker form-control{{ $errors->has('xdata.start_time') ? ' is-invalid' : '' }}" name="xdata[start_time]" value="{{ old('xdata.start_time', $order->getXData('start_time')) }}" required>
            <div class="input-group-append">
              <div class="input-group-text"><i class="fa fa-clock"></i></div>
            </div>
            @error('xdata.start_time')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('xdata.start_time') }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3 form-group">
        <label for="start_food">@lang('orders.form.start_food')</label>
        <select name="xdata[start_food]" id="start_food" class="form-control{{ $errors->has('xdata.start_food') ? ' is-invalid' : '' }}">
            <option value="breakfast" {{ oldSelected('xdata.start_food', 'breakfast', $order->getXData('start_food')) }}>@lang('orders.form.breakfast')</option>
            <option value="lunch" {{ oldSelected('xdata.start_food', 'lunch', $order->getXData('start_food')) }}>@lang('orders.form.lunch')</option>
            <option value="dinner" {{ oldSelected('xdata.start_food', 'dinner', $order->getXData('start_food')) }}>@lang('orders.form.dinner')</option>
        </select>
        @error('xdata.start_food')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.start_food') }}</strong>
            </span>
        @enderror
    </div>


    <div class="col-md-3 form-group">
        <label for="end_time">@lang('orders.form.end_time')</label>
        <div class="input-group">
            <input id="end_time" type="text" data-enabletime data-nocalendar class="js-datepicker form-control{{ $errors->has('xdata.end_time') ? ' is-invalid' : '' }}" name="xdata[end_time]" value="{{ old('xdata.end_time', $order->getXData('end_time')) }}" required>
            <div class="input-group-append">
              <div class="input-group-text"><i class="fa fa-clock"></i></div>
            </div>
            @error('xdata.end_time')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('xdata.end_time') }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3 form-group">
        <label for="end_food">@lang('orders.form.end_food')</label>
        <select name="xdata[end_food]" id="end_food" class="form-control{{ $errors->has('xdata.end_food') ? ' is-invalid' : '' }}">
            <option value="breakfast" {{ oldSelected('xdata.end_food', 'breakfast', $order->getXData('end_food')) }}>@lang('orders.form.breakfast')</option>
            <option value="lunch" {{ oldSelected('xdata.end_food', 'lunch', $order->getXData('end_food')) }}>@lang('orders.form.lunch')</option>
            <option value="dinner" {{ oldSelected('xdata.end_food', 'dinner', $order->getXData('end_food')) }}>@lang('orders.form.dinner')</option>
        </select>
        @error('xdata.end_food')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.end_food') }}</strong>
            </span>
        @enderror
    </div>



</div>
