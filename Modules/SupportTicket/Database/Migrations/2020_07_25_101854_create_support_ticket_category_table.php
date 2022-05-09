<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SupportTicket\Entities\TicketCategory;
class CreateSupportTicketCategoryTable extends Migration
{
   
    public function up()
    {
        Schema::create('support_ticket_category', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        TicketCategory::create([ 'name' => 'Installation']);
        TicketCategory::create([ 'name' => 'Technical']);
        TicketCategory::create([ 'name' => 'Others']);
    }

    
    public function down()
    {
        Schema::dropIfExists('support_ticket_category');
    }
}
