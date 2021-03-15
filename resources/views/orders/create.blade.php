@extends('layouts.app')

@section('title', trans('orders.breadcrumbs.create'))

@section('scripts')
    <script type="text/javascript">
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // console.log(e.target);
            disableAllInputs();
            var selector = Util.getSelectorFromElement(e.target);
            enableInputsIn(selector);
        });
        function disableAllInputs() {
            $("#orderCreateTabs").find("input, select").prop("disabled", true);
        }
        function enableInputsIn(selector) {
            $(selector).find("input, select").prop("disabled", false);
        }
        disableAllInputs();
        enableInputsIn("#orderCreateTabs .tab-pane.active");
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
        <div class="col col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h3>@lang('orders.form.common_heading')</h3>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        @include('orders.forms.common')

                        <hr>
                        <h4>@lang('orders.form.service_heading')</h4>

                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link {{ oldExists('camp', 'active') }}" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                    @lang('orders.form.camp')
                                </a>
                                <a class="nav-item nav-link {{ oldExists('school_nature', 'active') }}" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                    @lang('orders.form.school_nature')
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content" id="orderCreateTabs">
                            <div class="tab-pane fade {{ oldExists('camp', 'show active') }}" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                @include('orders.forms.camp')

                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="camp" value="@lang('orders.form.submit')">
                                </div>
                            </div>
                            <div class="tab-pane fade {{ oldExists('school_nature', 'show active') }}" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                @include('orders.forms.school_nature')

                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="school_nature" value="@lang('orders.form.submit')">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
