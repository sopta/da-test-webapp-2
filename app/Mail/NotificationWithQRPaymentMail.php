<?php

declare(strict_types=1);

namespace CzechitasApp\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationWithQRPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string */
    private $mdView;

    /** @var string */
    public $subject;

    /** @var mixed[] */
    private $mdData;

    /** @var bool */
    private $showQRPayment;

    /**
     * Create a new message instance.
     *
     * @param mixed[] $mdData
     */
    public function __construct(string $mdView, string $subject, array $mdData, bool $showQRPayment = false)
    {
        $this->mdView = $mdView;
        $this->subject = $subject;
        $this->mdData = $mdData;
        $this->showQRPayment = $showQRPayment;
    }

    public function shouldAddQRPayment(): bool
    {
        return $this->showQRPayment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->mdData['showQRPayment'] = $this->showQRPayment;

        return $this
            ->subject($this->subject)
            ->markdown($this->mdView, $this->mdData);
    }
}
