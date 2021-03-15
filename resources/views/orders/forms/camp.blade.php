<div class="form-row mt-3">
    <div class="col-md-3 form-group">
        <label for="camp-date_part">@lang('orders.form.date_part')</label>
        <select name="xdata[date_part]" id="camp-date_part" class="form-control{{ $errors->has('xdata.date_part') ? ' is-invalid' : '' }}">
            <option value="forenoon" {{ oldSelected('xdata.date_part', 'forenoon') }}>@lang('orders.form.forenoon')</option>
            <option value="afternoon" {{ oldSelected('xdata.date_part', 'afternoon') }}>@lang('orders.form.afternoon')</option>
        </select>
        @error('xdata.date_part')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.date_part') }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-2 form-group">
        <label for="camp-students">@lang('orders.form.students')</label>
        <input id="camp-students" type="number" min="1" class="form-control{{ $errors->has('xdata.students') ? ' is-invalid' : '' }}" name="xdata[students]" value="{{ old('xdata.students') }}" required>
        @error('xdata.students')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.students') }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-md-3 form-group">
        <label for="camp-age">@lang('orders.form.age')</label>
        <input id="camp-age" type="text" class="form-control{{ $errors->has('xdata.age') ? ' is-invalid' : '' }}" name="xdata[age]" value="{{ old('xdata.age') }}" required>
        @error('xdata.age')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.age') }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="camp-adults">@lang('orders.form.adults')</label>
        <input id="camp-adults" type="number" min="1" class="form-control{{ $errors->has('xdata.adults') ? ' is-invalid' : '' }}" name="xdata[adults]" value="{{ old('xdata.adults') }}" required>
        @error('xdata.adults')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('xdata.adults') }}</strong>
            </span>
        @enderror
    </div>
</div>
