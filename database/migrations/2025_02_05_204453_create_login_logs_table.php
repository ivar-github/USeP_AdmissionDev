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
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('userID')->nullable();
            $table->string('userEmail', 100);
            $table->string('description', 100);
            $table->boolean('status')->default(1);
            $table->string('hostName', 100)->nullable();
            $table->string('localIP', 100)->nullable();
            $table->string('location', 200)->nullable();
            $table->string('platform', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};
