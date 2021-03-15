@extends('layouts.app')

@section('title', trans('terms.title'))

@section('scripts')
    <script type="text/javascript">
        CzechitasApp.datatables.init({
            iDisplayLength: 100,
            columnDefs: [{targets: 0, responsivePriority: 1},{ targets: 1, responsivePriority: 1},{ targets: -1, orderable: false, responsivePriority: 2}],
            disableSearchAutoFocus: false,
            order: [[0, "asc"], [1, 'asc']]
        });
        var CzechitasAppTable = $("table[data-table]").on('finished.dt.custom', function () {
            CzechitasApp.datatables.instance.on( 'order.dt search.dt', function () {
                var i = 1;
                CzechitasApp.datatables.instance.column(0).nodes().each( function (cell) {
                    if(!$(cell).parent("tr").attr("class").match(/table-/i)){
                        $(cell).text(i++);
                    }
                } );
            } ).draw();
        });
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header text-right">
                    <div class="btn-group" role="group">
                        @can('update', $term)
                            <a href="{{ route('admin.terms.edit', [$term]) }}" class="btn btn-sm btn-success">
                                <i class="fa fa-fw fa-edit"></i>
                                <span class="d-none d-md-inline">@lang('app.actions.edit')</span>
                            </a>
                        @endcan
                        @can('delete', $term)
                            @component('components.modal_yes_no_form', [ 'id' => 'deleteTerm', 'route' => route('admin.terms.destroy', $term)] )
                                @lang('terms.delete_modal', ['name' => $term->name])
                            @endcomponent
                            <a href="#deleteTerm" data-toggle="modal" class="btn btn-sm btn-danger">
                                <i class="fa fa-fw fa-trash"></i>
                                <span class="d-none d-md-inline">@lang('app.actions.destroy')</span>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body border-bottom">
                    <h4>
                        @lang('terms.form.term_range'): {{ $term->term_range }}<br>{{ $term->category->name }}
                    </h4>
                </div>
                @can('viewDetails', $term)
                    <div class="row m-0 border-bottom">
                        <div class="col-md-6 p-0 border-right">
                            <table class="table table-twocols">
                                @can('update', $term)
                                    <tr>
                                        <td>@lang('app.change_flag.flag')</td>
                                        <td>
                                            <a href="#flagChange{{ $term->id }}" data-toggle="modal" class="btn btn-sm {{ $term->flag ? 'btn-'.$term->flag : 'text-muted' }}">
                                                <i class="fa fa-fw {{ config('czechitas.flags.'.($term->flag ?: 'default')) }} mr-2"></i>
                                                @lang('app.change_flag.change')
                                            </a>
                                            @component('components.flag_change', [ 'id' => 'flagChange'.$term->id, 'route' => route('admin.terms.flag_change', $term->id)] )
                                            @endcomponent
                                        </td>
                                    </tr>
                                @endcan
                                @if ($term->opening && $term->opening->gt(\Carbon\Carbon::now()))
                                    <tr>
                                        <td>@lang('terms.form.opening')</td>
                                        <td class="{{ $term->isPossibleLogin() ? null : 'text-danger' }}">
                                            {{ $term->isPossibleLogin() ? null : trans('terms.form.opening_not_yet') }} {{ $term->opening->format("d.m.Y H:i") }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>@lang('terms.form.price')</td>
                                    <td>
                                        <strong>{{ formatPrice($term->price) }}</strong><br>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 p-0">
                            <div class="p-3">
                                <h4>@lang('terms.form.note_public')</h4>
                                {{ markdownToHtml($term->note_public) }}
                            </div>
                        </div>
                    </div>
                @endcan

                <table class="table table-striped" data-table>
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th>{{ trans('students.table.name') }}</th>
                            <th>{{ trans('students.table.created') }}</th>
                            @if (Auth::user()->isAdminOrMore())
                                <th>{{ trans('students.table.price') }}</th>
                            @endif
                            <th>{{ trans('students.table.restrictions') }}</th>
                            <th style="width: 10%">{{ trans('students.table.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr class="{{ studentListClass($student) }}">
                                <td data-order="{{ studentSortNumber($student) }}"></td>
                                <td>{{ $student->surname }} {{ $student->forename }}</td>
                                <td data-order="{{ $student->created_at->format("Ymd") }}">{{ $student->created_at->format("d.m.Y H:i") }}</td>
                                @if (Auth::user()->isAdminOrMore())
                                    <td data-order="{{ $student->price_to_pay }}">
                                        {{ formatPrice($student->price_to_pay) }}
                                    </td>
                                @endif
                                <td>
                                    @if (!empty($student->restrictions))
                                        <span data-toggle="tooltip" title="{{ $student->restrictions }}">
                                            <i class="fa fa-fw fa-info-circle pr-1"></i>@lang('students.table.restrictions_info')
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('view', $student)
                                            <a href="{{ route('admin.students.show', $student) }}" title="@lang('app.actions.show')" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-info-circle pr-1"></i>@lang('students.table.info')</a>
                                        @endcan
                                        @can('update', $student)
                                            <a href="{{ routeBack('admin.students.edit', $student, 'term') }}" title="@lang('app.actions.edit')" class="btn btn-sm btn-success"><i class="fa fa-fw fa-edit pr-1"></i>@lang('students.table.edit')</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('students.table.name') }}</th>
                            <th>{{ trans('students.table.created') }}</th>
                            @if (Auth::user()->isAdminOrMore())
                                <th>{{ trans('students.table.price') }}</th>
                            @endif
                            <th>{{ trans('students.table.restrictions') }}</th>
                            <th>{{ trans('students.table.action') }}</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
@endsection
