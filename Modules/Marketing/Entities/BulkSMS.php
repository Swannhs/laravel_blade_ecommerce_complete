<?php

namespace Modules\Marketing\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Modules\RolePermission\Entities\Role;

class BulkSMS extends Model
{

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->created_by == null) {
                $model->created_by = Auth::user()->id ?? null;
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }

    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function send_to(){
        if($this->send_type == 1){
            return 'All User';
        }
        if($this->send_type == 2){
            return Role::where('id',$this->single_role_id)->pluck('name');

        }
        if($this->send_type == 3){
            return Role::whereIn('id',json_decode($this->multiple_role_id))->pluck('name');
        }
    }
}
