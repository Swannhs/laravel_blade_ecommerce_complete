<?php

namespace Modules\Attendance\Entities;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;

class Attendance extends Model
{
    protected $table = "attendances";
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($brand) {
            $brand->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($brand) {
            $brand->updated_by = Auth::user()->id ?? null;
        });
    }
}
