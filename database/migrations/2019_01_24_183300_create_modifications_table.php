<?php

use function GuzzleHttp\default_user_agent;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index();
            $table->string('photo');
            $table->text('description');
            $table->tinyInteger('condition')->default('0'); // 0 - б/в; 1 - нова
            $table->decimal('price', 10, 2)->unsigned();
            $table->tinyInteger('is_sold')->default('0'); // 0 - в наявності; 1 - продано
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modifications');
    }
}
