<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NursePost extends Model
{
    use HasFactory;
    protected $table = 'nurse_add_post';
    protected $fillable = [
        'nurse_id',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];
}
