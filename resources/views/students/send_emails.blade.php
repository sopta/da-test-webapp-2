@extends('layouts.app')

@section('title', trans('students.title_send_emails', ['student' => $student->name]))
@section('header', $student->name)

@section('scripts')
    <script type="text/javascript">
        CzechitasApp.datatables.init({
            order: [[0, "desc"]],
            columnDefs: [{ targets: 0, responsivePriority: 1},{ targets: 3, orderable: false, responsivePriority: 2}]
        });
        CzechitasApp.magnificPopup.init();
        $(".linkToPreview").click(function (e) {
            e.preventDefault();
            CzechitasApp.magnificPopup.open(
                {
                    type: 'iframe',
                    src: $(this).attr("href"),
                }, {
                    enableEscapeKey: true,
                    closeOnBgClick: true
                }
            );
        });
    </script>
@endsection

@section('content')
    <style>
        .mfp-iframe-holder .mfp-content{ max-width: 800px }
    </style>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header alert-warning">
                    <i class="fa fa-fw fa-exclamation-triangle mr-2"></i>@lang('students.send_emails.mail_save_delay')
                </div>
                <table class="table table-striped" data-table>
                    <thead>
                        <tr>
                            <th>{{ trans('students.send_emails.created_at') }}</th>
                            <th>{{ trans('students.send_emails.to') }}</th>
                            <th>{{ trans('students.send_emails.subject') }}</th>
                            <th style="width: 10%">{{ trans('students.table.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student->sendEmails as $email)
                            <tr>
                                <td data-order="{{ $email->created_at->format("YmdHis") }}">{{ $email->created_at->format("d.m.Y H:i") }}</td>
                                <td>{{ $email->to }}</td>
                                <td>{{ $email->subject }}</td>
                                <td>
                                    <a href="{{ route('students.send_emails.show', [$student, $email]) }}" class="btn btn-sm btn-info linkToPreview"><i class="fa fa-fw fa-info-circle pr-1"></i>@lang('students.send_emails.show_content')</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ trans('students.send_emails.created_at') }}</th>
                            <th>{{ trans('students.send_emails.to') }}</th>
                            <th>{{ trans('students.send_emails.subject') }}</th>
                            <th>{{ trans('students.table.action') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
