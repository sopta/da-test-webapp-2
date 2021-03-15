<?php

declare(strict_types=1);

namespace CzechitasApp\Notifications\Student;

use CzechitasApp\Mail\NotificationWithQRPaymentMail;
use CzechitasApp\Models\Student;
use CzechitasApp\Notifications\BaseQueueableNotification;
use CzechitasApp\Services\Models\StudentService;
use Swift_Image;

abstract class StudentBaseNotification extends BaseQueueableNotification
{
    /** @var Student */
    protected $student;

    /** @var StudentService */
    protected $studentService;

    /** @var bool */
    protected $addQRPayment = false;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Get view path of template to render as email
     */
    abstract protected function getTemplateView(): string;

    /**
     * Get view path of template to render as email
     */
    abstract protected function getSubject(): string;

    /**
     * Show QR Payment and add to attachment
     */
    protected function shouldAddQRPayment(): bool
    {
        return $this->addQRPayment && $this->studentService->setContext($this->student)->showQRPayment();
    }

    /**
     * Get data to mail
     *
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        return [
            'student' => $this->student,
        ];
    }

    /**
     * Init notification mail object
     */
    protected function initNotificationMail(): NotificationWithQRPaymentMail
    {
        // Services
        $this->studentService = \resolve(StudentService::class)->setContext($this->student);

        return new NotificationWithQRPaymentMail(
            $this->getTemplateView(),
            \mailSubject($this->getSubject()),
            $this->getData(),
            $this->shouldAddQRPayment()
        );
    }

    /**
     * Get variables passed to X-Mailgun-Variables header
     *
     * @return array<string, mixed>
     */
    protected function getMailgunVariables(): array
    {
        return [
            'studentId' => $this->student->id,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): NotificationWithQRPaymentMail
    {
        $notificationMail = $this->initNotificationMail();
        $message = $notificationMail->to($this->student->routeNotificationForMail());

        if ($notificationMail->shouldAddQRPayment()) {
            $qrCode = $this->studentService->getQRPayment();

            $message->withSwiftMessage(static function ($message) use ($qrCode): void {
                $image = new Swift_Image($qrCode->toPngText(), 'QR Platba.png', 'image/png');
                $image->setId('qrpayment@czechitasapp.generated');
                $message->embed($image);
            });
        }

        // Add Mailgun header about student
        $message->withSwiftMessage(function ($message): void {
            $message->getHeaders()->addTextHeader('X-Mailgun-Variables', \json_encode($this->getMailgunVariables()));
        });

        return $message;
    }
}
