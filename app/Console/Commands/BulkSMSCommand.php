<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Traits\SendSMS;
use Illuminate\Console\Command;
use Modules\Marketing\Entities\BulkSMS;

class BulkSMSCommand extends Command
{
    use SendSMS;
    
    protected $signature = 'command:bulk_sms';

    
    protected $description = 'For send bulk SMS';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
        $messages = BulkSMS::where('is_send',0)->get();

        foreach($messages as $key => $message){
            if($message->publish_date == date("Y-m-d")){
                foreach(json_decode($message->send_user_ids) as $key => $id){
                    $user = User::findOrFail($id);
                    $this->sendSMS($user->username,$message->message,$user->first_name,$user->email);
                }
                $message->update([
                    'is_send' => 1
                ]);
            }
        }
        return true;
    }
}
