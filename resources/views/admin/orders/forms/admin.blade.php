<div class="form-row adminOnlyBlock">

    <div class="col-md-3 form-group">
        <label for="price_kid">@lang('orders.form.price_kid')</label>
        <div class="input-group">
            <input id="price_kid" type="number" min="0" class="form-control{{ $errors->has('xdata.price_kid') ? ' is-invalid' : '' }}" name="xdata[price_kid]" value="{{ old('xdata.price_kid', $order->getXData('price_kid')) }}" required>
            <div class="input-group-append">
                <div class="input-group-text">@lang('app.price_czk')</div>
            </div>
            @error('xdata.price_kid')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('xdata.price_kid') }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-3 form-group">
        <label for="price_adult">@lang('orders.form.price_adult')</label>
        <div class="input-group">
            <input id="price_adult" type="number" min="0" class="form-control{{ $errors->has('xdata.price_adult') ? ' is-invalid' : '' }}" name="xdata[price_adult]" value="{{ old('xdata.price_adult', $order->getXData('price_adult')) }}" required>
            <div class="input-group-append">
                <div class="input-group-text">@lang('app.price_czk')</div>
            </div>
            @error('xdata.price_adult')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('xdata.price_adult') }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
