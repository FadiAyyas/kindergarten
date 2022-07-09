<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Models\Season_year;
use App\Models\Season;
use App\Http\Traits\GeneralTrait;
use App\Http\Requests\Backend\SeasonYearRequest;
use Throwable;

class SeasonYearController extends Controller
{
    use GeneralTrait;

    public function showSeason()
    {
        try {
            $Seasons = Season::all();
            return $this->returnData('Seasons', $Seasons, ' Seasons details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function index()
    {
        try {
            $seasons = Season_year::with('season')->get();
            return $this->returnData('Seasons', $seasons, ' seasons details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }


    public function store(SeasonYearRequest $request)
    {

        try {
            $Season = Season::findOrFail($request->season_id);
            $Season_year = new Season_year();
            $Season_year->year = $request->year;
            $Season_year->seasonStartDate = $request->seasonStartDate;
            $Season_year->seasonEndDate = $request->seasonEndDate;

            $Season = $Season->seasonYear()->save($Season_year);
            return $this->returnSuccessMessage('Season year created successfully ');
        } catch (Throwable $e) {
            return $this->returnError($e);
        }
    }

    public function update(SeasonYearRequest $request, $id)
    {
        $input = $request->all();
        try {
            $data = Season_year::findOrFail($id);
            $data->update($input);
            return $this->returnSuccessMessage('Season year update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong , please try again late ');
        }
    }

    public function destroy($id)
    {
        try {
            $data = Season_year::findOrFail($id);
            $data->delete();
            return $this->returnError("Level delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Level does not exists');
        }
    }
}
