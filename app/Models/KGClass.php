<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KGClass extends Model
{
    use HasFactory;

    protected $table = 'Kgclasses';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'class_name',
        'maxCapacity',
        'level_id'
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function teacher()
    {
        return $this -> belongsToMany(Employee::class,'teacher_classes','class_id','employee_id')->withTimestamps();
    }
}
