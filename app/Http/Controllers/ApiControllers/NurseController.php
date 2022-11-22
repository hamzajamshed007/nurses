<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyJobs;
use App\Models\Applicant;
use App\Models\NursePost;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DB;

class NurseController extends Controller
{
    public function GetAllJob()
    {
        $CompanyJobs = DB::table('users')
                            ->select('users.name','users.image','company_job.*')
                            ->join('company_job', 'company_job.company_id', '=', 'users.id')
                            ->get();              
        return response()->json(['CompanyJobs'=>$CompanyJobs], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function ApplyOnJob(Request $request)
    {
        $CompanyJobs = Applicant::where('job_id',$request->job_id)->where('nurse_id',$request->nurse_id)->first();
        if($CompanyJobs == null)
        {
            $Applicant = Applicant::create([
                'nurse_id' => $request->nurse_id,
                'job_id' => $request->job_id,
                'status' => 'pending',
            ]);
            $msg = "You have Appliced Successfully";
            return response()->json(['message'=>$msg,'CompanyJobs'=>$Applicant], 200, [], JSON_UNESCAPED_SLASHES);
        }
        else
        {
            $msg = "You have Allready Appliced";
            return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
        }
    }

    public function AddNursePosts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nurse_id' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $NursePost = NursePost::create([
            'nurse_id' => $request->nurse_id,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $msg = "Post Created Successfully";

        return response()->json(['message'=>$msg,'NursePost'=>$NursePost], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function GetAllNursePost(Request $request)
    {
        if($request->nurse_id)
        {
            $NursePost = NursePost::where('nurse_id',$request->nurse_id)->get();

            return response()->json(['NursePost'=>$NursePost], 200, [], JSON_UNESCAPED_SLASHES);
        }
        else
        {
            $NursePost = DB::table('users')
                            ->select('users.name','users.image','nurse_add_post.*')
                            ->join('nurse_add_post', 'nurse_add_post.nurse_id', '=', 'users.id')
                            ->get();

            return response()->json(['NursePost'=>$NursePost], 200, [], JSON_UNESCAPED_SLASHES);
        }

    }

    public function EditNursePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nurse_id' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $NursePost = NursePost::where('id',$request->id)->update([
            'nurse_id' => $request->nurse_id,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $msg = "Post Edit Successfully";

        return response()->json(['message'=>$msg,'NursePost'=>$NursePost], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function DeleteNursePost(Request $request)
    {
        $NursePost = NursePost::where('id',$request->nurse_id)->delete();

        if($NursePost)
        {
            $msg = "Post Deleted Successfully";

            return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
        }
        else
        {
            $msg = "Post Already Deleted Successfully";

            return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
        }

    }

    public function GetAllNursesPosts()
    {
        $CompanyJobs = NursePost::get();
        dd($CompanyJobs);
        return response()->json(['CompanyJobs'=>$CompanyJobs], 200, [], JSON_UNESCAPED_SLASHES);
    }
}
// uUjW;im3u~NY