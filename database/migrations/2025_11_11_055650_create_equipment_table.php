<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // dueño del equipo

            $table->string('name');
            $table->string('sku')->nullable()->unique();
            $table->text('description')->nullable();

            $table->decimal('price_per_day', 10, 2)->default(0);

            $table->enum('status', [
                'available',
                'rented',
                'maintenance',
                'inactive'
            ])->default('available');

            $table->string('location')->nullable();
            $table->integer('stock')->default(1);

            $table->string('image')->nullable(); // ruta de imagen
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // RELACIÓN CON USERS
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipments');
    }
};
