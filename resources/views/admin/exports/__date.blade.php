<h4 class="text-center">@lang('exports.list.'.$keywordType)</h4>
@if (transDef('exports.list.'.$keywordType.'_note', null))
    <p class="text-muted text-center">{{ trans('exports.list.'.$keywordType.'_note') }}</p>
@endif
<form action="{{ route('admin.exports.'.$keywordType) }}" method="POST">
    @csrf
    <table class="table table-twocols">
        <tr>
            <td>@lang('exports.date.from')</td>
            <td>
                <div class="input-group date-group">
                    <input id="{{ $keywordType }}_start" type="text" class="form-control js-datepicker{{ $errors->has($keywordType.'.start') ? ' is-invalid' : '' }}" name="{{ $keywordType }}[start]" value="{{ old($keywordType.'.start') }}" required>
                    <div class="input-group-append">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    @if ($errors->has($keywordType.'.start'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first($keywordType.'.start') }}</strong>
                        </span>
                    @endif
                </div>
            </td>
        </tr>
        <tr>
            <td>@lang('exports.date.to')</td>
            <td>
                <div class="input-group date-group">
                    <input id="{{ $keywordType }}_end" type="text" data-fp-mindate="#{{ $keywordType }}_start" class="form-control js-datepicker{{ $errors->has($keywordType.'.end') ? ' is-invalid' : '' }}" name="{{ $keywordType }}[end]" value="{{ old($keywordType.'.end') }}" required>
                    <div class="input-group-append">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    @if ($errors->has($keywordType.'.end'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first($keywordType.'.end') }}</strong>
                        </span>
                    @endif
                </div>
            </td>
        </tr>
        @includeIf('admin.exports.__'.$keywordType)
        <tr>
            <td></td>
            <td>
                <input type="submit" class="btn btn-primary" value="@lang('exports.submit')">
            </td>
        </tr>
    </table>
</form>
