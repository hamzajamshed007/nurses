<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyJobs extends Model
{
    use HasFactory;
    protected $table = 'company_job';
    protected $fillable = [
        'company_id',
        'description',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'address',
        'lat',
        'long',
        'status',
    ];
}
