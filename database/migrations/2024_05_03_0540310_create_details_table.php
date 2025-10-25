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
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            // $table->string('router_name');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('pin')->nullable();
            // $table->string('router_password');
            // $table->string('package_name');
            // $table->unsignedInteger('package_price');
            // $table->date('package_start');
            $table->decimal('due',20,2)->nullable();
            $table->string('status')->default('active');
            $table->text('kkiapay_key')->nullable();
            $table->text('stripe_key')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details');
    }
};
