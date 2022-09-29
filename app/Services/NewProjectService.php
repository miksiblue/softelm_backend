<?php

namespace App\Services;

use SendGrid;

class NewProjectService
{

    public function projectMail($data, $files)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(getenv("MAIL_FROM_NAME"));
        $email->addTo('andjelaa.petrovicc@gmail.com');
        $email->setSubject('New Project');
        if ($data['type'] === 'Job') {
            foreach ($files as $file) {
                if ($file->getClientOriginalExtension() !== 'doc' && $file->getClientOriginalExtension() !== 'pdf' && $file->getClientOriginalExtension() !== 'docx') {
                    return response(['message' => "The file must be a file of type: pdf,doc,docx."], 422);
                }
                $email->addAttachment(base64_decode(base64_encode($file)), 'application', $file->getClientOriginalName());
            }
        }
        $email->addContent(
            "text/html",
            "Full name: <strong>" . $data['full_name'] . "</strong> <br/>
                   Company name: <strong>" . $data["company_name"] . "</strong> <br/>
                   Type: <strong>" . $data["type"] . "</strong> <br/>
                   Message <strong>" . $data['message'] . "</strong>"
        );

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }
}
