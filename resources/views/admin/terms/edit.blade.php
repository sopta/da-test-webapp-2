@extends('layouts.app')

@section('title', trans('terms.title'))
@section('header', trans('terms.breadcrumbs.edit'))

@section('scripts')
    <script>
        CzechitasApp.easymde.init('term_note_public', "#note_public");
    </script>
@endsection

@section('content')
    <style type="text/css">.twoInOne{ float: left; width: 40%; margin: 0 5px 5px; min-width: 200px; }</style>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <form action="{{ routeBack('admin.terms.update', [$term]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <table class="table table-twocols">
                        <tr>
                            <td>@lang('terms.form.category'):</td>
                            <td>
                                 <select name="category_id" id="category_id" class="selectpicker form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" data-live-search="true" title="@lang('app.selectpicker.title')" required>
                                    @foreach ($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                        @foreach ($category->children as $child)
                                            <option value="{{ $child->id }}" {{ oldSelected('category_id', $child->id, $term->category_id) }}>{{ $child->name }}</option>
                                        @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('terms.form.term_range'):</td>
                            <td>
                                <div class="input-group twoInOne">
                                    <input id="start_date" type="text" class="form-control js-datepicker{{ $errors->has('start') ? ' is-invalid' : '' }}" name="start" value="{{ old('start', $term->start) }}" required>
                                    <div class="input-group-append">
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('start')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('start') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="input-group twoInOne">
                                    <input id="end_date" type="text" data-fp-mindate="#start_date" class="form-control js-datepicker{{ $errors->has('end') ? ' is-invalid' : '' }}" name="end" value="{{ old('end', $term->end) }}" required>
                                    <div class="input-group-append">
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('end')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('end') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('terms.form.opening'):<br><small class="text-muted">@lang('terms.form.opening_desc')</small></td>
                            <td>
                                <div class="input-group">
                                    <input id="opening" type="text" data-enabletime class="form-control js-datepicker{{ $errors->has('opening') ? ' is-invalid' : '' }}" name="opening" value="{{ old('opening', empty($term->opening) ? null : $term->opening->format('d.m.Y H:i')) }}">
                                    <div class="input-group-append">
                                      <div class="input-group-text"><i class="fa fa-calendar mr-1"></i><i class="fa fa-clock"></i></div>
                                    </div>
                                    @error('opening')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('opening') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('terms.form.price'):</td>
                            <td>
                                <div class="input-group">
                                    <input id="price" type="number" min="1" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price', $term->price) }}" required>
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
                            <td>@lang('terms.form.note_public'):<br><small class="text-muted">@lang('terms.form.optional')</small></td>
                            <td>
                                <textarea id="note_public" class="form-control{{ $errors->has('note_public') ? ' is-invalid' : '' }}" name="note_public">{{ markdownBackToEditor(old('note_public', $term->note_public)) }}</textarea>
                                @error('note_public')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('note_public') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('terms.form.note_private'):<br><small class="text-muted">@lang('terms.form.optional')</small></td>
                            <td>
                                <textarea name="note_private" id="note_private" rows="5" class="form-control{{ $errors->has('note_private') ? ' is-invalid' : '' }}">{{ old('note_private', $term->note_private) }}</textarea>
                                @error('note_private')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('note_private') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="btn btn-primary" value="@lang('terms.form.submit_update')">
                            </td>
                        </tr>

                    </table>

                </form>
            </div>
        </div>
    </div>
@endsection
