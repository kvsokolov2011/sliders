<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string("title")->comment("Название");
            $table->string("short")->nullable()->comment("Заголовок");
            $table->string("slug")->unique()->comment("Slug");
            $table->string("url")->nullable()->comment("Ссылка со слайда");
            $table->unsignedBigInteger("image_id")->nullable()->comment("Изображение");
            $table->unsignedBigInteger("slider_id")->nullable()->comment("Id слайдера");
            $table->unsignedBigInteger("priority")->default(1)->comment("Приоритет");
            $table->text("description")->nullable()->comment("Описание");
            $table->date("published_at")->nullable()->comment("Дата публикации");
            $table->date("unpublished_at")->nullable()->comment("Дата снятия с публикации");
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
        Schema::dropIfExists('slides');
    }
}
