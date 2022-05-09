<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string("name", 50);
            $table->string("display_type", 70)->nullable();
            $table->text("description")->nullable();
            $table->boolean("status")->default(0);
            $table->unsignedBigInteger("created_by")->nullable();
            $table->foreign("created_by")->on("users")->references("id")->onDelete("cascade");
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->foreign("updated_by")->on("users")->references("id")->onDelete("cascade");
            $table->timestamps();
        });

        DB::statement("INSERT INTO `attributes` (`id`, `name`, `display_type`, `description`, `status`, `created_at`, `updated_at`) VALUES
        (1, 'Color', 'radio_button', 'this is for color atrribute.', 1, '2018-11-05 02:12:26', '2018-11-05 02:12:26')");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
