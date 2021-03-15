<?php

declare(strict_types=1);

namespace CzechitasApp\Notifications\Student;

class StudentLoggedOutNotification extends StudentBaseNotification
{
    /**
     * Get view path of template to render as email
     */
    protected function getTemplateView(): string
    {
        return 'mail.student.logged_out';
    }

    /**
     * Get view path of template to render as email
     */
    protected function getSubject(): string
    {
        return \trans('students.logout.subject');
    }
}
