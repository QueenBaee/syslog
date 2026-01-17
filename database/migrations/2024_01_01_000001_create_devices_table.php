<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['metro', 'genset', 'nap', 'exchange', 'active_device']);
            $table->string('name');
            $table->string('location');
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->enum('current_status', ['online', 'offline'])->default('online');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
