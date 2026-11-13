<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('failed_emails', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->nullOnDelete();
            $table->string('to');
            $table->string('subject');
            $table->text('error');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('failed_at')->useCurrent();
            $table->timestamps();

            $table->index('failed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('failed_emails');
    }
};
