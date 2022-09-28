<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPosition;
use App\Models\Scopes\JobPositionPublishScope;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{

    public function index()
    {
        $jobPositions = JobPosition::withoutGlobalScope(JobPositionPublishScope::class)->get();
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

    public function show($id)
    {
        $jobPosition = JobPosition::withoutGlobalScope(JobPositionPublishScope::class)->with('details')->find($id);
        return $this->respondSuccess($jobPosition);
    }


    public function update(Request $request, $id)
    {
        $jobPosition = JobPosition::withoutGlobalScope(JobPositionPublishScope::class)->with('details')->find($id);
        $jobPosition->update($request->all());
        return $this->respondSuccess($jobPosition);
    }

    public function destroy($id)
    {
        $jobPosition = JobPosition::withoutGlobalScope(JobPositionPublishScope::class)->find($id);
        $jobPosition->delete();
        return $this->respondSuccess('Job position ' . $jobPosition->position_name . ' deleted');
    }
}
