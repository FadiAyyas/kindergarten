<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Season_year;
use App\Http\Traits\GeneralTrait;
use App\Models\Gallery;
use App\Models\KgContact;
use App\Models\Services;
use App\Models\ActivityPhotos;
use App\Models\Kindergarten;

class WebsiteController extends Controller
{
    use GeneralTrait;

    public function getCurrentLevelsCost()
    {
        //get latest rescord in season_year table thats means the current costs to all levels.
        $season=Season_year::latest('id')->first();
        $levelsCosts = Season_year::join("level_season_costs", "season_year_id", "=", "season_years.id")
            ->join("levels", "levels.id", "=", "level_season_costs.level_id")
            ->where("season_years.id", $season->id)
            ->get([
                'levels.level_name', 'levels.level_minAge', 'levels.level_maxAge',
                'season_years.year', 'season_years.seasonStartDate', 'season_years.seasonEndDate',
                'level_season_costs.cost'
            ]);

        return $this->returnData('levels', $levelsCosts, 'Latest Costs');
    }


    public function getKindergartenDetails()
    {
        $details = Kindergarten::all();
        return $this->returnData('details', $details, ' Kindergarten general details ');
    }


    public function getGalleryImages()
    {
        $images = Gallery::all();
        return $this->returnData('images', $images, ' Kindergarten Gallery images paths');
    }

    public function getServicesDetails()
    {
        $services = Services::all();
        return $this->returnData('services', $services, 'Kindergarten Services details');
    }

    public function getContactDetails()
    {
        $contacts = KgContact::all();
        return $this->returnData('contacts', $contacts, 'Kindergarten Contacts details');
    }

    public function getActivityImages()
    {
        $images = ActivityPhotos::all();
        return $this->returnData('images', $images, 'Kindergarten Activity images Paths');
    }
}
