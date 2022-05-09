<?php

namespace Modules\Visitor\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VisitorHistory extends Model
{
    use HasFactory;
    protected $table = "visitor_histories";
    protected $guarded = [];

    public function scopeVisitorCount($query, $type)
    {
        $year = Carbon::now()->year;
        if ($type == "today") {
            return $query->whereBetween('date', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->count();
        }
        if ($type == "week") {
            return $query->whereBetween('date', [Carbon::now()->subDays(7)->format('y-m-d'), Carbon::now()->format('y-m-d')])->get()->count();
        }
        if ($type == "month") {
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d');
            return $query->whereBetween('date', [$date_1, Carbon::now()->format('y-m-d')])->get()->count();
        }
        if ($type == "year") {
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d');
            return $query->whereBetween('date', [$date_1, Carbon::now()->format('y-m-d')])->get()->count();
        }

    }
}
