<h4 class="text-center">@lang('exports.list.'.$keywordType)</h4>
@if (transDef('exports.list.'.$keywordType.'_note', null))
    <p class="text-muted text-center">{{ trans('exports.list.'.$keywordType.'_note') }}</p>
@endif
<form action="{{ route('admin.exports.'.$keywordType) }}" method="POST" class="row justify-content-center">
    @csrf
    <div class="form-group col-lg-8">
        <label for="{{ $keywordType }}_term_id">@lang('exports.term')</label>
        <select name="{{ $keywordType }}[term_id]" id="{{ $keywordType }}_term_id" class="selectpicker form-control{{ $errors->has($keywordType.'.term_id') ? ' is-invalid' : '' }}" data-live-search="true" required>
            @foreach ($categories as $categoryCollection)
                <optgroup label="{{ $categoryCollection->get(0)->category->name }}">
                    @foreach ($categoryCollection as $term)
                        <option value="{{ $term->id }}" {{ oldSelected($keywordType.'.term_id', $term->id) }}>
                            {{ $term->term_range }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        @if ($errors->has($keywordType.'.term_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first($keywordType.'.term_id') }}</strong>
            </span>
        @endif
    </div>

    <div class="col-12 text-center">
        <input type="submit" class="btn btn-primary" value="@lang('exports.submit')">
    </div>

</form>

<hr>
