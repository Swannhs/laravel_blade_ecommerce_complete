<?php

namespace Modules\OrderManage\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\OrderManage\Entities\DeliveryProcess;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderDeliveryState extends Model
{
    use HasFactory;
    protected $table = "order_delivery_states";
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($brand) {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }

    public function delivery_process(){
        return $this->belongsTo(DeliveryProcess::class,'delivery_status','id');
    }

    public function getDeliveryStateNameAttribute()
    {
        if ($this->delivery_status == 1) {
            return "Processing";
        }elseif ($this->delivery_status == 2) {
            return "Shipped";
        }elseif ($this->delivery_status == 3) {
            return "Delivered";
        }elseif ($this->delivery_status == 4) {
            return "Recieved";
        } else {
            return "Pending";
        }
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
