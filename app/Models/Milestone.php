<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = ['wtg_id', 'name', 'start_date', 'end_date'];

    public function wtg()
    {
        return $this->belongsTo(Wtg::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


}
