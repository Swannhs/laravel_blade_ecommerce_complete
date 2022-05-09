<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGstTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gst_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name',200)->nullable();
            $table->double('tax_percentage',8,2)->default(0);
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger("created_by")->nullable();
            $table->foreign("created_by")->on("users")->references("id")->onDelete("cascade");
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->foreign("updated_by")->on("users")->references("id")->onDelete("cascade");
            $table->timestamps();
        });

        DB::statement("INSERT INTO `gst_taxes` (`id`, `name`, `tax_percentage`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
        (1, 'CGST', 0.00, 1, NULL, NULL, '2021-05-05 05:34:36', '2021-05-05 05:34:36'),
        (2, 'SGST', 0.00, 1, NULL, NULL, '2021-05-05 05:42:18', '2021-05-05 05:46:12'),
        (3, 'IGST', 0.00, 1, NULL, NULL, '2021-05-05 05:42:40', '2021-05-05 05:46:00')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gst_taxes');
    }
}
