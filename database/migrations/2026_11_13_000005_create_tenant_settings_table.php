<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->unique()->constrained()->cascadeOnDelete();
            $table->json('bank_accounts')->nullable();
            $table->json('origin')->nullable();
            $table->json('active_couriers')->nullable();
            $table->json('flat_rates')->nullable();
            $table->decimal('ppn_percent', 5, 2)->default(11.00);
            $table->json('business_hours')->nullable();
            $table->text('midtrans_client_key')->nullable();
            $table->text('midtrans_server_key')->nullable();
            $table->text('midtrans_merchant_id')->nullable();
            $table->string('midtrans_mode', 20)->nullable();
            $table->text('rajaongkir_key')->nullable();
            $table->string('drive_folder_id')->nullable();
            $table->text('gmail_token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_settings');
    }
};
