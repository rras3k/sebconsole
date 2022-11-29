<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_heads', function (Blueprint $table) {
            $table->id();
            $table->string('texte');
            $table->bigInteger('duree')->nullable();
            $table->integer('num_error')->nullable();
            $table->foreignId('log_type_id');
            $table->foreignId('user_id');
            $table->boolean('favori')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_heads');
    }
};
