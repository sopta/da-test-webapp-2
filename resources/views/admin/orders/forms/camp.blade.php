<div class="form-row mt-3">
    <div class="col-md-3 form-group">
        <label for="date_part">@lang('orders.form.date_part')</label>
        <select name="xdata[date_part]" id="date_part" class="form-control{{ $errors->has('xdata.date_part') ? ' is-invalid' : '' }}">
            <option value="forenoon" {{ oldSelected('xdata.date_part', 'forenoon', $order->getXData('date_part')) }}>@lang('orders.form.forenoon')</option>
            <option value="afternoon" {{ oldSelected('xdata.date_part', 'afternoon', $order->getXData('date_part')) }}>@lang('orders.form.afternoon')</option>
        </select>
        @error('xdata.date_part')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.date_part') }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-2 form-group">
        <label for="students">@lang('orders.form.students')</label>
        <input id="students" type="number" min="1" class="form-control{{ $errors->has('xdata.students') ? ' is-invalid' : '' }}" name="xdata[students]" value="{{ old('xdata.students', $order->getXData('students')) }}" required>
        @error('xdata.students')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.students') }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-md-3 form-group">
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
</div>
