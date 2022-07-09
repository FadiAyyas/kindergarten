<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registrations';

    protected $fillable = [
        'registrationDate',
        'child_id',
        'class_id',
        'season_year_id'
    ];
    protected $hidden = [

        'created_at',
        'updated_at',
    ];

    public function children()
    {
        return $this->belongsTo(Children::class,'child_id');
    }


    public function childAbsence()
    {
        return $this->hasMany(ChildAbsence::class,'registration_id');
    }

    public function childEvaluation()
    {
        return $this->hasMany(Evaluation::class,'registration_id');
    }
}
