<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\SupportTicket\Entities\TicketStatus;    
class CreateTicketStatusesTable extends Migration
{
    
    public function up()
    {
        Schema::create('ticket_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('isActive')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        TicketStatus::create([ 'name' => 'Pending']);
        TicketStatus::create([ 'name' => 'On Going']);
        TicketStatus::create([ 'name' => 'Completed']);
        TicketStatus::create([ 'name' => 'Closed']);
    }

    
    public function down()
    {
        Schema::dropIfExists('ticket_statuses');
    }
}
