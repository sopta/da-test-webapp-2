@extends('layouts.app')

@section('title', trans('categories.title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                @can('create', \CzechitasApp\Models\Category::class)
                    <div class="card-header text-right">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-info"><i class="fa fa-fw mr-1 fa-plus-circle "></i>{{ trans('app.actions.create') }}</a>
                    </div>
                @endcan
                {{-- <div class="card-body"> --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10%">{{ trans('categories.table.position') }}</th>
                            <th>{{ trans('categories.table.name') }}</th>
                            <th>{{ trans('categories.table.term_count') }}</th>
                            <th style="width: 10%">{{ trans('categories.table.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $cat)
                            <tr class="table-info">
                                @include('admin.categories.__list_item', ['category' => $cat])
                            </tr>
                            @foreach ($cat->children as $children)
                                <tr>
                                    @include('admin.categories.__list_item', ['category' => $children])
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ trans('categories.table.position') }}</th>
                            <th>{{ trans('categories.table.name') }}</th>
                            <th>{{ trans('categories.table.term_count') }}</th>
                            <th>{{ trans('categories.table.action') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
