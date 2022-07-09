<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityPhotos extends Model
{
    use HasFactory;

    protected $table = 'activity_photos';

    protected $fillable = [
        'image_path'
    ];
}
