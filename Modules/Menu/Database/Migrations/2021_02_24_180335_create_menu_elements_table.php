<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateMenuElementsTable extends Migration
{
    
    public function up()
    {
        Schema::create('menu_elements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('column_id')->nullable();
            $table->string('type');
            $table->unsignedBigInteger('element_id')->nullable();
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->boolean('show')->default(0);
            $table->boolean('is_newtab')->default(0);
            $table->timestamps();
        });

        $sql = [
            ['id'  => 1, 'menu_id' => 1, 'column_id' => null, 'type' => 'page', 'element_id' => 4, 'title' => 'Become A Merchant', 'link' => null, 'parent_id' => null, 'position' => 1],
            ['id'  => 2, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 14, 'title' => 'Track Orders', 'link' => null, 'parent_id' => null, 'position' => 1],
            ['id'  => 3, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 16, 'title' => 'Compare', 'link' => null, 'parent_id' => null, 'position' => 2],
            ['id'  => 4, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 8, 'title' => 'My Wish List', 'link' => null, 'parent_id' => null, 'position' => 3],
            ['id'  => 5, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 13, 'title' => 'Help & Contact Us', 'link' => null, 'parent_id' => null, 'position' => 4],
            ['id'  => 6, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 7, 'title' => 'My Cart', 'link' => null, 'parent_id' => null, 'position' => 5],
            ['id'  => 7, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 5, 'title' => 'My Account', 'link' => null, 'parent_id' => null, 'position' => 6],
            ['id'  => 8, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 17, 'title' => 'Dashboard', 'link' => null, 'parent_id' => 7, 'position' => 1],
            ['id'  => 9, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 6, 'title' => 'My Orders', 'link' => null, 'parent_id' => 7, 'position' => 2],
            ['id'  => 10, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 19, 'title' => 'My Giftcarts', 'link' => null, 'parent_id' => 7, 'position' => 3],
            ['id'  => 11, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 20, 'title' => 'My Digital Products', 'link' => null, 'parent_id' => 7, 'position' => 4],
            ['id'  => 12, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 8, 'title' => 'My Wish List', 'link' => null, 'parent_id' => 7, 'position' => 5],
            ['id'  => 13, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 9, 'title' => 'Refunds & Disputes', 'link' => null, 'parent_id' => 7, 'position' => 6],
            ['id'  => 14, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 10, 'title' => 'My Coupons', 'link' => null, 'parent_id' => 7, 'position' => 7],
            ['id'  => 15, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 5, 'title' => 'My Profile', 'link' => null, 'parent_id' => 7, 'position' => 8],
            ['id'  => 16, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 11, 'title' => 'My Wallet', 'link' => null, 'parent_id' => 7, 'position' => 9],
            ['id'  => 17, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 12, 'title' => 'Referral', 'link' => null, 'parent_id' => 7, 'position' => 10],
            ['id'  => 18, 'menu_id' => 2, 'column_id' => null, 'type' => 'page', 'element_id' => 15, 'title' => 'Support Tickets', 'link' => null, 'parent_id' => 7, 'position' => 11]
        ];

        DB::table('menu_elements')->insert($sql);

        $vendor = Storage::exists('.vendor')?Storage::get('.vendor'):'single';
        if(strtolower($vendor) == 'single'){
            DB::table('menu_elements')->where('id', 1)->delete();
        }
    }

    
    public function down()
    {
        Schema::dropIfExists('menu_elements');
    }
}
