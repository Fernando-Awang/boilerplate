<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'office_address',
        'phone',
        'email',
        'about',
        'vision',
        'mission',
    ];
}
