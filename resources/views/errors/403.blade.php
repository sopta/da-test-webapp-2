@extends('layouts.app')

@section('extra_wrapper_classes', 'd-flex flex-column justify-content-center')
@section('title', trans('app.error.403.title'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <h3>@lang('app.error.403.title_text')</h3>
                <p>
                    @lang('app.error.403.text')<br>
                </p>
                <p>
                    <a href="{{ route('home') }}" class="btn btn-primary">@lang('app.error.403.button')</a>
                </p>
                <img src="{{ asset('img/error.jpg') }}" alt="@lang('app.error.403.title')" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endsection
