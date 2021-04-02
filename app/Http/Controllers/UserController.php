<?php
namespace App\Http\Controllers;

use App\dreams;
use App\Http\Controllers\Controller;
use App\PaymentHistory;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
use services\email_messages\InvitationMessageBody;
use services\email_services\EmailAddress;
use services\email_services\EmailBody;
use services\email_services\EmailMessage;
use services\email_services\EmailSender;
use services\email_services\EmailSubject;
use services\email_services\MailConf;
use services\email_services\PhpMail;
use services\email_services\SendEmailService;

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
        return redirect()->back();
    }

    public function openPayment(Request $request){
        $dream = $request->dream;
        $dreamTable = new dreams();
        $dreamTable->user_id = md5(rand(0,5000));
        $dreamTable->dream = $dream;
        $dreamTable->save();
        return redirect('complete-payment/' . $dreamTable->user_id);
    }

    public function completePaymentView($userId){
        return view('complete-payment')->with(['userId' => $userId]);
    }

    public function completeRegistration(Request $request){
        try {
            if (User::where('email',$request->email)->exists()){
                return redirect()->back()->withErrors("Email Already Exists!");
            }
            $stripe = \Cartalyst\Stripe\Laravel\Facades\Stripe::setApiKey(env('STRIPE_SECRET'));
            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $request->cardNumber,
                    'exp_month' => $request->month,
                    'exp_year' => $request->year,
                    'cvc' => $request->cvv,
                ],
            ]);

            if (!isset($token['id'])) {
                return redirect()->back()->withErrors("Token Id does not Exists! Please try again!");
            }



            $charge = $stripe->charges()->create([
                'card' => $token['id'],
                'currency' => 'GBP',
                'amount' => 1.99,
                'description' => 'wallet',
            ]);

            if ($charge['status'] == 'succeeded') {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = md5($request->password);
                $user->card = ($request->cardNumber);
                $user->exp_year = ($request->year);
                $user->exp_month = ($request->month);
                $user->cvv = ($request->cvv);
                $user->last_payment = date('Y-m-d');
                $user->save();

                if (dreams::where('user_id', $request->userId)->exists()){
                    $dream = dreams::where('user_id', $request->userId)->first();
                    $dream->user_id = $user->id;
                    $dream->update();
                }


                $paymentHistory = new PaymentHistory();
                $paymentHistory->user_id = $user->id;
                $paymentHistory->amount = 1.99;
                $paymentHistory->date = date('Y-m-d');
                $paymentHistory->save();

                Session::put('userId', $user->id);
                $dreamId = dreams::where('user_id', $user->id)->latest()->first()['id'];
                $userEncodedId = JWT::encode($user->id, 'secret-2021');
                $subject = new SendEmailService(new EmailSubject("Your account has been created on dreaming"));
                $mailTo = new EmailAddress($user->email);
                $invitationMessage = new InvitationMessageBody();
                $emailBody = $invitationMessage->invitationMessageBody($userEncodedId);
                $body = new EmailBody($emailBody);
                $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
                $sendEmail = new EmailSender(new PhpMail(new MailConf("smtp.gmail.com", "admin@dispatch.com", "secret-2021")));
                $result = $sendEmail->send($emailMessage);


                return redirect('translate/' . $dreamId);


            } else {
                return redirect()->back()->withErrors("Payment unsuccessfull! Please try again!");

            }
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function userpostlogin(Request $request){
        if (User::where('email', $request->email)->where('password', md5($request->password))->exists()){
            $user = User::where('email', $request->email)->where('password', md5($request->password))->first();
            Session::put('userId', $user->id);
            return redirect('home');
        }else{
            return redirect()->back()->withErrors("Invalid Credentials! Please try again!");
        }
    }

    public function userLogin(){
        return view('user-login');
    }
}
