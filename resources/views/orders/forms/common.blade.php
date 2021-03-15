<div class="form-row">
    <div class="col-md-3 form-group">
        <label for="ico">@lang('orders.form.ico')</label>
        <input id="ico" type="text" maxlength="8" class="form-control{{ $errors->has('ico') ? ' is-invalid' : '' }}" name="ico" value="{{ old('ico') }}" required autofocus>
        @error('ico')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('ico') }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-md-9 form-group">
        <label for="client">@lang('orders.form.client')</label>
        <input id="client" type="text" class="form-control{{ $errors->has('client') ? ' is-invalid' : '' }}" name="client" value="{{ old('client') }}" required>
        @error('client')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('client') }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="address">@lang('orders.form.address')</label>
        <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" required>
        @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="substitute">@lang('orders.form.substitute')</label>
        <input id="substitute" type="text" class="form-control{{ $errors->has('substitute') ? ' is-invalid' : '' }}" name="substitute" value="{{ old('substitute') }}" required>
        @error('substitute')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('substitute') }}</strong>
            </span>
        @enderror
    </div>





    <h4 class="col-12">@lang('orders.form.contact_heading')</h4>

    <div class="col-md-4 form-group">
        <label for="contact_name">@lang('orders.form.contact_name')</label>
        <input id="contact_name" type="text" class="form-control{{ $errors->has('contact_name') ? ' is-invalid' : '' }}" name="contact_name" value="{{ old('contact_name') }}" required>
        @error('contact_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('contact_name') }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-md-4 form-group">
        <label for="contact_tel">@lang('orders.form.contact_tel')</label>
        <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fa fa-phone"></i></div>
            </div>
            <input id="contact_tel" type="text" class="form-control{{ $errors->has('contact_tel') ? ' is-invalid' : '' }}" name="contact_tel" value="{{ old('contact_tel') }}" required>
            @error('contact_tel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('contact_tel') }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-4 form-group">
        <label for="contact_mail">@lang('orders.form.contact_mail')</label>
        <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">@</div>
            </div>
            <input id="contact_mail" type="email" class="form-control{{ $errors->has('contact_mail') ? ' is-invalid' : '' }}" name="contact_mail" value="{{ old('contact_mail') }}" required>
            @error('contact_mail')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('contact_mail') }}</strong>
                </span>
            @enderror
        </div>
    </div>





    <h4 class="col-12">@lang('orders.form.dates_heading')</h4>
</div>

<div class="form-row align-items-end">
    <div class="col-sm-6 col-md-5 form-group">
        <label for="start_date_1">@lang('orders.form.start_date_1')</label>
        <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">@lang('orders.form.since'):</div>
            </div>
            <input id="start_date_1" type="text" class="js-datepicker form-control{{ $errors->has('start_date_1') ? ' is-invalid' : '' }}" name="start_date_1" value="{{ old('start_date_1') }}" required>
            <div class="input-group-append">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
            @error('start_date_1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('start_date_1') }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6 col-md-5 form-group">
        <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">@lang('orders.form.till'):</div>
            </div>
            <input id="end_date_1" data-fp-mindate="#start_date_1" type="text" class="js-datepicker form-control{{ $errors->has('xdata.end_date_1') ? ' is-invalid' : '' }}" name="xdata[end_date_1]" value="{{ old('xdata.end_date_1') }}" required>
            <div class="input-group-append">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
            @error('xdata.end_date_1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('xdata.end_date_1') }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-row align-items-end">
    <div class="col-sm-6 col-md-5 form-group">
        <label for="start_date_2">@lang('orders.form.start_date_2')</label>
        <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">@lang('orders.form.since'):</div>
            </div>
            <input id="start_date_2" type="text" class="js-datepicker form-control{{ $errors->has('start_date_2') ? ' is-invalid' : '' }}" name="start_date_2" value="{{ old('start_date_2') }}">
            <div class="input-group-append">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
            @error('start_date_2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('start_date_2') }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6 col-md-5 form-group">
        <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">@lang('orders.form.till'):</div>
            </div>
            <input id="end_date_2" data-fp-mindate="#start_date_2" type="text" class="js-datepicker form-control{{ $errors->has('xdata.end_date_2') ? ' is-invalid' : '' }}" name="xdata[end_date_2]" value="{{ old('xdata.end_date_2') }}">
            <div class="input-group-append">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
            @error('xdata.end_date_2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('xdata.end_date_2') }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-row align-items-end">
    <div class="col-sm-6 col-md-5 form-group">
        <label for="start_date_3">@lang('orders.form.start_date_3')</label>
        <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">@lang('orders.form.since'):</div>
            </div>
            <input id="start_date_3" type="text" class="js-datepicker form-control{{ $errors->has('start_date_3') ? ' is-invalid' : '' }}" name="start_date_3" value="{{ old('start_date_3') }}">
            <div class="input-group-append">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
            @error('start_date_3')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('start_date_3') }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6 col-md-5 form-group">
        <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">@lang('orders.form.till'):</div>
            </div>
            <input id="end_date_3" data-fp-mindate="#start_date_3" type="text" class="js-datepicker form-control{{ $errors->has('xdata.end_date_3') ? ' is-invalid' : '' }}" name="xdata[end_date_3]" value="{{ old('xdata.end_date_3') }}">
            <div class="input-group-append">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
            @error('xdata.end_date_3')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('xdata.end_date_3') }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
