<?php

use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id('id');
            $table->string('scientific_name');
            $table->string('commercial_name');
            $table->double('price');
            $table->integer('quantity');
            $table->text('info');
            $table->date('expiry_date');
            $table->foreignIdFor(Company::class , 'company_id');
            $table->foreignIdFor(Category::class,'category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
