<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Appearance\Entities\ThemeColor;

class CreateThemeColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme_colors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('background_color')->nullable();
            $table->string('base_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('feature_color')->nullable();
            $table->string('footer_color')->nullable();
            $table->string('navbar_color')->nullable();
            $table->string('menu_color')->nullable();
            $table->string('border_color')->nullable();
            $table->string('success_color')->nullable();
            $table->string('warning_color')->nullable();
            $table->string('danger_color')->nullable();
            $table->float('status')->default(0);
            $table->timestamps();
        });

        ThemeColor::create([
            'name' => 'Default',
            'background_color' => '#f4f7f9',
            'base_color' => '#ff0027',
            'text_color' => '#222222',
            'feature_color' => '#fff',
            'footer_color' => '#fff',
            'navbar_color' => '#fff',
            'menu_color' => '#f4f7f9',
            'border_color' => '#e4e7e9',
            'success_color' => '#4BCF90',
            'warning_color' => '#E09079',
            'danger_color' => '#FF6D68',
            'toastr_position' => 'toast-top-right',
            'toastr_time' => '3000',
            'status' => 1
        ]);

        ThemeColor::create([
            'name' => 'Color Scheme One',
            'background_color' => '#f4f7f9',
            'base_color' => '#39b021',
            'text_color' => '#222222',
            'feature_color' => '#f4f7f9',
            'footer_color' => '#f4f7f9',
            'navbar_color' => '#f4f7f9',
            'menu_color' => '#f4f7f9',
            'border_color' => '#e4e7e9',
            'success_color' => '#4BCF90',
            'warning_color' => '#E09079',
            'danger_color' => '#FF6D68',
            'toastr_position' => 'toast-bottom-left',
            'toastr_time' => '3000',
            'status' => 0
        ]);
        ThemeColor::create([
            'name' => 'Color Scheme Two',
            'background_color' => '#f4f7f9',
            'base_color' => '#ff0007',
            'text_color' => '#222222',
            'feature_color' => '#f4f7f9',
            'footer_color' => '#f4f7f9',
            'navbar_color' => '#f4f7f9',
            'menu_color' => '#f4f7f9',
            'border_color' => '#e4e7e9',
            'success_color' => '#4BCF90',
            'warning_color' => '#E09079',
            'danger_color' => '#FF6D68',
            'toastr_position' => 'toast-bottom-left',
            'toastr_time' => '3000',
            'status' => 0
        ]);
        ThemeColor::create([
            'name' => 'Color Scheme Three',
            'background_color' => '#f4f7f9',
            'base_color' => '#89a021',
            'text_color' => '#222222',
            'feature_color' => '#f4f7f9',
            'footer_color' => '#f4f7f9',
            'navbar_color' => '#f4f7f9',
            'menu_color' => '#f4f7f9',
            'border_color' => '#e4e7e9',
            'success_color' => '#4BCF90',
            'warning_color' => '#E09079',
            'danger_color' => '#FF6D68',
            'toastr_position' => 'toast-bottom-left',
            'toastr_time' => '3000',
            'status' => 0
        ]);
        ThemeColor::create([
            'name' => 'Color Scheme Four',
            'background_color' => '#f4f7f9',
            'base_color' => '#d8eb34',
            'text_color' => '#222222',
            'feature_color' => '#f4f7f9',
            'footer_color' => '#f4f7f9',
            'navbar_color' => '#f4f7f9',
            'menu_color' => '#f4f7f9',
            'border_color' => '#e4e7e9',
            'success_color' => '#4BCF90',
            'warning_color' => '#E09079',
            'danger_color' => '#FF6D68',
            'toastr_position' => 'toast-bottom-left',
            'toastr_time' => '3000',
            'status' => 0
        ]);
        ThemeColor::create([
            'name' => 'Color Scheme Five',
            'background_color' => '#f4f7f9',
            'base_color' => '#d8eb34',
            'text_color' => '#222222',
            'feature_color' => '#f4f7f9',
            'footer_color' => '#f4f7f9',
            'navbar_color' => '#f4f7f9',
            'menu_color' => '#f4f7f9',
            'border_color' => '#e4e7e9',
            'success_color' => '#4BCF90',
            'warning_color' => '#E09079',
            'danger_color' => '#FF6D68',
            'toastr_position' => 'toast-bottom-left',
            'toastr_time' => '3000',
            'status' => 0
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('theme_colors');
    }
}
