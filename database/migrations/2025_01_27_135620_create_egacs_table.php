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
        Schema::create('egacs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('qualification_id')->constrained()->cascadeOnDelete();
            $table->string('region_name');
            $table->string('institution_name');
            $table->string('NameOfTrainer');
            $table->date('targetStart');
            $table->date('targetEnd');
            $table->string('Remarks')->nullable();
            $table->string('emailAddress');
            $table->integer('enrolled_female');
            $table->integer('enrolled_male');
            $table->integer('graduate_female');
            $table->integer('graduate_male');
            $table->integer('assessed_female');
            $table->integer('assessed_male');
            $table->integer('completers_female');
            $table->integer('completers_male');
            $table->string('TrainingStatus')->default('Not Yet Started');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egacs');
    }
};
