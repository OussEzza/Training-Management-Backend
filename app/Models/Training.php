<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    //fillable models are created with the same name as models in the database table
    protected $fillable = ['name', 'duration', 'category'];
}
