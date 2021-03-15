@extends('layouts.app')

@section('title', trans('students.title_detail', ['student' => $student->name]))
@section('header', $student->name)

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">

                <div class="card-header text-right">
                    <div class="btn-group flex-wrap mb-1" role="group">
                        @if (Auth::user()->can('sendEmails', $student) && $student->sendEmails()->count() > 0)
                            <a href="{{ route('admin.students.send_emails', $student) }}" title="@lang('students.send_emails.button')" class="btn btn-sm btn-success"><i class="fa fa-fw fa-envelope pr-1"></i>@lang('students.send_emails.button')</a>
                        @endif
                        @if ($student->studentPayments->count() > 0)
                            <button type="button" title="@lang('students.payments.history.show_short')" data-toggle="modal" data-target="#studentPaymentHistory" class="btn btn-sm btn-info"><i class="fa fa-fw fa-dollar-sign pr-1"></i>@lang('students.payments.history.show_short')</button>
                        @endif
                        @can('addPayment', $student)
                            <button type="button" title="@lang('students.payments.insert.new')" data-toggle="modal" data-target="#addStudentPayment" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-dollar-sign pr-1"></i>@lang('students.payments.insert.new')</button>
                        @endcan
                        @can('update', $student)
                            <a href="{{ route('admin.students.edit', $student) }}" title="@lang('app.actions.edit')" class="btn btn-sm btn-success"><i class="fa fa-fw fa-edit pr-1"></i>@lang('students.table.edit')</a>
                        @endcan
                    </div>
                    <div class="btn-group flex-wrap mb-1" role="group">
                        @can('logout', $student)
                            <button type="button" title="@lang('students.logout.button')" data-toggle="modal" data-target="#studentLogOut" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-ban pr-1"></i>@lang('students.logout.button')</button>
                        @endcan
                        @can('cancel', $student)
                            <button type="button" title="@lang('students.cancel.button')" data-toggle="modal" data-target="#studentCancel" class="btn btn-sm btn-dark"><i class="fa fa-fw fa-minus-circle pr-1"></i>@lang('students.cancel.button')</button>
                        @endcan
                    </div>
                </div>

                <div class="card-body border-bottom">
                    @php
                        $warnings = [];
                        if($student->canceled){
                            $warnings[] = trans('students.warnings.canceled', ['reason' => e($student->canceled)]);
                        }else if($student->logged_out){
                            $msg = null;
                            if(empty($student->logged_out_date)){
                                $msg = empty($student->alternate)
                                    ? trans('students.warnings.logged_out')
                                    : trans('students.warnings.logged_out_alternate', ['alternate' => e($student->alternate) ] );
                            }else{
                                $msg = empty($student->alternate)
                                    ? trans('students.warnings.logged_out_date', ['since' => $student->logged_out_date->format("d.m.Y H:i")])
                                    : trans('students.warnings.logged_out_date_alternate', [
                                        'alternate' => e($student->alternate),
                                        'since' => $student->logged_out_date->format("d.m.Y H:i")
                                    ] );
                            }
                            $msgReason = null;
                            if($student->logged_out === \CzechitasApp\Models\Enums\StudentLogOutType::ILLNESS) {
                                $msgReason = trans('students.warnings.logged_out_illness');
                            } else {
                                $msgReason = empty($student->logged_out_reason)
                                    ? trans('students.warnings.logged_out_other')
                                    : trans('students.warnings.logged_out_reason', ['reason' => e($student->logged_out_reason)]);
                            }
                            $warnings[] = "{$msg} - {$msgReason}";
                        }
                    @endphp
                    @if (!empty($warnings))
                        <div class="alert alert-warning" role="alert">
                          <ul class="m-0">
                              @foreach ($warnings as $note)
                                  <li>{!! $note !!}</li>
                              @endforeach
                          </ul>
                        </div>
                    @endif
                    <h6>
                        @lang('terms.form.term_range'): <a href="{{ route('admin.terms.show', $student->term) }}">{{ $student->term->term_range }}</a><br>{{ $student->term->category->name }}
                    </h6>
                </div>

                <table class="table table-twocols border-top">
                    <tr>
                        <td>@lang('students.form.created_at'):</td>
                        <td>
                            {{ $student->created_at->format("d.m.Y H:i") }}
                            <a href="{{ route('admin.users.show', $student->parent_id) }}" class="btn btn-sm btn-success ml-4">@lang('students.form.parent_detail')</a>
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('students.form.payment'):</td>
                        <td>
                            <strong>
                                {{ trans('students.payments.'.($student->payment ?? 'none')) }}
                            </strong>
                            <br>
                            @if ($student->payment !== \CzechitasApp\Models\Enums\StudentPaymentType::FKSP)
                                @lang('students.form.v_symbol'): <strong>{{ $student->variable_symbol }}</strong><br>
                            @endif
                            @lang('students.form.price'): <strong>{{ formatPrice($student->price_to_pay) }}</strong>
                            @if ($student->studentPayments->count() > 0)
                                <br><button type="button" data-toggle="modal" class="btn btn-info" data-target="#studentPaymentHistory"><i class="fa fa-fw fa-dollar-sign pr-1"></i>@lang('students.payments.history.show')</button>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('students.form.parent_name'):</td>
                        <td>{{ $student->parent_name }}</td>
                    </tr>

                    <tr>
                        <td>@lang('students.form.forename'):</td>
                        <td>{{ $student->forename }}</td>
                    </tr>

                    <tr>
                        <td>@lang('students.form.surname'):</td>
                        <td>{{ $student->surname }}</td>
                    </tr>

                    <tr>
                        <td>@lang('students.form.birthday'):</td>
                        <td>{{ $student->birthday }}</td>
                    </tr>

                    <tr>
                        <td>@lang('students.form.email'):</td>
                        <td>{{ $student->email }}</td>
                    </tr>
                    @if (!empty($student->restrictions))
                        <tr>
                            <td>@lang('students.form.restrictions'):</td>
                            <td>{{ $student->restrictions }}</td>
                        </tr>
                    @endif
                    @if (!empty($student->note))
                        <tr>
                            <td>@lang('students.form.note'):</td>
                            <td>{{ $student->note }}</td>
                        </tr>
                    @endif
                    @if (!empty($student->private_note))
                        <tr>
                            <td>@lang('students.form.note_private'):</td>
                            <td>{{ $student->private_note }}</td>
                        </tr>
                    @endif
                    @canany(['certificateLogin', 'certificatePayment'], $student) <tr>
                            <td>@lang('students.form.certificate')</td>
                            <td>
                                @can('certificateLogin', $student)
                                    <a href="{{ route('students.certificate.login', $student) }}" title="@lang('students.certificates.login_download')" class="mb-1 btn btn-sm btn-success"><i class="fa fa-fw fa-file-pdf pr-1"></i>@lang('students.certificates.login_download')</a><br>
                                @endcan
                                @can('certificatePayment', $student)
                                    <a href="{{ route('students.certificate.payment', $student) }}" title="@lang('students.certificates.payment_download')" class="mb-1 btn btn-sm btn-success"><i class="fa fa-fw fa-file-pdf pr-1"></i>@lang('students.certificates.payment_download')</a><br>
                                @endcan
                            </td>
                        </tr>
                    @endcanany
                </table>
            </div>
        </div>
    </div>
    @if ($student->studentPayments->count() > 0)
        @component('components.student_payment_history', ['student' => $student])
        @endcomponent
    @endif

    @can('addPayment', $student)
        @include('admin.students.modals.add_payment')
    @endcan
    @can('logout', $student)
        @include('admin.students.modals.logout')
    @endcan
    @can('cancel', $student)
        @include('admin.students.modals.cancel')
    @endcan

@endsection
