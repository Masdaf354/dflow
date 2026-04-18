<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('change_deployments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('change_request_id')->constrained()->onDelete('cascade');
            $table->enum('environment', ['dev', 'uat', 'staging', 'production'])->default('dev');
            $table->enum('status', ['pending', 'deploying', 'deployed', 'failed', 'rolled_back'])->default('pending');
            $table->foreignId('deployed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('deployed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('change_deployments');
    }
};
