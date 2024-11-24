<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeedTestLog extends Model
{
    use HasFactory;

    protected $fillable = ['operation', 'num_records', 'execution_time'];
}

