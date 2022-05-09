<?php

namespace Modules\Seller\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Setup\Entities\Country;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected static function newFactory()
    {
        return \Modules\Seller\Database\factories\SupplierFactory::new();
    }

    public function country(){
        return Country::where('code',$this->country)->firstOrFail();
    }
}
