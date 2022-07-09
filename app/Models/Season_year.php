<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season_year extends Model
{
    use HasFactory;

    protected $table = 'season_years';
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'year',
        'seasonStartDate',
        'seasonEndDate',
        'cost',
        'season_id'
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function level()
    {
        return $this -> belongsToMany(level::class,'level_season_costs','season_year_id','level_id')->withPivot('cost');
    }


}
