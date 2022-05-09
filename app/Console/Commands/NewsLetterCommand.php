<?php

namespace App\Console\Commands;

use App\Mail\NewsLetterMail;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\SendMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Marketing\Entities\NewsLetter;

class NewsLetterCommand extends Command
{
    use SendMail;

    protected $signature = 'command:newsletter';


    protected $description = 'send news letter to email';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $messages = NewsLetter::where('is_send',0)->get();
        foreach($messages as $key => $message){
            $general_setting = DB::table('general_settings')->select('mail_signature','mail_footer','site_title')->first();
            if($message->send_type == 4){
                if($message->publish_date == date("Y-m-d")){
                    foreach(json_decode($message->send_user_ids) as $key => $id){
                        $user = Subscription::findOrFail($id);
                        $array['subject'] = $message->title;
                        $array['from'] = env('MAIL_USERNAME');
                        $array['content'] = $message->message;
                        $array['content'] = str_replace('{EMAIL_SIGNATURE}',$general_setting->mail_signature,$array['content']);
                        $array['content'] = str_replace('{EMAIL_FOOTER}',$general_setting->mail_footer,$array['content']);

                        $array["content"] = str_replace("{USER_FIRST_NAME}", "Subscriber", $array["content"]);
                        $array["content"] = str_replace("{USER_EMAIL}", $user->email, $array["content"]);
                        $array["content"] = str_replace("{WEBSITE_NAME}", $general_setting->site_title, $array["content"]);

                        $mailPath = '\App\Mail\NewsLetterMail';
                        $template = 'backEnd.template';
                        $this->sendMailWithTemplate($user->email,$array,$mailPath,$template);
                        
                    }
                    $message->update([
                        'is_send' => 1
                    ]);
                }

            }else{
                if($message->publish_date == date("Y-m-d")){
                    foreach(json_decode($message->send_user_ids) as $key => $id){

                        $user = User::findOrFail($id);
                        $array['subject'] = $message->title;
                        $array['from'] = env('MAIL_USERNAME');
                        $array['content'] = $message->message;
                        $array['content'] = str_replace('{EMAIL_SIGNATURE}',$general_setting->mail_signature,$array['content']);
                        $array['content'] = str_replace('{EMAIL_FOOTER}',$general_setting->mail_footer,$array['content']);

                        $array["content"] = str_replace("{USER_FIRST_NAME}", "Subscriber", $array["content"]);
                        $array["content"] = str_replace("{USER_EMAIL}", $user->email, $array["content"]);
                        $array["content"] = str_replace("{WEBSITE_NAME}", $general_setting->site_title, $array["content"]);
                        $mailPath = '\App\Mail\NewsLetterMail';
                        $template = '/backend/template';
                        $this->sendMailWithTemplate($user->email,$array,$mailPath,$template);

                    }
                    $message->update([
                        'is_send' => 1
                    ]);
                }
            }
        }
        return true;

    }
}
