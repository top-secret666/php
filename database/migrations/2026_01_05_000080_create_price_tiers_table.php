<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('price_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_id')->nullable()->constrained('shows')->nullOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('seat_sections')->nullOnDelete();
            $table->string('name')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('RUB');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_tiers');
    }
};
