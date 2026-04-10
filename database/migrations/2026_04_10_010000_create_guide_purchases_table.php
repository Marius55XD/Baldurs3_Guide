<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guide_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guide_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 8, 2);
            $table->timestamp('paid_at');
            $table->timestamps();

            $table->unique(['user_id', 'guide_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guide_purchases');
    }
};
