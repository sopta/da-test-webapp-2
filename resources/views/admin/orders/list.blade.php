@extends('layouts.app')

@section('title', trans('orders.title'))

@section('scripts')
    <script type="text/javascript">
        CzechitasApp.datatables.init({
            ajax: {
                url: "{{ route('admin.orders.ajax_list') }}",
                error: CzechitasApp.datatables.ajaxError
            },
            processing: true,
            serverSide: true,
            columns: CzechitasApp.datatables.formatColumns(@json($columnNames), ['id']),
            order: [[3, "asc"],[1, "asc"]],
            columnDefs: [{ targets: 1, responsivePriority: 1},{
                targets: 2,
                data: "contact_name",
                render: function (data, type, row, meta) {
                    // data == ID
                    // row == all data
                    $wrap = $("<div>").
                        append($("<a>").attr("href", "mailto:"+row.contact_mail).text(row.contact_mail)).
                        append(", Tel: "+row.contact_tel);
                    return data+"<br>"+$wrap.html();
                }
            },
            {
                targets: 0,
                data: "flag",
                render: CzechitasApp.datatables.getRenderer('flag', $(".flag_change_template")),
            },
            {
                targets: 5,
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
            <div class="card-header text-right">
                <a href="{{ route('orders.create') }}" class="btn btn-sm btn-info"><i class="fa fa-fw mr-1 fa-plus-circle "></i>{{ trans('app.actions.create') }}</a>
            </div>
                <table class="table table-striped" data-table>
                    <thead>
                        <tr>
                            <th><i class="fa fa-flag"></i></th>
                            <th>{{ trans('orders.table.client') }}</th>
                            <th>{{ trans('orders.table.contact') }}</th>
                            <th>{{ trans('orders.table.signed') }}</th>
                            <th>{{ trans('orders.table.type') }}</th>
                            <th style="width: 10%">{{ trans('orders.table.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th><i class="fa fa-flag"></i></th>
                            <th>{{ trans('orders.table.client') }}</th>
                            <th>{{ trans('orders.table.contact') }}</th>
                            <th>{{ trans('orders.table.signed') }}</th>
                            <th>{{ trans('orders.table.type') }}</th>
                            <th>{{ trans('orders.table.action') }}</th>
                        </tr>
                    </tfoot>
                </table>
                {{-- Buttons template --}}
                <div class="d-none action_buttons_template">
                    <div class="btn-group" role="group">
                          <a href="{{ route('admin.orders.show', ["__placeholder__"]) }}" data-can="view" title="@lang('app.actions.show')" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-info-circle"></i></a>
                          <a href="{{ routeBack('admin.orders.edit',["__placeholder__"], 'list') }}" data-can="update" title="@lang('app.actions.edit')" class="btn btn-sm btn-success"><i class="fa fa-fw fa-edit"></i></a>
                          <a href="#deleteOrder__placeholder__" data-toggle="modal" data-can="delete" title="@lang('app.actions.destroy')" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></a>
                    </div>
                    <div data-can="delete">
                        @component('components.modal_yes_no_form', [ 'id' => 'deleteOrder__placeholder__', 'route' => route('admin.orders.destroy', "__placeholder__")] )
                        @endcomponent
                    </div>
                </div>
                {{-- Flag change popup --}}
                <div class="d-none flag_change_template">
                    <a href="#flagChange__placeholder__" data-toggle="modal" class="btn btn-sm {= data.class_name =}"><i class="fa fa-fw {= data.flag_icon =}"></i></a>
                    <div data-can="updateFlag">
                        @component('components.flag_change', [ 'id' => 'flagChange__placeholder__', 'route' => route('admin.orders.flag_change', "__placeholder__")] )
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
