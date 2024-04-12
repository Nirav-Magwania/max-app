<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\MyMail;
use App\Mail\UserMember;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|email'
        ]);
        $email = $data['email'];

        $body= [
            'name'=>$data['name'],
            'url_a'=>'https://www.serveravatar.com/',
            'url_b'=>'https://gamexpot7.wordpress.com/'
        ];

        Mail::to($email)->send(new MyMail($body));
        return back()->with('status','Mail Sent Successfully');

    }

  
}