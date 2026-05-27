<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            // ^ links to users table

            $table->string('title');
            // e.g. "Daily SMS count compared to SMS logs"

            $table->text('description')->nullable();
            // optional longer description

            $table->enum('status', ['pending', 'done'])
                  ->default('pending');
            // only allows 'pending' or 'done'

            $table->date('activity_date');
            // the date this activity belongs to

            $table->timestamps();
            // creates created_at and updated_at automatically
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};