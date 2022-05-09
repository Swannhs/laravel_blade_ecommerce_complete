<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Setup\Entities\AnalyticsTool;

class CreateAnalyticsToolsTable extends Migration
{
    
    public function up()
    {
        Schema::create('analytics_tools', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('google_tracking_id')->nullable();
            $table->string('facebook_pixel_id')->nullable();
            $table->timestamps();
        });

        AnalyticsTool::create([
            'type' => 'google_analytics',
        ]);

        AnalyticsTool::create([
            'type' => 'facebook_pixel',
        ]);
    }

    
    public function down()
    {
        Schema::dropIfExists('analytics_tools');
    }
}
