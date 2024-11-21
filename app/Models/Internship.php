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
        'stipend',
        'deadline',
        'description',
        'user_id',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_internship'); // Many-to-many pivot table
    }

}
