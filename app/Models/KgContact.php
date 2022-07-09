<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KgContact extends Model
{
    use HasFactory;

    protected $table = 'KGcontacts';

    protected $fillable = [
        'type',
        'contact'
    ];
}
