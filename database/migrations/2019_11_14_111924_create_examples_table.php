<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('example_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('examples', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('example_category_id');
            $table->string('name', 100);
            $table->string('email');
            $table->string('password');
            $table->text('image')->nullable();;
            $table->date('example_date');
            $table->longText('description');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('example_category_id')->references('id')->on('example_categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examples');
        Schema::dropIfExists('example_categories');
    }
}
