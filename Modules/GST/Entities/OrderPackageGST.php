<?php

namespace Modules\GST\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderPackageDetail;

class OrderPackageGST extends Model
{
    use HasFactory;
    protected $table = "order_package_gst";
    protected $guarded = ['id'];

    public function order_package(){
        return $this->belongsTo(OrderPackageDetail::class,'package_id','id')->withDefault('X');
    }

    public function gst(){
        return $this->belongsTo(GstTax::class,'gst_id','id')->withDefault('X');
    }
}
