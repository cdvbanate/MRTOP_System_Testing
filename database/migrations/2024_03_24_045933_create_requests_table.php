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
        Schema::create('requests', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('qualification_id')->constrained()->cascadeOnDelete();
            $table->string('region_name');
            $table->string('province_name');
            $table->string('institution_name');
            $table->boolean('withExistingTOPcourse');
            $table->date('targetStart');
            $table->date('targetEnd');
            $table->string('NameOfTrainer');
            $table->string('NTTCNumber');
            $table->string('contactNumber');
            $table->string('emailAddress');
            $table->string('Attachment');
            $table->string('RequestStatus')->default('For Verification');
            $table->string('TrainingStatus')->default('Not Yet Started');
            $table->string('Remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
