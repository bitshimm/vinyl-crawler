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
            $table->id();
            $table->string('website')->nullable()->default('');
            $table->string('product_url')->nullable()->default('');
            $table->bigInteger('tilda_uid')->unsigned()->default(0);
            $table->string('code')->nullable()->default('');
            $table->string('brand')->nullable()->default('');
            $table->text('description')->nullable();
            $table->string('category')->nullable()->default('');
            $table->string('title')->nullable()->default('');
            $table->text('text')->nullable();
            $table->text('photo')->nullable();
            $table->string('seo_title')->nullable()->default('');
            $table->string('seo_descr')->nullable()->default('');
            $table->string('seo_keywords')->nullable()->default('');
            $table->float('price')->default(0);
            $table->string('video')->nullable()->default('');
            $table->text('text_product_card')->nullable();
            $table->text('track_list')->nullable();
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
