<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function cities(){
        return $this->hasMany(City::class,'state_id','id')->orderBy('name');
    }
}
