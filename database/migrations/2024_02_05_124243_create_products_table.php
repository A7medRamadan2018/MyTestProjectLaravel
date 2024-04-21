<?php

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
        Schema::create('products', function (Blueprint $table) {
            // $table->id();
            // $table->string('name');
            // $table->string('slug')->unique();
            // $table->text('description');
            // $table->string('price');
            // $table->string('quantity');
            // $table->boolean('is_available')->default(true);
            // $table->enum('status', ['active', 'inactive'])->default('active');
            // $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->timestamps();
            // $table->id();
            // $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            // $table->string('name');
            // $table->string('slug')->unique();
            // $table->text('description')->nullable();
            // $table->float('price')->default(0);
            // $table->float('compare_price')->nullable();
            // $table->json('options')->nullable();
            // $table->float('rating')->default(0);
            // $table->boolean('featured')->default(false);
            // $table->enum('status', ['active', 'draft', 'archvied'])->default('active');
            // $table->timestamps();
            // $table->softDeletes();
            $table->id();
            $table->text('description');
            $table->string('price');
            $table->string('quantity')->default(1);
            $table->boolean('is_available')->default(true);
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
