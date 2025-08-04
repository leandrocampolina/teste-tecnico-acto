<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');
        }

        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->cascadeOnDelete();
            $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->text('text');
            $table->enum('type', ['multiple_choice', 'text'])->default('multiple_choice');
            $table->boolean('is_required')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('alternatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();

            if (DB::getDriverName() === 'pgsql') {
                $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
            } else {
                $table->uuid('uuid')->unique()->default(DB::raw('(UUID())'));
            }

            $table->text('text');
            $table->boolean('is_correct')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('form_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->json('snapshot');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_responses');
        Schema::dropIfExists('alternatives');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('forms');
    }
};
