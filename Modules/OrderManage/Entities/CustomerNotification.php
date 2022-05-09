<?php

namespace Modules\OrderManage\Entities;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id','id');
    }
}
