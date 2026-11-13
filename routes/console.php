<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('cache:prune-stale-tags')->hourly()->withoutOverlapping();

Schedule::command('queue:prune-failed --hours=168')->daily()->withoutOverlapping();

Schedule::command('queue:prune-batches --hours=48')->daily()->withoutOverlapping();
