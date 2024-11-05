<?php

use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status' , ['preparing' , 'sent' , 'arrived'])->default('preparing');
            $table->boolean('paid')->default(false);
            $table->foreignIdFor(User::class,'user_id');
            $table->foreignIdFor(Medicine::class,'medicine_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};