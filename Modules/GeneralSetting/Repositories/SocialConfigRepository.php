<?php

namespace Modules\GeneralSetting\Repositories;

use Modules\GeneralSetting\Entities\FacebookMessage;
use Modules\GeneralSetting\Entities\GeneralSetting;

class SocialConfigRepository
{
    public function getMessangerData(){
        return FacebookMessage::first();
    }
    
    public function messangerChatUpdate($data){
        return FacebookMessage::first()->update([
            'code' => $data['code'],
            'status' => isset($data['messanger_chat_status'])?$data['messanger_chat_status']:0
        ]);
    }

    public function socialLoginConfigurationUpdate($request)
    {

        $generatlSetting = GeneralSetting::first();
        $generatlSetting->update($request->all());
        if($request->facebook_client_id){
            setEnv("FACEBOOK_CLIENT_ID",$request->facebook_client_id);
        }
        if($request->facebook_client_secret){
            setEnv("FACEBOOK_CLIENT_SECRET",$request->facebook_client_secret);
        }

        if($request->google_client_id){
            setEnv("GOOGLE_CLIENT_ID",$request->google_client_id);
        }
        if($request->google_client_secret){
            setEnv("GOOGLE_CLIENT_SECRET",$request->google_client_secret);
        }

        if($request->twitter_client_id){
            setEnv("TWITTER_CLIENT_ID",$request->twitter_client_id);
        }
        if($request->twitter_client_secret){
            setEnv("TWITTER_CLIENT_SECRET",$request->twitter_client_secret);
        }

        if($request->linkedin_client_id){
            setEnv("LINKEDIN_CLIENT_ID",$request->linkedin_client_id);
        }
        if($request->linkedin_client_secret){
            setEnv("LINKEDIN_CLIENT_SECRET",$request->linkedin_client_secret);
        }
    }
}
