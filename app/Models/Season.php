<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $table = 'seasons';
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'seasons_name'
    ];


    public function seasonYear()
    {
        return $this->hasMany(Season_year::class);
    }
}
