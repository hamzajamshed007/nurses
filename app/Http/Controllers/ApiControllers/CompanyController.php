<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyJobs;
use Illuminate\Support\Facades\Validator;
use App\Models\Applicant;
use App\Models\User;

class CompanyController extends Controller
{
    public function AddJobByCompanys(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $CompanyJobs = CompanyJobs::create([
            'company_id' => $request->company_id,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'address' => $request->address,
            'lat' => $request->lat,
            'long' => $request->long,
            'status' => $request->status,
        ]);

        $msg = "Job Created Successfully";

        return response()->json(['message'=>$msg ,'CompanyJobs'=>$CompanyJobs], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function GetCompanyJobs(Request $request)
    {
        $CompanyJobs = CompanyJobs::where('company_id',$request->company_id)
                                    ->where('status', '=','pending')
                                    ->where('is_assign','=',null)
                                    ->get();
        return response()->json(['CompanyJobs'=>$CompanyJobs], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function GetCompanyJobDescription(Request $request)
    {
        $CompanyJobs = CompanyJobs::where('id',$request->company_job_id)->where('company_id',$request->company_id)->first();
        if($CompanyJobs == null)
        {
            return response()->json(['message'=>'Description Not Found'], 200, [], JSON_UNESCAPED_SLASHES);
        }
        return response()->json(['CompanyJobs'=>$CompanyJobs], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function GetNursesAppliedOnJob(Request $request)
    {
        $Applicant = Applicant::select('nurse_id')->where('job_id',$request->job_id)->get();
        $User = User::whereIn('id',$Applicant)->get();
        return response()->json(['User'=>$User], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function NurseAssignByCompany(Request $request)
    {
        $CompanyJob = Applicant::select('status')->where('job_id',$request->job_id)->where('status','assigned')->first();

        if($CompanyJob)
        {
            return response()->json(['message'=>'You Allready have Assigned this job to some one'], 200, [], JSON_UNESCAPED_SLASHES);
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'start_date'    => 'required',
                'end_date'      => 'required',
                'start_time'    => 'required',
                'end_time'      => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
    
            $AssignedApplicent = Applicant::where('nurse_id',$request->nurse_id)->update([
                'start_date'    => $request->start_date,
                'end_date'      => $request->end_date,
                'start_time'    => $request->start_time,
                'end_time'      => $request->end_time,
                'status'        => 'assigned',
            ]);

            $CompanyJobs = CompanyJobs::where('id',$request->job_id)->update([
                'is_assign' => 'assign',
            ]);

            return response()->json(['AssignedApplicent' => 'You have Assigned this job Successfully'], 200, [], JSON_UNESCAPED_SLASHES);
        }
    }
}
