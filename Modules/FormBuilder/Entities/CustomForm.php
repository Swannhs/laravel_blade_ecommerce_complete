<?php

namespace Modules\FormBuilder\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'form_data',
        'status',
    ];


}
