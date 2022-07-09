<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_season_cost extends Model
{
    use HasFactory;

    protected $table = 'level_season_costs';
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'level_id',
        'season_year_id	',
        'cost',
    ];

  
}
