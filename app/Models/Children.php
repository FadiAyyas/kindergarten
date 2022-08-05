<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;

    protected $table = 'childrens';
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'childName',
        'birthDate',
        'gender',
        'ChildImage',
        'childAddress',
        'medicalNotes',
        'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(ParentCh::class);
    }

    public function registration()
    {
        return $this->hasMany(Registration::class,'child_id');
    }
}
