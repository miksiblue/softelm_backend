<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPosition;
use App\Models\JobPositionDetail;
use Illuminate\Http\Request;

class JobPositionDetailController extends Controller
{

    public function store(Request $request)
    {
        $job = JobPosition::with('details')->find($request->job_position_id);
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'job_position_id' => 'required'
        ]);
        $maxOrder = $job->details->pluck('order')->max();
        $data['order'] = $maxOrder += 1;
        $detail = JobPositionDetail::create($data);

        return $this->respondSuccess($detail);
    }

    public function update(Request $request, JobPositionDetail $jobPositionDetail)
    {
        $job = JobPosition::find($request->job_position_id);
        $orders = $job->details()->where('id', '!=', $jobPositionDetail->id)->pluck('order');
        if ($orders->contains($request->order)) {
            return 'Orders cannot have same number';
        }
        $jobPositionDetail->update($request->all());
        return $this->respondSuccess($jobPositionDetail);
    }


    public function destroy(JobPositionDetail $jobPositionDetail)
    {
        $jobPositionDetail->delete();
        return $this->respondSuccess($jobPositionDetail->title.' deleted');
    }
}
