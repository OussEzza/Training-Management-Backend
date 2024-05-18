<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'service', 'function'];
    public function trainings()
    {
        return $this->hasMany(AgentTraining::class);
    }

}
