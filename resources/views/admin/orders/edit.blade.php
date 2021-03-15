@extends('layouts.app')

@section('title', trans('orders.title'))
@section('header', trans('orders.breadcrumbs.edit'))

@section('scripts')
    <script type="text/javascript">
        $("#onlySave").click(function (e) { $(".adminOnlyBlock").find("input, textarea").prop("required", false); });
        CzechitasApp.addToConfig("orders", {
            aresUrl: "{{ route('orders.ares') }}",
            successMsg: "{{ trans('orders.success.ares') }}",
            notFoundMsg: "{{ trans('orders.error.ares_missing_ico') }}",
            errorMsg: "{{ trans('orders.error.ares') }}",
            ares_searching: "{{ trans('orders.form.ares_searching') }}",
        });
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col col-lg-8">
            <div class="card">
                <div class="card-header text-sm-right">
                    <div class="btn-group" role="group">
                        @can('delete', $order)
                            @component('components.modal_yes_no_form', [ 'id' => 'deleteOrder', 'route' => route('admin.orders.destroy', $order)] )
                            @endcomponent
                            <a href="#deleteOrder" data-toggle="modal" class="btn btn-sm btn-danger">
                                <i class="fa fa-fw fa-trash"></i>
                                <span class="d-none d-sm-inline">@lang('app.actions.destroy')</span>
                            </a>
                         @endcan
                    </div>
                </div>
                <div class="card-body">
                    <h3>@lang('orders.form.common_heading')</h3>
                    <form action="{{ routeBack('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @include('admin.orders.forms.common')

                        <hr>
                        <h4>@lang('orders.form.service_heading') - {{ trans('orders.form.'.$order->type) }}</h4>

                        @if ($order->type == \CzechitasApp\Models\Enums\OrderType::CAMP)
                            @include('admin.orders.forms.camp')
                        @else
                            @include('admin.orders.forms.school_nature')
                        @endif

                        <hr>
                        <h3>@lang('orders.form.admin_part_heading')</h3>

                        @include('admin.orders.forms.admin')

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" id="onlySave" name="save" value="@lang('orders.form.submit')">
                            <input type="submit" class="btn btn-secondary" name="save_term" value="@lang('orders.form.submit_term')">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
