<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'level_name',
        'level_minAge',
        'level_maxAge',
        'cost'
    ];


    public function classes()
    {
        return $this->hasMany(KGClass::class);
    }

    public function Season_year()
    {
        return $this -> belongsToMany(Season_year::class,'level_season_costs','level_id','season_year_id')->withPivot('cost');
    }
}
