@extends('layouts.app')

@section('title', trans('orders.title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header d-sm-flex justify-content-between">
                    <h5 class="mb-0 py-1">@lang('orders.show.header')</h5>

                    <div class="btn-group" role="group">
                        @can('update', $order)
                            <a href="{{ route('admin.orders.edit', [$order]) }}" class="btn btn-sm btn-success">
                                <i class="fa fa-fw fa-edit"></i>
                                <span class="d-none d-md-inline">@lang('app.actions.edit')</span>
                            </a>
                        @endcan
                        @can('delete', $order)
                            @component('components.modal_yes_no_form', [ 'id' => 'deleteOrder', 'route' => route('admin.orders.destroy', $order)] )
                            @endcomponent
                            <a href="#deleteOrder" data-toggle="modal" class="btn btn-sm btn-danger">
                                <i class="fa fa-fw fa-trash"></i>
                                <span class="d-none d-md-inline">@lang('app.actions.destroy')</span>
                            </a>
                         @endcan
                    </div>
                </div>
                <table class="table table-twocols">
                    <tr>
                        <td>@lang('app.change_flag.flag')</td>
                        <td>
                            <a href="#flagChange{{ $order->id }}" data-toggle="modal" data-can="update" class="btn btn-sm {{ $order->flag ? 'btn-'.$order->flag : 'text-muted' }}">
                                <i class="fa fa-fw {{ config('czechitas.flags.'.($order->flag ?: 'default')) }} mr-2"></i>
                                @lang('app.change_flag.change')
                            </a>
                            <div data-can="update">
                                @component('components.flag_change', [ 'id' => 'flagChange'.$order->id, 'route' => route('admin.orders.flag_change', $order->id)] )
                                @endcomponent
                            </div>
                        </td>
                    </tr>
                    @if ($order->isSigned())
                        <tr class="alert-success">
                            <td>@lang('orders.form.signed'):</td>
                            <td>@lang('orders.form.signed_detail', ['date' => $order->signature_date])</td>
                        </tr>
                    @endif
                    <tr>
                        <td>@lang('app.timestamps.created_at') / @lang('app.timestamps.updated_at'):</td>
                        <td>{{ $order->created_at }} / {{ $order->updated_at }}</td>
                    </tr>
                    <tr>
                        <td>@lang('orders.form.service_heading'):</td>
                        <td>{{ trans('orders.type.'.$order->type) }}</td>
                    </tr>
                    <tr>
                        <td>@lang('orders.form.client'):</td>
                        <td>{{ $order->client }}, @lang('orders.form.ico'): {{ $order->ico }}</td>
                    </tr>
                    <tr>
                        <td>@lang('orders.form.address'):</td>
                        <td>{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <td>@lang('orders.form.substitute'):</td>
                        <td>{{ $order->substitute }}</td>
                    </tr>
                    <tr>
                        <td>@lang('orders.form.contact_heading'):</td>
                        <td>
                            {{ $order->contact_name }}<br>
                            @lang('orders.form.contact_mail'): <a href="mailto:{{ $order->contact_mail }}">{{ $order->contact_mail }}</a>,
                            @lang('orders.form.contact_tel'): {{ $order->contact_tel }}
                        </td>
                    </tr>
                    @if (!empty($order->final_date_from))
                        <tr>
                            <td>@lang('orders.form.final_date_heading'):</td>
                            <td>
                                <strong>
                                    {{ $order->final_date_from }} - {{ $order->final_date_to }}
                                    @if ($order->type == \CzechitasApp\Models\Enums\OrderType::CAMP)
                                        <br>{{ trans('orders.form.'.$order->getXData('date_part')) }}
                                    @endif
                                </strong>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>@lang('orders.form.dates_heading'):</td>
                        <td>
                            {{ $order->start_date_1 }} - {{ $order->getXData('end_date_1') }}@if (!empty($order->start_date_2))<br>{{ $order->start_date_2 }} - {{ $order->getXData('end_date_2') }}@endif{{ "" }}@if (!empty($order->start_date_3))<br>{{ $order->start_date_3 }} - {{ $order->getXData('end_date_3') }}@endif
                            @if ($order->type == \CzechitasApp\Models\Enums\OrderType::CAMP)
                                <br>{{ trans('orders.form.'.$order->getXData('date_part')) }}
                            @endif
                        </td>
                    </tr>
                    {{-- SCHOOL_NATURE --}}
                    @if ($order->type == \CzechitasApp\Models\Enums\OrderType::SCHOOL_NATURE )
                        <tr>
                            <td>@lang('orders.form.start_time') &amp; {{ Str::lower(trans('orders.form.end_time')) }}:</td>
                            <td>
                                {{ $order->getXData('start_time') }} -
                                    @lang('orders.form.start_food') <strong>{{ Str::lower(trans('orders.form.'.$order->getXData('start_food'))) }}</strong><br>
                                {{ $order->getXData('end_time') }} -
                                    @lang('orders.form.end_food') <strong>{{ Str::lower(trans('orders.form.'.$order->getXData('end_food'))) }}</strong>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>@lang('orders.form.students'):</td>
                        <td>
                            <strong>{{ $order->getXData('students') }}</strong> @lang('orders.form.age') <strong>{{ $order->getXData('age') }}</strong><br>
                            @lang('orders.form.adults') <strong>{{ $order->getXData('adults') }}</strong>
                        </td>
                    </tr>

                    {{--
                        ADMIN - PRIVATE PART
                     --}}
                    <tr>
                        <td class="bg-light text-center" colspan="2">@lang('orders.show.admin_part_header')</td>
                    </tr>

                    <tr>
                        <td>@lang('orders.form.price_heading'):</td>
                        <td>
                            @lang('orders.form.price_kid'): {{ formatPrice($order->getXData('price_kid')) }}<br>
                            @lang('orders.form.price_adult'): {{ formatPrice($order->getXData('price_adult')) }}<br>
                        </td>
                    </tr>

                    <tr>
                        <td>@lang('orders.form.price_total'):</td>
                        <td>
                            @if ($order->getXData('price_kid') > 0)
                                {{ $order->getXData('students') }} * {{ formatPrice($order->getXData('price_kid')) }} ({{ trans('orders.form.price_kid') }})
                                + {{ $order->getXData('adults') }} * {{ formatPrice($order->getXData('price_adult')) }} ({{ trans('orders.form.price_adult') }})
                                = {{ formatPrice($order->total_price) }}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
