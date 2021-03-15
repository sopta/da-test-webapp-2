@extends('layouts.app')

{{-- @section('title', trans('users.title')) --}}
@section('header', trans('app.homepage.header'))

@inject('categoryService', 'CzechitasApp\Services\Models\CategoryService')

@section('content')
    <div class="row justify-content-center intro_cards">
        @if(session('showIntroSelectHelp'))
            <div class="col-md-6">
                <div class="alert alert-secondary" role="alert">
                    @lang('app.homepage.alert')
                </div>
            </div>
            <div class="w-100"></div>
        @endif
        @foreach ($categories as $category)
            <div class="card_wrapper p-2 p-md-3 col-sm-6 col-md-4 col-lg-3 p-xl-4">
                <div class="card">
                    <div class="position-relative image_wrapper">
                        <img class="card-img-top" src="{{ $categoryService->setContext($category)->getImageUrl() }}" alt="{{ $category->name }}">
                        <div class="card-img-overlay p-2">
                            {{ $category->name }}
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('home.category', [$category]) }}" class="btn btn-sm align-self-center btn-primary">@lang('app.homepage.more_info')</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if (!empty($news) && $news->count() > 0)
        <div class="row news_wrap justify-content-center intro_cards py-4 mt-5">
            <h2 class="col-12 text-center">@lang('app.homepage.news')</h2>

            @foreach ($news as $singleNews)
                <div class="card_wrapper col-12 p-3 col-md-6 col-lg-4 p-xl-4" id="novinka_{{ $singleNews->id }}">
                    <div class="card">
                        <h6 class="card-header">{{ $singleNews->title }}</h6>
                        <div class="card-body">
                            {{ markdownToHtml($singleNews->content) }}
                            <p class="card-text"><small class="text-muted">{{ $singleNews->created_at->format("d.m.Y H:i") }}</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
