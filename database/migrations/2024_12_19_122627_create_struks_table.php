<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStruksTable extends Migration
{
    public function up()
    {
        Schema::create('struks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('booking')->onDelete('cascade');
            $table->enum('payment_status', ['paid', 'unpaid', 'cek'])->default('unpaid');
            $table->decimal('total_amount', 12, 2);
            $table->string('description')->nullable();
            $table->boolean('is_garansi')->default(false);
            $table->date('garansi_date')->nullable();
            $table->string('garansi_desc')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('order_id')->nullable();
            $table->timestamps();
        });

        Schema::create('struk_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('struk_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('price', 12, 2); // This will store the total price (quantity * unit_price)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('struk_items');
        Schema::dropIfExists('struks');
    }
}