<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');       // quien renta
            $table->unsignedBigInteger('equipment_id');
            $table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade');
            $table->string('customer_name')->nullable();
            $table->string('customer_contact')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('price_total', 12, 2)->nullable();
            $table->decimal('price_per_day', 10, 2)->nullable();
            $table->enum('status', ['booked','active','completed','cancelled'])->default('booked');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rentals');
    }
};