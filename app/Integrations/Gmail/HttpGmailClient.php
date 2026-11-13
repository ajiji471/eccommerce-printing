<?php

declare(strict_types=1);

namespace App\Integrations\Gmail;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class HttpGmailClient implements GmailClient
{
    public function send(string $to, string $subject, string $html, ?string $fromName = null): void
    {
        $response = Http::withToken($this->accessToken())
            ->timeout((int) config('gmail.timeout', 15))
            ->acceptJson()
            ->post(config('gmail.api_url').'/users/me/messages/send', [
                'raw' => $this->encodeMessage($to, $subject, $html, $fromName),
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Gmail API menolak pengiriman: '.$response->body());
        }
    }

    private function accessToken(): string
    {
        $token = Cache::get('gmail:access-token');

        if (is_string($token) && $token !== '') {
            return $token;
        }

        $response = Http::asForm()
            ->timeout((int) config('gmail.timeout', 15))
            ->post((string) config('gmail.token_url'), [
                'client_id' => config('gmail.client_id'),
                'client_secret' => config('gmail.client_secret'),
                'refresh_token' => config('gmail.refresh_token'),
                'grant_type' => 'refresh_token',
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Gagal memperoleh token Gmail: '.$response->body());
        }

        $token = (string) $response->json('access_token');
        $expiresIn = (int) $response->json('expires_in', 3600);

        Cache::put('gmail:access-token', $token, max(60, $expiresIn - 60));

        return $token;
    }

    private function encodeMessage(string $to, string $subject, string $html, ?string $fromName): string
    {
        $fromEmail = (string) config('gmail.sender_email');
        $from = $fromName === null
            ? $fromEmail
            : sprintf('%s <%s>', $this->encodeHeader($fromName), $fromEmail);

        $message = implode("\r\n", [
            'From: '.$from,
            'To: '.$to,
            'Subject: '.$this->encodeHeader($subject),
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: base64',
            '',
            chunk_split(base64_encode($html), 76, "\r\n"),
        ]);

        return rtrim(strtr(base64_encode($message), '+/', '-_'), '=');
    }

    private function encodeHeader(string $value): string
    {
        return '=?UTF-8?B?'.base64_encode($value).'?=';
    }
}
