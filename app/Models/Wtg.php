<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wtg extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // wtg has many milestones
    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}
