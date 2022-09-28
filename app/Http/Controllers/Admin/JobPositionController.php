<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPosition;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{

    public function index()
    {
        $jobPositions = JobPosition::all();
        return $this->respondSuccess($jobPositions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'position_name' => 'required',
            'position_description' => 'required'
        ]);

        $jobPositoon = JobPosition::create($data);
        return $this->respondSuccess($data);
    }

    public function show(JobPosition $jobPosition)
    {
        return $this->respondSuccess($jobPosition);
    }


    public function update(Request $request, JobPosition $jobPosition)
    {
        $jobPosition->update($request->all());
        return $this->respondSuccess(JobPosition::find($jobPosition));
    }

    public function destroy(JobPosition $jobPosition)
    {
        $jobPosition->delete();
        return $this->respondSuccess('Job position '.$jobPosition->position_name.' deleted');
    }
}
