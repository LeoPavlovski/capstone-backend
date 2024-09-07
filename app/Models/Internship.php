<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'start_date',
        'end_date',
        'location',
        'duration',
        'stipend',
        'deadline',
        'description'
    ];
}
