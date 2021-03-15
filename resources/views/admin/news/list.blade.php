@extends('layouts.app')

@section('title', trans('news.title'))

@section('scripts')
    <script type="text/javascript">
        CzechitasApp.datatables.init({
            order: [[0, "desc"]],
            columnDefs: [{ targets: 0, responsivePriority: 1},{ targets: 2, orderable: false, responsivePriority: 2}]
        });
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                @can('create', \CzechitasApp\Models\News::class)
                    <div class="card-header text-right">
                        <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-info"><i class="fa fa-fw mr-1 fa-plus-circle "></i>{{ trans('app.actions.create') }}</a>
                    </div>
                @endcan
                <table class="table table-striped" data-table>
                    <thead>
                        <tr>
                            <th>{{ trans('news.table.created_at') }}</th>
                            <th>{{ trans('news.table.title') }}</th>
                            <th style="width: 10%;">{{ trans('news.table.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $newsItem)
                            <tr>
                                <td data-order="{{ $newsItem->created_at->format("YmdHi") }}">{{ $newsItem->created_at->format("d.m.Y H:i") }}</td>
                                <td>{{ $newsItem->title }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('update', $newsItem)
                                            <a href="{{ route('admin.news.edit', [$newsItem]) }}" title="@lang('app.actions.edit')" class="btn btn-sm btn-success"><i class="fa fa-fw fa-edit"></i></a>
                                        @endcan
                                        @can('delete', $newsItem)
                                            <a href="#deleteNWS_{{ $newsItem->id }}" data-toggle="modal" title="@lang('app.actions.destroy')" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></a>
                                        @endcan
                                    </div>
                                    @can('delete', $newsItem)
                                        @component('components.modal_yes_no_form', [ 'id' => 'deleteNWS_'.$newsItem->id, 'route' => route('admin.news.destroy', $newsItem)] )
                                            @lang('news.delete_modal', ['title' => $newsItem->title])
                                        @endcomponent
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ trans('news.table.created_at') }}</th>
                            <th>{{ trans('news.table.title') }}</th>
                            <th>{{ trans('news.table.action') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
