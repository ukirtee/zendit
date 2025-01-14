<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'milestone_id',
        'name',
        'start_date',
        'end_date',
        'forecast_date',
        'planned_hours'
    ];

    public function milestone()
    {
        return $this->belongsTo(Milestone::class);
    }

    public function statistics()
    {
        return $this->hasOne(TaskStatistic::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}
