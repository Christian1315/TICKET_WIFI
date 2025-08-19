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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->string('payment_method');
            $table->unsignedInteger('package_price');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->foreignId('billing_id')
                ->nullable()
                ->constrained('billings')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
