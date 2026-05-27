<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activity_id')
                  ->constrained()
                  ->onDelete('cascade');
            // ^ which activity was updated

            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            // ^ who made the update

            $table->enum('old_status', ['pending', 'done'])
                  ->nullable();
            // what the status WAS before

            $table->enum('new_status', ['pending', 'done']);
            // what the status CHANGED TO

            $table->text('remark')->nullable();
            // comment/note about the update

            $table->timestamps();
            // exact time of every update — critical for audit trail!
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};