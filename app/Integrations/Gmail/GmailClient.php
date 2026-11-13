<?php

declare(strict_types=1);

namespace App\Integrations\Gmail;

interface GmailClient
{
    public function send(string $to, string $subject, string $html, ?string $fromName = null): void;
}
