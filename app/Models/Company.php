<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'companyWebsite',
        'companySize',
        'industry',
        'contactPersonName',
        'contactPersonEmail',
        'contactPersonPhone',
        'address',
        'linkedin',
        'twitter',
        'name',
        'user_id',
    ];
}