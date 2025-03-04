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
        Schema::create('action_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->string('module', 100);
            $table->string('affectedID')->nullable();
            $table->string('affectedItem', 100)->nullable();
            $table->string('description', 500);
            $table->boolean('status')->nullable();
            $table->integer('userID');
            $table->string('userEmail', 100);
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
        Schema::dropIfExists('action_logs');
    }
};
