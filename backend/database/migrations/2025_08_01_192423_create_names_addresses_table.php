<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNamesAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('names_addresses', function (Blueprint $table) {
            $table->id();

            $table->string('name_ar');      // الاسم بالعربي
            $table->string('name_en');      // الاسم بالانجليزي
            $table->date('birth_date');     // تاريخ الميلاد

            $table->string('governorate_ar');  // المحافظة بالعربي
            $table->string('governorate_en');  // المحافظة بالانجليزي

            $table->string('city_ar');          // المدينة بالعربي
            $table->string('city_en');          // المدينة بالانجليزي

            $table->string('area_ar');          // المنطقة بالعربي
            $table->string('area_en');          // المنطقة بالانجليزي

            $table->string('national_id')->unique();  // رقم الهوية
            $table->string('phone', 10);              // رقم الهاتف (10 خانات)

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('names_addresses');
    }
}
