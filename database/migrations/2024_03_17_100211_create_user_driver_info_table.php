<?php

use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverStatus;
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
        Schema::create('user_driver_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('avatar')->nullable();
            $table->char('id_card', 50)->unique();
            $table->string('id_card_front')->nullable();
            $table->string('id_card_back')->nullable();
            $table->char('license_plate')->nullable();
            $table->string('vehicle_company')->nullable();
            $table->string('vehicle_registration_front')->nullable();
            $table->string('vehicle_registration_back')->nullable();
            $table->string('driver_license_front')->nullable();
            $table->string('driver_license_back')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->char('bank_account_number')->nullable();
            $table->tinyInteger('auto_accept')->default(AutoAccept::Auto->value);
            $table->double('current_lat')->nullable();
            $table->double('current_lng')->nullable();
            $table->string('current_address')->nullable();
            $table->tinyInteger('order_accepted')->default(DriverStatus::NotReceived->value);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_driver_info');
    }
};
