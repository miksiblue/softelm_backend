<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Http\Request;
use SendGrid;

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
                'date_of_birth' => 'required|date',
                'phone_number' => 'required',
                'linkedln_link' => 'required|url',
                'cv_files' => 'required'
            ]);

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(getenv("MAIL_FROM_NAME"));
        $email->addTo('andjelaa.petrovicc@gmail.com');
        $email->setSubject('Job application');
        $email->addContent(
            "text/html",
            "<h2>Job Position: <strong>" . $jobPosition->position_name . "</strong> </h2> <br/>
             Name: <strong>" . $request->name . "</strong> <br/>
             Surname: <strong>" . $request->surname . "</strong> <br/>
             Email: <strong>" . $request->email . "</strong> <br/>
             Date of birth: <strong>" . $request->date_of_birth . "</strong> <br/>
             Phone: <strong>" . $request->phone_number . "</strong> <br/>
             Linkedln <strong>" . $request->linkedln_link
        );

        foreach ($request->cv_files as $file) {
            if ($file->getClientOriginalExtension() !== 'doc' && $file->getClientOriginalExtension() !== 'pdf' && $file->getClientOriginalExtension() !== 'docx') {
                return response(['message' => "The file must be a file of type: pdf,doc,docx."], 422);
            }
            $email->addAttachment(base64_decode(base64_encode($file)), 'application', $file->getClientOriginalName());
        }

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($email);
            return response()->json(['status code:' => $response->statusCode(), 'headers' => $response->headers(), 'body' => $response->body()], 202);

        } catch (\Exception $e) {
            return response()->json(['Caught exception ' => $e->getMessage()]);
        }
    }
}
