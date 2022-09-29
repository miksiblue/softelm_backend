<?php

namespace App\Http\Controllers;

use App\Services\NewProjectService;
use Illuminate\Http\Request;

class NewProjectController extends Controller
{

    public function newProjectEmail(Request $request, NewProjectService $newProjectService)
    {
        $data = $request->validate([
            'full_name' => 'required',
            'email' => 'required|email',
            'company_name' => 'nullable',
            'type' => 'required',
            'message' => 'required',
            'privacy' => 'required',
        ], [
            'privacy' => 'You need to accept the privacy and policy'
        ]);

        if (isset($request->privacy)) {

            if ($data['type'] === 'Job') {
                $request->validate([
                    'file' => 'required|max:3078'
                ]);
                $data['file'] = $request->file;
                $newProjectService->projectMail($data, $request->file);
            } else {
                $newProjectService->projectMail($data, '');
            }
        }
    }
}
