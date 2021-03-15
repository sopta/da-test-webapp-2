@extends('layouts.app')

@section('title', trans('students.title'))

@section('scripts')
    <script type="text/javascript">
        CzechitasApp.datatables.init({
            columnDefs: [{ targets: 0, responsivePriority: 1},{ targets: 4, orderable: false, responsivePriority: 2}]
        });
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">
        <div class="card">
            <div class="card-header text-right">
                <a href="{{ route('students.create') }}" class="btn btn-sm btn-info"><i class="fa fa-fw mr-1 fa-plus-circle "></i>{{ trans('students.create_button') }}</a>
            </div>
            {{-- <div class="card-body"> --}}
                <table class="table table-striped" data-table>
                    <thead>
                        <tr>
                            <th>{{ trans('students.table.name') }}</th>
                            <th>{{ trans('students.table.category') }}</th>
                            <th>{{ trans('students.table.term') }}</th>
                            <th>{{ trans('students.table.price') }}</th>
                            <th style="width: 10%">{{ trans('students.table.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr class="{{ studentListClass($student) }}">
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->term->category->name }}</td>
                                <td data-order="{{ $student->term->start->format("Ymd") }}">{{ $student->term->term_range }}</td>
                                <td data-order="{{ $student->price_to_pay }}">{{ formatPrice($student->price_to_pay) }}</td>
                                <td>
                                    @if ($student->canceled !== null)
                                        <span data-toggle="tooltip" title="@lang('students.table.canceled_desc', ['reason' => $student->canceled])">
                                            <i class="fa fa-fw fa-info-circle pr-1"></i>@lang('students.table.canceled')
                                        </span>
                                    @endif
                                    <div class="btn-group" role="group">
                                        @can('view', $student)
                                            <a href="{{ route('students.show', $student) }}" title="@lang('app.actions.show')" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-info-circle pr-1"></i>@lang('students.table.info')</a>
                                        @endcan
                                        @can('update', $student)
                                            <a href="{{ routeBack('students.edit', $student, 'list') }}" title="@lang('app.actions.edit')" class="btn btn-sm btn-success"><i class="fa fa-fw fa-edit pr-1"></i>@lang('students.table.edit')</a>
                                        @endcan
                                        @can('logout', $student)
                                            <a href="{{ routeBack('students.logout', $student, 'list') }}" title="@lang('app.actions.edit')" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-ban pr-1"></i>@lang('students.table.logout')</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ trans('students.table.name') }}</th>
                            <th>{{ trans('students.table.category') }}</th>
                            <th>{{ trans('students.table.term') }}</th>
                            <th>{{ trans('students.table.price') }}</th>
                            <th>{{ trans('students.table.action') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
