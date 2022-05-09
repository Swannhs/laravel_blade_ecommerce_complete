<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Menu\Entities\Menu;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('icon')->nullable();
            $table->string('menu_type');
            $table->string('menu_position');
            $table->boolean('status')->default(0);
            $table->unsignedInteger('has_parent')->nullable();
            $table->unsignedInteger('order_by')->default(865435);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Menu::create([
            'name' => 'Top Navbar left menu',
            'slug' => 'top-navbar-left-menu',
            'menu_type' => 'normal_menu',
            'menu_position' => 'top_navbar',
            'status' => 1,
            'has_parent' => null,
            'order_by' => 1
        ]);

        Menu::create([
            'name' => 'Top Navbar right menu',
            'slug' => 'top-navbar-right-menu',
            'menu_type' => 'normal_menu',
            'menu_position' => 'top_navbar',
            'status' => 1,
            'has_parent' => null,
            'order_by' => 2
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
