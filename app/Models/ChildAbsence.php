<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildAbsence extends Model
{
    use HasFactory;

    protected $table = 'child_absences';

    protected $fillable = [
        'registration_id',
        'date'
    ];

    protected $hidden = [

        'created_at',
        'updated_at'
    ];


    public function registration()
    {
        return $this->belongsTo(Registration::class,'registration_id');
    }
}
