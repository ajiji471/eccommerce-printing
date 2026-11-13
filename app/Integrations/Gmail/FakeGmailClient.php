<?php

declare(strict_types=1);

namespace App\Integrations\Gmail;

final class FakeGmailClient implements GmailClient
{
    /**
     * @var array<int, array{to: string, subject: string, html: string, from_name: string|null}>
     */
    private array $sent = [];

    public function send(string $to, string $subject, string $html, ?string $fromName = null): void
    {
        $this->sent[] = [
            'to' => $to,
            'subject' => $subject,
            'html' => $html,
            'from_name' => $fromName,
        ];
    }

    /**
     * @return array<int, array{to: string, subject: string, html: string, from_name: string|null}>
     */
    public function sent(): array
    {
        return $this->sent;
    }

    public function flush(): void
    {
        $this->sent = [];
    }
}
