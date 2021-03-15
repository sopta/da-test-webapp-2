@extends('layouts.app')

@section('title', $category->name)

@inject('categoryService', 'CzechitasApp\Services\Models\CategoryService')

@section('content')
    <div class="row justify-content-center">
        <div class="card col-12 col-lg-9">
            @if (!empty($category->content))
                <div class="card-body">
                    {{ markdownToHtml($category->content) }}
                </div>
            @endif

            <div class="card-footer row justify-content-center intro_cards{{ empty($category->content) ? ' border-top-0' : null }}">
                @if ($categories->count() === 0)
                    <h2>@lang('categories.empty_category')</h2>
                @endif
                @foreach ($categories as $inCategory)
                    <div class="card_wrapper p-2 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="position-relative">
                                <img class="card-img-top" src="{{ $categoryService->setContext($inCategory)->getImageUrl() }}" alt="{{ $inCategory->name }}">
                                <div class="card-img-overlay p-2">
                                    {{ $inCategory->name }}
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    {{ markdownToHtml($inCategory->content) }}
                                </div>
                                @if (Auth::user() == null || Auth::user()->can('create', \CzechitasApp\Models\Student::class))
                                    <a href="{{ route('students.create_in_category', [$inCategory]) }}" class="btn btn-sm align-self-center btn-primary">@lang('app.homepage.new_application')</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
