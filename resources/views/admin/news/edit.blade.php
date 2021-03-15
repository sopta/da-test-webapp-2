@extends('layouts.app')

@section('title', trans('news.title'))
@section('header', trans('news.breadcrumbs.edit'))

@section('scripts')
    <script>
        CzechitasApp.easymde.init('edit_news', "#tui_content");
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <form action="{{ route('admin.news.update', [$news]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <table class="table table-twocols">
                        <tr>
                            <td>@lang('news.form.title'):</td>
                            <td>
                                <input id="title" type="text" maxlength="100" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $news->title) }}" required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('news.form.content'):</td>
                            <td>
                                <textarea id="tui_content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content">{{ markdownBackToEditor(old('content', $news->content)) }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="btn btn-primary" value="@lang('news.form.submit_update')">
                            </td>
                        </tr>

                    </table>

                </form>
            </div>
        </div>
    </div>
@endsection
