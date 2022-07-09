<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentChildAbsence extends Model
{
    use HasFactory;

    protected $table = 'parent_child_absences';

    protected $fillable = [
        'startDate',
        'endDate',
        'reason',
        'registration_id'
    ];
}
