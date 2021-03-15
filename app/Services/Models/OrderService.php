<?php

declare(strict_types=1);

namespace CzechitasApp\Services\Models;

use CzechitasApp\Models\Order;
use CzechitasApp\Notifications\Order\OrderCreatedNotification;
use CzechitasApp\Notifications\Order\OrderSignedNotification;
use CzechitasApp\Services\Models\ModelBaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

/**
 * @method Order getContext()
 * @method Builder<Order> getQuery()
 */
class OrderService extends ModelBaseService
{
    /**
     * Get FQCN order model
     */
    public function getModel(): string
    {
        return Order::class;
    }

    /**
     * Get list query for AJAX
     */
    public function getListQuery(): Builder
    {
        return $this->getQuery();
    }

    /**
     * Save new order and set context
     *
     * @param  array<string, mixed> $data Order data
     * @return Order Created order
     */
    public function insert(array $data): Order
    {
        $order = $this->getModel()::create($data);
        try {
            $notification = new OrderCreatedNotification($order);
            $order->notify($notification);
            if ($order->routeNotificationFor('mail') !== \config('czechitas.admin_mail')) {
                Notification::route('mail', \config('czechitas.admin_mail'))->notify($notification);
            }
        } catch (\Throwable $e) {
            Log::warning($e->getMessage(), ['exception' => $e]);
        }
        $this->setContext($order);

        return $order;
    }

    /**
     * Update context order
     *
     * @param array<string, mixed> $data
     */
    public function update(array $data): bool
    {
        // Laravel does not support updating for non-JSON DB columns anymore, we have to merge it by ourselves
        if (isset($data['xdata'])) {
            $data['xdata'] = \array_merge($this->getContext()->xdata, $data['xdata']);
        }
        $ret = $this->getContext()->update($data);

        if (!empty($data['signature_date'])) {
            try {
                $this->getContext()->notify(new OrderSignedNotification($this->getContext()));
            } catch (\Throwable $e) {
                Log::warning($e->getMessage(), ['exception' => $e]);
            }
        }

        return $ret;
    }

    /**
     * Update context term from Update flag request
     *
     * @param array<string, mixed> $data
     */
    public function flagUpdate(array $data): bool
    {
        return $this->getContext()->update([
            'flag' => $data['flag'] ?? null,
        ]);
    }

    /**
     * Delete context order
     */
    public function delete(): ?bool
    {
        return $this->getContext()->delete();
    }
}
