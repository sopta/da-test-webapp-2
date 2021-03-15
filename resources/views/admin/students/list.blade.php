@extends('layouts.app')

@section('title', trans('students.title'))

@section('scripts')
    <script type="text/javascript">
        CzechitasApp.datatables.init({
            ajax: {
                url: "{{ route('admin.students.ajax_list') }}",
                error: CzechitasApp.datatables.ajaxError
            },
            processing: true,
            serverSide: true,
            withArchiveFilter: true,
            createdRow: function( row, data, dataIndex ) {
                if ( data.rowClass ) {
                    $(row).addClass( data.rowClass );
                }
            },
            columns: CzechitasApp.datatables.formatColumns(@json($columnNames), ['id']),
            order: [[0, "asc"]],
            columnDefs: [{ targets: 0, responsivePriority: 1},{
                targets: 1,
                data: @json($columnNames[1]),
                orderable: false,
                render: function (data, type, row, meta) {
                    // data == ID
                    // row == all data
                    if(!row.term_id){
                        return data;
                    }
                    $wrap = $("<div>").append($("<a>").attr("href", "{{ route('admin.terms.show', ["__placeholder__"]) }}".replace("__placeholder__", row.term_id)).text(data));
                    return $wrap.html();
                }
            },
            { targets: 2, orderable: false},
            { targets: 3, orderable: false},
            {
                targets: 4,
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
                <div class="btn-group" role="group">
                    @can('create', \CzechitasApp\Models\Student::class)
                        <a href="{{ route('admin.students.create') }}" class="btn btn-sm btn-info"><i class="fa fa-fw mr-1 fa-plus-circle "></i>{{ trans('app.actions.create') }}</a>
                    @endcan
                </div>
            </div>
                <table class="table table-striped" data-table>
                    <thead>
                        <tr>
                            <th>{{ trans('students.table.name') }}</th>
                            <th>{{ trans('students.table.term') }}</th>
                            <th>{{ trans('students.table.payment') }}</th>
                            <th>{{ trans('students.table.price') }}</th>
                            <th style="width: 10%">{{ trans('students.table.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ trans('students.table.name') }}</th>
                            <th>{{ trans('students.table.term') }}</th>
                            <th>{{ trans('students.table.payment') }}</th>
                            <th>{{ trans('students.table.price') }}</th>
                            <th>{{ trans('students.table.action') }}</th>
                        </tr>
                    </tfoot>
                </table>
                {{-- Buttons template --}}
                <div class="d-none action_buttons_template">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.students.show', ["__placeholder__"]) }}" data-can="view" title="@lang('app.actions.show')" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-info-circle"></i></a>
                        <a href="{{ routeBack('admin.students.edit',["__placeholder__"], 'list') }}" data-can="update" title="@lang('app.actions.edit')" class="btn btn-sm btn-success"><i class="fa fa-fw fa-edit"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
