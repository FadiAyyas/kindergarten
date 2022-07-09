<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $table = 'buses';

    protected $fillable = [
        'employee_id',
        'driverName',
        'driverPhoneNumber',
        'busTypeName',
        'plateNumber',
        'busItinerary_id'
    ];

    public function itinerary()
    {
        return $this->belongsTo(BusItinerary::class);
    }
}
