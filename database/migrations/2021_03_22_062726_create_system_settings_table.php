<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name')->nullable();
            $table->string('site_title')->nullable();
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('copyright_text')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('province_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('district_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('ward_id')->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('system_settings');
    }
}
