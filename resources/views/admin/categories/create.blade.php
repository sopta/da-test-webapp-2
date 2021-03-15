@extends('layouts.app')

@section('title', trans('categories.title'))
@section('header', trans('categories.breadcrumbs.create'))

@section('scripts')
    <script>
        CzechitasApp.easymde.init('create_category', "#tui_content");
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <table class="table table-twocols">
                        <tr>
                            <td>@lang('categories.form.parent'):</td>
                            <td>
                                 <select name="parent_id" id="parent_id" class="js-categoryParent selectpicker form-control{{ $errors->has('parent_id') ? ' is-invalid' : '' }}" data-live-search="true">
                                    <option value="">@lang('categories.form.no_parent')</option>
                                    <option data-divider="true" disabled>---</option>
                                    @foreach ($parents as $parent)
                                        <option value="{{ $parent->id }}" {{ oldSelected('parent_id', $parent->id) }}>{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('parent_id') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('categories.form.name'):</td>
                            <td>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('categories.form.cover_img'):</td>
                            <td>
                                <input id="cover_img" type="file" class="form-control{{ $errors->has('cover_img') ? ' is-invalid' : '' }}" name="cover_img" accept=".jpg,.png,.jpeg" required>
                                @error('cover_img')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cover_img') }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>@lang('categories.form.content'):</td>
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
                                <input type="submit" class="btn btn-primary" value="@lang('categories.form.submit_create')">
                            </td>
                        </tr>

                    </table>

                </form>
            </div>
        </div>
    </div>
@endsection
