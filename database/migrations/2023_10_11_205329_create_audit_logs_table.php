<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string(config('uuid.column'))->nullable()->unique()->index();
            $table->morphs('loggable');
            $table->mediumInteger('action_type')
                ->comment('Action Type: 1 => Create, 2 => Update, 3 => Soft Delete, 4 => Restore, 5 => Delete');
            $table->foreignId('actioned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->jsonb('difference')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
