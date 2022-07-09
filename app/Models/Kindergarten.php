<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kindergarten extends Model
{
    use HasFactory;

    protected $table = 'kindergartens';

    protected $fillable = [
        'name',
        'address',
        'numberOfDaysinWeek',
        'numberOfHourInDay',
        'logo',
        'aboutUs',
        'webHeaderImage',
        'lat',
        'lng'
    ];
}
