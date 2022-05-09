<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FooterSetting\Entities\FooterWidget;
use Modules\GeneralSetting\Entities\GeneralSetting;

class CreateFooterWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_widgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('category');
            $table->string('page');
            $table->string('section');
            $table->boolean('is_static')->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        $generalSetting = GeneralSetting::first();
        $generalSetting->copyright_text = 'Copyright © 2019. All rights reserved';
        $generalSetting->footer_copy_right = 'Copyright © 2019. All rights reserved.';
        $generalSetting->footer_about_description = 'We are an industry-leading company that values honesty, integrity, and efficiency. Building quality products and caring for the users are what made us stand out since the beginning. We are stunning, functional, ready to go, and well documented.';
        $generalSetting->save();

        FooterWidget::create(['name' => 'About Us', 'slug' => 'about-us', 'category' => 1, 'page' => 1, 'section' => 1, 'status' => 1]);
        FooterWidget::create(['name' => 'Blog', 'slug' => 'blog', 'category' => 1, 'page' => 3, 'section' => 1, 'status' => 1]);

        FooterWidget::create(['name' => 'Dashboard', 'slug' => 'profile/dashboard', 'category' => 2, 'page' => 17, 'section' => 2, 'status' => 1]);
        FooterWidget::create(['name' => 'My Profile', 'slug' => 'profile', 'category' => 2, 'page' => 5, 'section' => 2, 'status' => 1]);
        FooterWidget::create(['name' => 'My Order', 'slug' => 'my-purchase-orders', 'category' => 2, 'page' => 6, 'section' => 2, 'status' => 1]);

        FooterWidget::create(['name' => 'Help & Contact', 'slug' => 'contact-us', 'category' => 3, 'page' => 13, 'section' => 3, 'status' => 1]);
        FooterWidget::create(['name' => 'Track Order', 'slug' => 'track-order', 'category' => 3, 'page' => 14, 'section' => 3, 'status' => 1]);
        FooterWidget::create(['name' => 'Return & Exchange', 'slug' => 'return-exchange', 'category' => 3, 'page' => 21, 'section' => 3, 'status' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('footer_widgets');
    }
}
