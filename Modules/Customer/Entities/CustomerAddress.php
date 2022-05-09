<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Setup\Entities\City;
use Modules\Setup\Entities\Country;
use Modules\Setup\Entities\State;

class CustomerAddress extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $fillable = [];
    
    public function getCountry(){
        return $this->belongsTo(Country::class,'country','id');
    }

    public function getState(){
        return $this->belongsTo(State::class,'state','id');
    }

    public function getCity(){
        return $this->belongsTo(City::class,'city','id');
    }
}
