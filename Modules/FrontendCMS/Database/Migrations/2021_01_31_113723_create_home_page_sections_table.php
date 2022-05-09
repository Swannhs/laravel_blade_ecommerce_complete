<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\HomePageSection;

class CreateHomePageSectionsTable extends Migration
{

    public function up()
    {
        Schema::create('home_page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_name');
            $table->string('title');
            $table->unsignedInteger('section_for');
            $table->string('column_size');
            $table->unsignedInteger('type')->nullable();
            $table->boolean('status');
            $table->timestamps();
        });

        HomePageSection::create([
            'section_name' => 'best_deals',
            'title' => 'Best Deals',
            'section_for' => 1,
            'column_size' => 'col-lg-12',
            'type' => 4,
            'status' => 1

        ]);
        HomePageSection::create([
            'section_name' => 'top_brands',
            'title' => 'Top Brands',
            'section_for' => 3,
            'column_size' => 'col-lg-6',
            'type' => 2,
            'status' => 1

        ]);
        HomePageSection::create([
            'section_name' => 'top_picks',
            'title' => 'Top Picks',
            'section_for' => 1,
            'column_size' => 'col-lg-6',
            'type' => 4,
            'status' => 1

        ]);
        HomePageSection::create([
            'section_name' => 'feature_categories',
            'title' => 'Feature Categories',
            'section_for' => 2,
            'column_size' => 'col-lg-12',
            'type' => 2,
            'status' => 1

        ]);
        HomePageSection::create([
            'section_name' => 'more_products',
            'title' => 'MORE PRODUCTS THAT YOU MAY LOVE',
            'section_for' => 1,
            'column_size' => 'col-lg-12',
            'type' => 3,
            'status' => 1

        ]);

        HomePageSection::create([
            'section_name' => 'top_bar',
            'title' => 'Top Bar',
            'section_for' => 1,
            'column_size' => 'col-lg-12',
            'type' => 3,
            'status' => 1

        ]);
    }




    public function down()
    {
        Schema::dropIfExists('home_page_sections');
    }
}
