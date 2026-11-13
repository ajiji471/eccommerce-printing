<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Integrations\Gmail\GmailService;
use App\Models\FailedEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    /**
     * @var array<int, int>
     */
    public array $backoff = [60, 300, 900];

    public function __construct(
        public string $to,
        public string $subject,
        public string $html,
        public ?string $fromName = null,
        public ?int $tenantId = null,
    ) {}

    public function handle(GmailService $gmail): void
    {
        $gmail->send($this->to, $this->subject, $this->html, $this->fromName);
    }

    public function failed(Throwable $exception): void
    {
        FailedEmail::query()->create([
            'tenant_id' => $this->tenantId,
            'to' => $this->to,
            'subject' => $this->subject,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts(),
            'failed_at' => now(),
        ]);

        Log::channel('integration')->error('Email gagal dikirim setelah percobaan ulang', [
            'to' => $this->to,
            'subject' => $this->subject,
            'tenant_id' => $this->tenantId,
            'error' => $exception->getMessage(),
        ]);
    }
}
