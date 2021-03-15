<?php

declare(strict_types=1);

namespace CzechitasApp\Notifications\Student;

class StudentUpdatedNotification extends StudentBaseNotification
{
    /** @var bool */
    protected $addQRPayment = true;

    /**
     * Get view path of template to render as email
     */
    protected function getTemplateView(): string
    {
        return 'mail.student.updated';
    }

    /**
     * Get view path of template to render as email
     */
    protected function getSubject(): string
    {
        return \trans('students.updated_mail_subject');
    }
}
