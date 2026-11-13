<?php

declare(strict_types=1);

namespace App\Integrations\Gmail;

final class GmailService
{
    public function __construct(
        private readonly GmailClient $client,
        private readonly GmailQuota $quota,
    ) {}

    public function send(string $to, string $subject, string $html, ?string $fromName = null): void
    {
        $this->quota->consume();

        $this->client->send($to, $subject, $html, $fromName);
    }
}
