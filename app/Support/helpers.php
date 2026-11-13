<?php

declare(strict_types=1);

use App\Support\AuditLogger;
use Illuminate\Database\Eloquent\Model;

if (! function_exists('audit')) {
    /**
     * @param  array<string, mixed>  $metadata
     */
    function audit(string $action, ?Model $target = null, array $metadata = []): void
    {
        app(AuditLogger::class)->log($action, $target, $metadata);
    }
}
