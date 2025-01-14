<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'actual_hours',
        'variance',
    ];

    protected function casts(): array
    {
        return [
            'actual_hours' => 'float',
            'variance' => 'float',
        ];
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
