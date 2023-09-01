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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('level_id ');
            $table->unsignedBigInteger('age_group_id');
            $table->text('title');
            $table->text('description');
            $table->text('media_path_1')->nullable();
            $table->text('media_path_2')->nullable();
            $table->text('media_path_3')->nullable();
            $table->text('media_path_4')->nullable();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
