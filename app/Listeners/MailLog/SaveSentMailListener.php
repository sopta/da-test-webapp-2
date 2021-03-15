<?php

declare(strict_types=1);

namespace CzechitasApp\Listeners\MailLog;

use CzechitasApp\Services\Models\SendEmailService;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Swift_Attachment;
use Swift_Image;
use Swift_Message;

class SaveSentMailListener
{
    /** @var SendEmailService */
    private $sendEmailService;

    public function __construct(SendEmailService $sendEmailService)
    {
        $this->sendEmailService = $sendEmailService;
    }

    public function handle(MessageSent $event): void
    {
        if (empty($event->data['student'])) {
            return;
        }

        try {
            $data = [
                'student'       => $event->data['student'],
                'from'          => $this->formatAddresses($event->message->getFrom()),
                'to'            => $this->formatAddresses($event->message->getTo()),
                'subject'       => $event->message->getSubject(),
                'body'          => $this->getBodyWithEmbededImage($event->message),
                'attachments'   => $this->formatAttachments($event->message->getChildren()),
            ];

            $this->sendEmailService->insert($data);
        } catch (\Throwable $e) {
            Log::warning($e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * @param mixed $addresses
     */
    protected function formatAddresses($addresses): ?string
    {
        $formated = [];
        foreach ($addresses as $mail => $name) {
            $formated[] = empty($name)
                ? $mail
                : $name . ' <' . $mail . '>';
        }

        return empty($formated) ? null : \implode(', ', $formated);
    }

    /**
     * @param  mixed $children
     * @return array<string>
     */
    protected function formatAttachments($children): ?array
    {
        $attachments = [];
        foreach ($children as $child) {
            if ($child instanceof Swift_Attachment) {
                $attachments[] = $child->getFilename();
            }
        }

        return empty($attachments) ? null : $attachments;
    }

    public function getBodyWithEmbededImage(Swift_Message $message): string
    {
        $body = $message->getBody();
        if (Str::contains($body, '</body>')) {
            $script = "document.querySelectorAll('img[src^=cid]').forEach(
                function(el){
                    var key = el.src.replace(/^cid:/, '');
                    if( cids[key] ){ el.src = cids[key]; }
                }
            )";

            $cids = [];
            foreach ($message->getChildren() as $child) {
                if ($child instanceof Swift_Image) {
                    $cids[$child->getId()] = \sprintf(
                        'data:%s;base64,%s',
                        $child->getContentType(),
                        \base64_encode($child->getBody())
                    );
                }
            }
            $body = Str::replaceFirst(
                '</body>',
                \sprintf('<script>var cids = %s; %s</script></body>', \json_encode($cids), $script),
                $body
            );
        }

        return $body;
    }
}
