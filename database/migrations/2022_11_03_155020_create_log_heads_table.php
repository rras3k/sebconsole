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
            $table->boolean('enable')->default(true);
            $table->string('texte');
            $table->string('action');
            $table->string('routeName');
            $table->string('uri');
            $table->bigInteger('table1_id')->nullable();
            $table->foreignId('user_id');
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
