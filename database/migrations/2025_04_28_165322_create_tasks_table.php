<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status')->default('pending');
            $table->json('input');
            $table->text('result')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tasks');
    }
};

