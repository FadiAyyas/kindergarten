<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LevelsRequest;
use App\Models\Level;
use App\Models\Season_year;
use App\Http\Traits\GeneralTrait;
use Throwable;

class LevelsController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        try {
            $levelsCosts = Season_year::join("level_season_costs", "season_year_id", "=", "season_years.id")
                ->join("levels", "levels.id", "=", "level_season_costs.level_id")
                ->get([
                    'levels.id', 'levels.level_name', 'levels.level_minAge', 'levels.level_maxAge',
                    'season_years.id as season_year_id','season_years.year', 'season_years.seasonStartDate', 'season_years.seasonEndDate',
                    'level_season_costs.cost'
                ]);
            return $this->returnData('Level', $levelsCosts, ' Levels and Cost details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function store(LevelsRequest $request)
    {
        try {

            $Level = new Level;
            $Level->level_name = $request->level_name;
            $Level->level_minAge = $request->level_minAge;
            $Level->level_maxAge = $request->level_maxAge;
            $Level->save();

            $Level->Season_year()->attach($request->season_year_id, ['cost' => $request->cost]);
            return $this->returnSuccessMessage('Level created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function update(LevelsRequest $request, $id)
    {
        try {
            $Level = Level::findOrFail($id);
            $Level->level_name = $request->level_name;
            $Level->level_minAge = $request->level_minAge;
            $Level->level_maxAge = $request->level_maxAge;
            $Level->save();
            $Level->Season_year()
                ->newPivotStatement()
                ->where('id', '=', $Level->id)
                ->update([
                    'season_year_id' => $request->season_year_id,
                    'cost' =>  $request->cost
                ]);

            return $this->returnSuccessMessage('Level update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function destroy($id)
    {
        try {
            $data = Level::findOrFail($id);
            $data->Season_year()->detach();
            $data->classes()->detach();
            $data->delete();

            return $this->returnError("Level delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Level does not exists');
        }
    }
}
