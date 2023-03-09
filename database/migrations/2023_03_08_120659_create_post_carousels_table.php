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
        Schema::create('post_carousels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->index();
            $table->boolean('is_ad');
            $table->string('see_more');
            $table->string('img')->nullable();
            $table->string('video')->nullable();
            $table->string('pub_num')->nullable();
            $table->string('slot_num')->nullable();
            $table->text('ad_script')->nullable();
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_carousels');
    }
};
