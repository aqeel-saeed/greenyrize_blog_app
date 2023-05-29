<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\NewsLetterEmail;
use App\Traits\ReturnResponse;
use Illuminate\Http\Request;

class EmailController extends Controller {
    use ReturnResponse;
    public function index() {
        $emails = NewsLetterEmail::all();

        return $this->returnData('data',$emails, 'Emails retrieved successfully.');
    }

    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:news_letter_emails,email'
        ]);

        NewsLetterEmail::create($request->all());

        return $this->returnSuccessMessage('Email stored successfully.');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'email' => 'required|email|unique:news_letter_emails,email'
        ]);

        $email = NewsLetterEmail::find($id);

        if(is_null($email)) {
            return $this->returnError(404, 'Email id is not valid.');
        }

        $email->update($request->all());

        return $this->returnSuccessMessage('Email updated successfully.');
    }

    public function destroy($id) {
        $email = NewsLetterEmail::find($id);

        if(is_null($email)) {
            return $this->returnError(404, 'Email id is not valid.');
        }

        $email->delete();

        return $this->returnSuccessMessage('Email deleted successfully.');
    }
}
