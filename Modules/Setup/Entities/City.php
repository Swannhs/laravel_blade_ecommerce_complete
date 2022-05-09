<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function state(){
        return $this->belongsTo(State::class,'state_id','id');
    }
    
}
