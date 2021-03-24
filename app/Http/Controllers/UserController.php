<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function get(Request $request)
    {
        $user_id = $request->get("uid", 0);
        $user = User::find($user_id);
        return $user;
    }

    public function home(){
        return view('landing');
    }

    public function sendEmail(Request $request){
        $msg = "Name : " .$request->name . "<br>". "Email : " .$request->email . "<br>" . "Message : " .$request->message . "<br>";
        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg,70);
        // send email
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // More headers
        $headers .= 'From: <'.$request->email.'>' . "\r\n";
        mail("me.aliriaz007@gmail.com",$request->subject,$msg, $headers);
    }

    public function openPayment(){

    }
}
