<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('performance_id')->constrained('performances')->cascadeOnDelete();
            $table->foreignId('seat_id')->nullable()->constrained('seats')->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->foreignId('purchaser_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('price', 10, 2);
            $table->string('status')->default('reserved');
            $table->string('qr_code')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamps();
            $table->unique(['performance_id','seat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
