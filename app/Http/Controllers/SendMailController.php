<?php

namespace App\Http\Controllers;

use App\Models\NewsLetterEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller {
    public function send(Request $request) {
        $input = $request->input();

        $mails = NewsLetterEmail::all();
        foreach ($mails as $mail) {
            Mail::to($mail['mail'])->send(new \App\Mail\Mail($input['subject'], $input['message']));
        }
        Mail::to($input['monitorEmail'])->send(new \App\Mail\Mail($input['subject'], $input['message']));

        return response()->json([
            'message' => 'done!',
        ]);
    }
}
