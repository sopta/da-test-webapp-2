<div class="modal" tabindex="-1" role="dialog" id="studentPaymentHistory" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">@lang('students.payments.history.heading')</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped w-100" style="min-width: 465px;">
                        <tr>
                            <th style="width: 18%;">@lang('students.payments.history.date')</th>
                            <th style="width: 20%;">@lang('students.payments.history.type')</th>
                            <th>@lang('students.payments.history.price')</th>
                            <th>@lang('students.payments.history.note')</th>
                        </tr>

                        @php
                            $payments = $student->studentPayments()->orderBy('received_at', 'desc');
                            if(Auth::user()->can('addPayment', $student)){
                                $payments->with('user');
                            }
                        @endphp

                        @foreach ($payments->get() as $payment)
                            <tr>
                                <td>
                                    {{ $payment->received_at->format("d.m.Y H:i") }}
                                    @if ($payment->isInsertedBackward())
                                        <span data-toggle="tooltip" title="@lang('students.payments.history.created_at', ['date' => $payment->created_at->format('d.m.Y H:i')])" class="text-warning">
                                            <i class="fa fa-fw fa-exclamation-triangle pl-1"></i>
                                        </span>
                                    @endif
                                    @if ($payment->user)
                                        @can('addPayment', $student)
                                            <br>@lang('students.payments.history.added', ['name' => $payment->user->name])
                                        @endcan
                                    @endif
                                </td>
                                <td>
                                    {{ $payment->price < 0 ? trans('students.payments.return').' - ' : null }}
                                    {{ trans('students.payments.'.$payment->payment) }}
                                </td>
                                <td>{{ formatPrice($payment->price) }}</td>
                                <td>{{ $payment->note }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
