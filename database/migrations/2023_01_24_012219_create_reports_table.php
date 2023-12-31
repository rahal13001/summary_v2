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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id', false);
            $table->string('no_st')->nullable();
            $table->text('what');
            $table->text('where');
            $table->text('why');
            $table->string('penyelenggara');
            $table->text('who');
            $table->integer('total_peserta', false);
            $table->integer('gender_wanita', false);
            $table->text('how');
            $table->softDeletes();
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
        Schema::dropIfExists('reports');
    }
};
