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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->references('id')->on('users');
            $table->string('title');
            $table->string('description')->nullable();
            $table->boolean('done')->default(0);
            $table->boolean('isActive')->default(1);
            $table->string('remark')->nullable()->default(Null);
            $table->dateTime('dateMade', 6)->useCurrent();
            $table->dateTime('dateUpdated', 6)->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
