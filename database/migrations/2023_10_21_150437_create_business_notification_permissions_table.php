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
        Schema::create('business_notification_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id');
            $table->boolean('is_sms')->default(1);
            $table->boolean('is_email')->default(1);
            $table->boolean('is_phone')->default(1);
            $table->boolean('is_notification')->default(1);
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
        Schema::dropIfExists('business_notification_permissions');
    }
};
