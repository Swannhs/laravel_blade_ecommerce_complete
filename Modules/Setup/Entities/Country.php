<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $guarded = ['id'];

    public function states(){
        return $this->hasMany(State::class,'country_id','id')->orderBy('name');
    }
}
