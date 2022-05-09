<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("product_name")->nullable();
            $table->unsignedBigInteger("product_type")->nullable()->comment('1 => single_product, 2 => variant_product');
            $table->unsignedBigInteger("unit_type_id")->nullable();
            $table->unsignedBigInteger("brand_id")->nullable();
            $table->string("thumbnail_image_source", 255)->nullable();
            $table->string("barcode_type", 255)->nullable();
            $table->string("model_number", 255)->nullable();
            $table->Integer("shipping_type")->default(0)->comment('1 => free_shipping, 2 => flat_rate');
            $table->double("shipping_cost", 16,2)->default(0);
            $table->string("discount_type", 50)->nullable();
            $table->double("discount", 16,2)->default(0);
            $table->string("tax_type", 50)->nullable();
            $table->double("tax", 16,2)->default(0);
            $table->string("pdf", 255)->nullable();
            $table->string("video_provider", 255)->nullable();
            $table->string("video_link", 255)->nullable();
            $table->longText("description")->nullable();
            $table->longText('specification')->nullable();
            $table->Integer("minimum_order_qty")->nullable();
            $table->Integer("max_order_qty")->nullable();
            $table->string("meta_title", 255)->nullable();
            $table->longText("meta_description")->nullable();
            $table->string("meta_image", 255)->nullable();
            $table->boolean('is_physical')->default(0);
            $table->boolean('is_approved')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->tinyInteger('display_in_details')->default(0);
            $table->unsignedInteger('requested_by')->nullable();
            $table->unsignedBigInteger("created_by")->nullable();
            $table->string("slug", 255)->nullable();
            $table->foreign("created_by")->on("users")->references("id")->onDelete("cascade");
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->foreign("updated_by")->on("users")->references("id")->onDelete("cascade");
            $table->string('stock_manage')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     *\ @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
