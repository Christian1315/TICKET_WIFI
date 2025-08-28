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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->foreignId('package_id')
                ->nullable()
                ->constrained('packages')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId('billing_id')
                ->nullable()
                ->constrained('billings')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
                
            $table->string('number')->unique();
            $table->string('subject');
            $table->longText('message');
            $table->longText('ticket_file')->nullable();
            $table->string('status');
            $table->string('priority');

            $table->boolean('downloaded')->default(false);
            $table->boolean('percent_paid')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
