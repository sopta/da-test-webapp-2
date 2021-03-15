@extends('layouts.app')

@section('extra_wrapper_classes', 'd-flex flex-column justify-content-center')
@section('title', trans('orders.title'))
@section('header', trans('orders.breadcrumbs.create'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3>@lang('orders.success.header')</h3>
                    <p>{!! trans('orders.success.text') !!}</p>

                </div>
            </div>
        </div>
    </div>
@endsection
