<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusChild extends Model
{
    use HasFactory;

    protected $table = 'bus_children';

    protected $fillable = [
        'bus_id',
        'registration_id'
    ];
}
