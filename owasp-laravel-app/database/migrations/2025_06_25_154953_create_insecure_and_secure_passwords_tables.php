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
        Schema::create('insecure_passwords', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password'); // plaintext
            $table->timestamps();
        });

        Schema::create('secure_passwords', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password'); // hashed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insecure_and_secure_passwords_tables');
    }
};
