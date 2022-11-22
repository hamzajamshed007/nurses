<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    protected $table ='applicants_nurses';
    protected $fillable = [
        'nurse_id',
        'job_id',
        'status',
    ];
}
