<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentPhoneNumbers extends Model
{
    use HasFactory;

    protected $table = 'parent_phone_numbers';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'type',
        'phoneNumber',
        'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(ParentCh::class);
    }
}
