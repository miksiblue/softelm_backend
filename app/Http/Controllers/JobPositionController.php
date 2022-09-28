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
}
