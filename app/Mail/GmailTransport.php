<?php

declare(strict_types=1);

namespace App\Mail;

use App\Domain\Tenancy\TenantContext;
use App\Jobs\SendEmailJob;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

final class GmailTransport implements TransportInterface
{
    private static bool $nextCritical = false;

    public static function markNextAsCritical(): void
    {
        self::$nextCritical = true;
    }

    public function send(RawMessage $message, ?Envelope $envelope = null): ?SentMessage
    {
        if (! $message instanceof Email) {
            return null;
        }

        $queue = $message->getHeaders()->get('X-Email-Queue')?->getBodyAsString();

        if ($queue === null && self::$nextCritical) {
            $queue = 'emails-critical';
        }

        self::$nextCritical = false;

        $recipient = $message->getTo()[0] ?? null;

        if ($recipient === null) {
            return null;
        }

        SendEmailJob::dispatch(
            to: $recipient->getAddress(),
            subject: $message->getSubject() ?? '',
            html: $message->getHtmlBody() ?? $message->getTextBody() ?? '',
            fromName: $message->getFrom()[0]?->getName() ?: null,
            tenantId: app(TenantContext::class)->idOrNull(),
        )->onQueue($queue ?? 'emails');

        return new SentMessage($message, $envelope ?? Envelope::create($message));
    }

    public function __toString(): string
    {
        return 'gmail';
    }
}
