<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{
    public function index()
    {
        return $this->respondSuccess(JobPosition::all());
    }

    public function show(JobPosition $jobPosition)
    {
        return $jobPosition->where('id', $jobPosition->id)->with('details')->get();
    }

    public function applyForJob(Request $request, JobPosition $jobPosition)
    {
        $this->validate($request, [
                'name' => 'required',
                'surname' => 'required',
                'email' => 'required|email',
                'birthday' => 'required|date',
                'phone_number' => 'required',
                'linkedln_link' => 'required|url',
            ]
        );
    }
}
