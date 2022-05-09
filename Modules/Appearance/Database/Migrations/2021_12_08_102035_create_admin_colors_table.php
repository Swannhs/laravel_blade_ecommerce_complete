<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Appearance\Entities\AdminColor;

class CreateAdminColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_colors', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('color_mode');
            $table->string('background_type')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_color')->nullable();
            $table->string('base_color')->nullable();
            $table->string('solid_color')->nullable();
            $table->string('gradient_color_one')->nullable();
            $table->string('gradient_color_two')->nullable();
            $table->string('gradient_color_three')->nullable();
            $table->string('scroll_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('text_white')->nullable();
            $table->string('background_white')->nullable();
            $table->string('text_black')->nullable();
            $table->string('background_black')->nullable();
            $table->string('input_background')->nullable();
            $table->string('border_color')->nullable();
            $table->string('success_color')->nullable();
            $table->string('warning_color')->nullable();
            $table->string('danger_color')->nullable();
            $table->string('toastr_position')->nullable();
            $table->float('toastr_time')->nullable();

            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        AdminColor::create([
            'title' => 'Default Color',
            'color_mode' => 'Gradient',
            'background_type' => 'image',
            'background_image' => 'backend/img/admin-body-bg.jpg',
            'background_color' => '',
            'base_color' => '#415094',
            'solid_color' => '',
            'gradient_color_one' => '#7C32FF',
            'gradient_color_two' => '#A235EC',
            'gradient_color_three' => '#C738D8',
            'scroll_color' => '#7E7172',
            'text_color' => '#828BB2',
            'text_white' => '#FFFFFF',
            'background_white' => '#FFFFFF',
            'text_black' => '#000000',
            'background_black' => '#000000',
            'input_background' => '#FFFFFF',
            'border_color' => '#FFFFFF',
            'success_color' => '#4BCF90',
            'warning_color' => '#E09079',
            'danger_color' => '#FF6D68',
            'toastr_position' => 'toast-top-right',
            'toastr_time' => '3000',
            'is_active' => true,
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_colors');
    }
}
