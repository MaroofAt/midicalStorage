<?php

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicine_order', function (Blueprint $table) {
            $table->id('id');
            $table->integar('quantity');
            $table->foreignId(Medicine::class , 'medicine_id');
            $table->foreignId(Order::class , 'order_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_order');
    }
};
