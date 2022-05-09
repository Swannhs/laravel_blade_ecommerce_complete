<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Staff;
use App\Models\StaffDocument;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Modules\Affiliate\Repositories\AffiliateRepository;
use Modules\GeneralSetting\Entities\BusinessSetting;
use App\Traits\ImageStore;
use App\Traits\Notification;
use Modules\Account\Entities\TimePeriodAccount;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\UserNotificationSetting;
use Modules\SidebarManager\Entities\Sidebar;

class UserRepository implements  UserRepositoryInterface
{
    use ImageStore,Notification;

    public function user()
    {
        return User::with('leaves','leaveDefines')->latest()->get();
    }

    public function all($relational_keyword = [])
    {
        if (count($relational_keyword) > 0) {
            return Staff::with($relational_keyword)->whereHas('user', function($query){
                $query->where('id', '>', 1)->whereHas('role', function($q){
                    $q->where('type', 'admin')->orWhere('type', 'staff');
                });
            })->latest()->get();
        }else {
            return Staff::latest()->get();
        }

    }

    public function create(array $data)
    {
        $user = User::create($data);

        //affiliate user
        if(isModuleActive('Affiliate')){
            $affiliateRepo = new AffiliateRepository();
            $affiliateRepo->affiliateUser($user->id);
        }

        // User Notification Setting Create
        (new UserNotificationSetting())->createForRegisterUser($user->id);
        $this->typeId = EmailTemplateType::where('type','register_email_template')->first()->id;//register email templete typeid
        $this->notificationSend("Register",$user->id);

        if(BusinessSetting::where('type', 'email_verification')->first()->status != 1){
            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->save();
        }
        else {
            $user->sendEmailVerificationNotification();
        }
        $staff = new Staff;
        $staff->user_id = $user->id;
        $staff->save();
        return $staff;
    }

    public function store(array $data)
    {
        $role = explode('-', $data['role_id']);
        $user = new User;
        $user->first_name = $data['first_name'];
        $user->last_name = isset($data['last_name'])?$data['last_name']:null;
        $user->email = $data['email'];
        $user->username = $data['phone'];
        $user->role_id = $role[0];
        if (isset($data['photo'])) {
            $data = Arr::add($data, 'avatar', $this->saveAvatar($data['photo'],165,165));
            $user->avatar = $data['avatar'];
        }
        $user->password = Hash::make($data['password']);
        if($user->save()){
            $staff = new Staff;
            $staff->user_id = $user->id;
            $staff->department_id = $data['department_id'];
            $staff->phone = $data['phone'];

            $staff->bank_name = $data['bank_name'];
            $staff->bank_branch_name = $data['bank_branch_name'];
            $staff->bank_account_name = $data['bank_account_name'];
            $staff->bank_account_no = $data['bank_account_number'];
            $staff->date_of_joining = Carbon::parse($data['date_of_joining'])->format('Y-m-d');
            $staff->date_of_birth = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
            $staff->leave_applicable_date = Carbon::parse($data['leave_applicable_date'])->format('Y-m-d');
            $staff->address = $data['address'];
            if($staff->save()){
                if(BusinessSetting::where('type', 'email_verification')->first()->status != 1){
                    $user->email_verified_at = date('Y-m-d H:m:s');
                    $user->save();
                }
                else {
                    $user->sendEmailVerificationNotification();
                }
            }

            if (!$user->sidebars()->exists()) {
                $sidebars = Sidebar::where('user_id', 1)->orderBy('position', 'asc')->get();
                foreach ($sidebars as $sidebar) {
                    $data = $sidebar->toArray();
                    $data['user_id'] = $user->id;
                    
                    Sidebar::create($data);
                }
            }
        }
    }

    public function find($id)
    {
        return Staff::with('user')->findOrFail($id);
    }

    public function findUser($id)
    {
        return User::findOrFail($id);
    }

    public function findDocument($id)
    {
        return StaffDocument::where('staff_id', $id)->get();
    }

    public function update(array $data, $id)
    {
        $role = explode('-', $data['role_id']);
        $user = User::findOrFail($id);
        $staff = $user->staff;

        if (isset($data['photo'])) {
            $this->deleteImage($user->avatar);
            $data = Arr::add($data, 'avatar', $this->saveAvatar($data['photo'],165,165));
            $user->avatar = $data['avatar'];
        }

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->username = $data['phone'];
        $user->role_id = $role[0];
        $user->password = isset($data['password'])?Hash::make($data['password']):$user->password;
        $result = $user->save();
        if($result){
            $staff->user_id = $user->id;
            $staff->department_id = $data['department_id'];

            $staff->bank_name = $data['bank_name'];
            $staff->bank_branch_name = $data['bank_branch_name'];
            $staff->bank_account_name = $data['bank_account_name'];
            $staff->bank_account_no = $data['bank_account_number'];
            $staff->date_of_joining = Carbon::parse($data['date_of_joining'])->format('Y-m-d');
            $staff->leave_applicable_date = Carbon::parse($data['leave_applicable_date'])->format('Y-m-d');
            $staff->date_of_birth = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
            $staff->address = $data['address'];

            $staff->phone = $data['phone'];

            $staff->save();
        }
        if (!$user->sidebars()->exists()) {
            $sidebars = Sidebar::where('user_id', 1)->orderBy('position', 'asc')->get();
            foreach ($sidebars as $sidebar) {
                $data = $sidebar->toArray();
                $data['user_id'] = $user->id;

                Sidebar::create($data);
            }
        }

        return $staff;
    }

    public function updateProfile(array $data, $id)
    {
        $user = User::findOrFail($id);
        if (isset($data['avatar'])) {
            $user->avatar = $this->saveAvatar($data['avatar'],60,60);
        }
        $user->name = $data['name'];
        if (array_key_exists('password',$data))
            $user->password = Hash::make($data['password']);
        $result = $user->save();
        $staff = $user->staff;
        if($result){
            $staff->phone = $data['phone'];
            if ($user->role_id != 1) {
                $staff->bank_name = $data['bank_name'];
                $staff->bank_branch_name = $data['bank_branch_name'];
                $staff->bank_account_name = $data['bank_account_name'];
                $staff->bank_account_no = $data['bank_account_no'];
                $staff->address = $data['address'];
            }

            $staff->save();
        }
        return $staff;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if (File::exists(public_path($user->avatar))) {
            File::delete(public_path($user->avatar));
        }
        if(count($user->staff->documents) > 0){
            foreach($user->staff->documents as $doc){
                if (File::exists(public_path($doc->documents))) {
                    File::delete(public_path($doc->documents));
                }
                $doc->delete();
            }
        }
        $sidebars = Sidebar::where('user_id', $id)->pluck('id');
        Sidebar::destroy($sidebars);
        $user->staff->delete();
        $user->delete();
    }

    public function statusUpdate($data)
    {
        $user = User::find($data['id']);
        $user->is_active = $data['status'];
        $user->save();
        return true;
    }

    public function deleteStaffDoc($id)
    {
        $document = StaffDocument::findOrFail($id);
        if (File::exists(public_path($document->documents))) {
            File::delete(public_path($document->documents));
        }
        $document->delete();
        return true;
    }

    public function normalUser()
    {
        return User::where('id',Auth::id())->orwhere('role_id',3)->get();
    }

    public function staffImgDelete($id){
        $user = User::where('id',$id)->firstOrFail();
        ImageStore::deleteImage($user->avatar);
        $user->avatar = null;
        $user->save();
        return 1;

    }
}
