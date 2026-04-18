<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('change_requests', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description');
            $table->text('reason');
            $table->enum('change_type', ['feature', 'bugfix', 'hotfix', 'enhancement', 'refactor', 'security'])->default('feature');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->text('impact')->nullable();
            $table->enum('risk', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->text('rollback_plan')->nullable();
            $table->text('testing_plan')->nullable();
            $table->string('affected_module')->nullable();
            $table->date('target_release_date')->nullable();
            $table->enum('status', [
                'draft',
                'submitted',
                'approved',
                'rejected',
                'in_progress',
                'code_review',
                'merged',
                'deployed',
                'done',
                'cancelled'
            ])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('change_requests');
    }
};
