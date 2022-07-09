<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusItinerary extends Model
{
    use HasFactory;

    protected $table = 'bus_itineraries';

    protected $fillable = [
        'itinerary',
        'cost'
    ];


    public function buses()
    {
        return $this->hasMany(Bus::class);
    }
}
