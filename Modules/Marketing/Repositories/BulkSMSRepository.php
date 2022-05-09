<?php
namespace Modules\Marketing\Repositories;

use App\Mail\NewsLetterMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Modules\Marketing\Entities\BulkSMS;
use Modules\RolePermission\Entities\Role;
use App\Traits\SendSMS;
use Modules\GeneralSetting\Entities\SmsTemplate;

class BulkSMSRepository {
    use SendSMS;

    public function getAll(){
        return BulkSMS::latest();
    }
    public function store($data){
        $user_ids = "";
        if($data['send_to'] == 1){
            $user_ids = json_encode($data['all_user']);
        }
        if($data['send_to'] == 2){
            $user_ids = json_encode($data['role_user']);
            $single_role_id = $data['role'];
        }
        if($data['send_to'] == 3){
            $user_ids = json_encode(User::whereIn('role_id',$data['role_list'])->pluck('id'));
            $multiple_role_id = json_encode($data['role_list']);
        }
        return BulkSMS::create([
            'title' => $data['title'],
            'message' => $data['message'],
            'publish_date' => Carbon::parse($data['publish_date'])->format('Y-m-d'),
            'send_type' => $data['send_to'],
            'send_user_ids' => $user_ids,
            'single_role_id' => isset($single_role_id)?$single_role_id:null,
            'multiple_role_id' => isset($multiple_role_id)?$multiple_role_id:null
        ]);
    }

    public function update($data){
        $user_ids = "";
        if($data['send_to'] == 1){
            $user_ids = json_encode($data['all_user']);
        }
        if($data['send_to'] == 2){
            $user_ids = json_encode($data['role_user']);
            $single_role_id = $data['role'];
        }
        if($data['send_to'] == 3){
            $user_ids = json_encode(User::whereIn('role_id',$data['role_list'])->pluck('id'));
            $multiple_role_id = json_encode($data['role_list']);
        }
        return BulkSMS::where('id',$data['id'])->update([
            'title' => $data['title'],
            'message' => $data['message'],
            'publish_date' => Carbon::parse($data['publish_date'])->format('Y-m-d'),
            'send_type' => $data['send_to'],
            'send_user_ids' => $user_ids,
            'single_role_id' => isset($single_role_id)?$single_role_id:null,
            'multiple_role_id' => isset($multiple_role_id)?$multiple_role_id:null
        ]);
    }

    public function testSMS($data){
        $message = BulkSMS::findOrFail($data['id']);
        $this->sendSMS($data['phone'],$message->message,'User');
        return true;
    }

    public function getAllUser(){
        return User::where('username','!=',null)->get();
    }
    public function getUserByRole($id){
        return User::where('username','!=',null)->where('role_id',$id)->get();
    }
    public function deleteById($id){
        return BulkSMS::findOrFail($id)->delete();
    }
    public function editById($id){
        return BulkSMS::findOrFail($id);
    }

    public function getActiveTemplate(){
        return SmsTemplate::where('type_id', 17)->where('is_active', 1)->first();
    }
}
