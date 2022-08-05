<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\ParentCh;
use App\Models\Registration;
use Throwable;
use App\Http\Traits\GeneralTrait;
use App\Http\Requests\Backend\ChildrensRequest;
use App\Http\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class ChildrensController extends Controller
{
    use GeneralTrait, ImageUploadTrait;

    //show childrens
    public function index()
    {
        try {

            $details = Children::Join("registrations", "registrations.child_id", "=", "childrens.id")
            ->Join("Kgclasses", "Kgclasses.id", "=", "registrations.class_id")
            ->Join("season_years", "season_years.id", "=", "registrations.season_year_id")
            ->get([
                'childrens.id','childrens.childName','childrens.gender', 'childrens.birthDate','childrens.ChildImage','childrens.childAddress','childrens.medicalNotes',
                'Kgclasses.id as class_id','Kgclasses.class_name',
                'season_years.id as season_year_id','season_years.year','season_years.seasonStartDate' ,
            ])->all();

            return $this->returnData('details', $details, ' Childrens details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    //Registration childrens
    public function store(ChildrensRequest $request, $parent_id)
    {
        try {
                $child=$request->all();
                $parent = ParentCh::findOrFail($parent_id);

                $Parentchild = new Children;
                $Parentchild->childName = $child['childName'];
                $Parentchild->birthDate = $child['birthDate'];
                $Parentchild->gender = $child['gender'];
                $Parentchild->childAddress = $child['childAddress'];
                $Parentchild->medicalNotes = $child['medicalNotes'];
                $Parentchild->ChildImage = $this->uploadImage($child['childName'], $child['ChildImage'], 'Childrens/images/');

                $chilsRegistration = new Registration;
                $chilsRegistration->class_id = $child['class_id'];
                $chilsRegistration->season_year_id = $child['season_year_id'];
                $chilsRegistration->registrationDate = now();

                DB::transaction(function () use ($parent, $chilsRegistration, $Parentchild) {
                    $parent->childrens()->save($Parentchild);
                    $Parentchild->registration()->save($chilsRegistration);
                });

            return $this->returnSuccessMessage('Childrens created successfully ');
        } catch (Throwable $e) {
            return $this->returnError($e);
        }
    }

    //edit childrens
    public function update(ChildrensRequest $request, $child_id)
    {
        try {
            $input=$request->all();
            $Child = Children::findOrFail($child_id);
            if ($request->ChildImage) {

                $this->imageDelete($Child->ChildImage);
                $input['ChildImage'] = $this->uploadImage($input['childName'], $input['ChildImage'], 'Childrens/images/');
                //return $this->returnSuccessMessage($input['ChildImage']);
            }

            $Child->update($input);
            return $this->returnSuccessMessage('Childrens updated successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function ShowFathersChildrensDetails($parent_id)
    {
        try {
            $details = Children::where('parent_id', $parent_id)->get();
            return $this->returnData('details', $details, 'Father Childrens details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function showChildDetails($child_id)
    {
        try {
            $details = Children::findOrFail($child_id);
            return $this->returnData('details', $details, 'child details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    //Show the absence of a child
    public function showChildAbsence($child_id)
    {
        try {
            $registration = Registration::latest('id')->where('child_id', $child_id)->first();
            $details = $registration->childAbsence;

            return $this->returnData('details', $details, 'Child Absence details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }


    //Show child reviews
    public function showChildEvaluations($child_id)
    {
        try {
            $registration = Registration::latest('id')->where('child_id', $child_id)->first();
            $details = $registration->childEvaluation;

            return $this->returnData('details', $details, 'Child Absence details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    //search child details
    public function searchChild(Request $request)
    {
    }

    //delete child details
    public function destroy($child_id)
    {
        try {
            $data = Children::findOrFail($child_id);
            $this->imageDelete($data->ChildImage);
            $data->delete();
            return $this->returnError("Children details delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Children details does not exists');
        }
    }
}
