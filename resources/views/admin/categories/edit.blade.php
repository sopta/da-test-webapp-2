@extends('layouts.app')

@section('title', trans('categories.title'))
@section('header', trans('categories.breadcrumbs.edit'))

@section('scripts')
    <script>
        CzechitasApp.easymde.init('create_category', "#tui_content");
        $(".changeImg").click(function () {
            var td = $(this).parents("td:first");
            td.find(".image_wrap").remove();
            td.find("input").prop("disabled", false).removeClass("d-none").click();
        })
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <form action="{{ route('admin.categories.update', [$category]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <table class="table table-twocols">
                        <tr>
                            <td>@lang('categories.form.name'):</td>
                            <td>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $category->name) }}" required>
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
                                @if (!empty($image))
                                    <div class="image_wrap">
                                        <img src="{{ $image }}" height="150">
                                        <button class="btn btn-secondary changeImg" type="button">@lang('categories.form.new_cover_img')</button>
                                    </div>
                                @endif

                                <input id="cover_img" type="file" class="form-control{{ $errors->has('cover_img') ? ' is-invalid' : '' }}{{ empty($image) ? '' : ' d-none' }}" name="cover_img" accept=".jpg,.png,.jpeg" {{ empty($image) ? '' : 'disabled' }} required>
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
                                <textarea id="tui_content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content">{{ markdownBackToEditor(old('content', $category->content)) }}</textarea>
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
                                <input type="submit" class="btn btn-primary" value="@lang('categories.form.submit_update')">
                            </td>
                        </tr>

                    </table>

                </form>
            </div>
        </div>
    </div>
@endsection
