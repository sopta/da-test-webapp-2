@extends('layouts.app')

@section('title', trans('exports.title'))

@section('content')
    <style>
        .date-group{ max-width: 200px; }
    </style>
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    @can('exports.fullTerm')
                        @include('admin.exports.__term', ['keywordType' => 'full_term'])
                        <div class="my-4">&nbsp;</div>
                    @endcan

                    @can('exports.overUnderPaid')
                        @include('admin.exports.__date', ['keywordType' => 'over_under_paid'])
                        <div class="my-4">&nbsp;</div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
@endsection
