@extends('layouts.app')

@section('title', trans('news.title'))
@section('header', trans('news.breadcrumbs.create'))

@section('scripts')
    <script>
        CzechitasApp.easymde.init('create_category', "#tui_content");
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <form action="{{ route('admin.news.store') }}" method="POST">
                    @csrf

                    <table class="table table-twocols">
                        <tr>
                            <td>@lang('news.form.title'):</td>
                            <td>
                                <input id="title" type="text" maxlength="100" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>
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
                                <textarea id="tui_content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content">{{ old('content') }}</textarea>
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
                                <input type="submit" class="btn btn-primary" value="@lang('news.form.submit_create')">
                            </td>
                        </tr>

                    </table>

                </form>
            </div>
        </div>
    </div>
@endsection
