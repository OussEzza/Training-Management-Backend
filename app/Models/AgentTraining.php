<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentTraining extends Model
{
    use HasFactory;

    // Add this if you have a custom table name
    // protected $table = 'agent_training';

    protected $fillable = ['agent_id', 'training_id', 'date_from', 'date_to', 'expired'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}
