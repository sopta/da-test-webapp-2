@extends('layouts.app')

@section('title', trans('users.title'))

@section('scripts')
    <script type="text/javascript">
        CzechitasApp.datatables.init({
            ajax: {
                url: "{{ route('admin.users.ajax_list') }}",
                error: CzechitasApp.datatables.ajaxError
            },
            processing: true,
            serverSide: true,
            columns: CzechitasApp.datatables.formatColumns(@json($columnNames), ['id']),
            order: [[ 2, "asc" ], [0, "asc"]],
            columnDefs: [{ targets: 0, responsivePriority: 1},{
                targets: 3,
                data: "id",
                orderable: false,
                responsivePriority: 2,
                render: CzechitasApp.datatables.getRenderer('action', $(".action_buttons_template")),
            }]
        });
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">
        <div class="card">
            @can('create', \CzechitasApp\Models\User::class)
                <div class="card-header text-right">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-info"><i class="fa fa-fw mr-1 fa-plus-circle "></i>{{ trans('app.actions.create') }}</a>
                </div>
            @endcan
            {{-- <div class="card-body"> --}}
                <table class="table table-striped" data-table>
                    <thead>
                        <tr>
                            <th>{{ trans('users.table.name') }}</th>
                            <th>{{ trans('users.table.email') }}</th>
                            <th>{{ trans('users.table.role') }}</th>
                            <th style="width: 10%">{{ trans('users.table.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ trans('users.table.name') }}</th>
                            <th>{{ trans('users.table.email') }}</th>
                            <th>{{ trans('users.table.role') }}</th>
                            <th>{{ trans('users.table.action') }}</th>
                        </tr>
                    </tfoot>
                </table>

                {{-- Buttons template --}}
                <div class="d-none action_buttons_template">
                    <div class="btn-group" role="group">
                          <a href="{{ route('admin.users.show',["__placeholder__"]) }}" data-can="view" title="@lang('app.actions.show')" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-info-circle"></i></a>
                          <a href="{{ routeBack('admin.users.edit',["__placeholder__"], 'list') }}" data-can="update" title="@lang('app.actions.edit')" class="btn btn-sm btn-success"><i class="fa fa-fw fa-edit"></i></a>
                          <a href="{{ route('admin.users.delete', ["__placeholder__"]) }}" data-can="delete" title="@lang('app.actions.destroy')" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-ban"></i> / <i class="fa fa-fw fa-trash"></i></a>
                          <a href="#unblockUser__placeholder__" data-toggle="modal" data-can="unblock" title="@lang('users.actions.unblock')" class="btn btn-sm btn-warning"><i class="fa fa-fw fa-user-check"></i></a>
                    </div>
                    <div data-can="unblock">
                        @component('components.modal_yes_no_form', [ 'id' => 'unblockUser__placeholder__', 'method' => 'POST', 'route' => route('admin.users.unblock', "__placeholder__")] )
                            @lang('users.unblock_modal', ['name' => '{= data.name =}'])
                        @endcomponent
                    </div>
                </div>
            {{-- </div> --}}

            </div>
        </div>
    </div>
@endsection
