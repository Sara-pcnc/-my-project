<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrenTable extends Migration
{
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id');  // مفتاح أجنبي مرتبط بجدول الاسماء والعناوين
            $table->string('name_ar');                 // اسم الطفل بالعربي
            $table->string('name_en');                 // اسم الطفل بالانجليزي
            $table->date('birth_date');                // تاريخ ميلاد الطفل

            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('names_addresses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('children');
    }
}
