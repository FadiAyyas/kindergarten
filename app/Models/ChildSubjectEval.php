<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildSubjectEval extends Model
{
    use HasFactory;

    protected $table = 'child_subject_evals';

    protected $fillable = [
        'subject_id',
        'registration_id',
        'evaluation'
    ];
}
