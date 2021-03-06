<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Chat;
use App\ChatParent;
use App\Customer;
use App\dreams;
use App\PaymentHistory;
use App\Staff;
use App\User;
use App\WordMeaning;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use services\CSVModal;
use services\email_messages\InvitationMessageBody;
use services\email_messages\UnsubscribeMessage;
use services\email_services\EmailAddress;
use services\email_services\EmailBody;
use services\email_services\EmailMessage;
use services\email_services\EmailSender;
use services\email_services\EmailSubject;
use services\email_services\MailConf;
use services\email_services\PhpMail;
use services\email_services\SendEmailService;
use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDashboard()
    {
        $totalDreams = dreams::where('user_id', Session::get('userId'))->count();
        return view('home')->with(['totalDreams' => $totalDreams]);
    }

    public function myDreams(){
        $dreams = dreams::where('user_id', Session::get('userId'))->latest()->get();
        return view('my-dreams')->with(['dreams' => $dreams]);
    }

    public function deleteDream($id){
        try {
            $dreams = dreams::where('id', $id)->first()->delete();
            session()->flash('msg', 'Dream deleted Successfully!');
            return redirect('my-dreams');
        }catch (\Exception $exception){
            return redirect()->back()->withErrors($exception->getMessage());
        }

    }

    public function addDream(){
        return view('add-dream');
    }

    public function myPayments(){
        $user = User::where('id', Session::get('userId'))->first();
        $paymentHistory = PaymentHistory::where('user_id', Session::get('userId'))->latest()->get();
        return view('my-payments')->with(['user' => $user, 'paymentHistory' => $paymentHistory]);
    }

    public function endSubscription($id){
        $user = User::where('id', Session::get('userId'))->first();
        $user->active= 0;
        $user->update();
        $subject = new SendEmailService(new EmailSubject("Sad to see you go from dreaming123 community!"));
        $mailTo = new EmailAddress($user->email);
        $invitationMessage = new UnsubscribeMessage();
        $emailBody = $invitationMessage->unsubscribeMessageBody();
        $body = new EmailBody($emailBody);
        $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
        $sendEmail = new EmailSender(new PhpMail(new MailConf("smtp.gmail.com", "admin@dispatch.com", "secret-2021")));
        $result = $sendEmail->send($emailMessage);
        $dreams = dreams::where('user_id', $user->id)->get();
        foreach ($dreams as  $dream){
            $dream->delete();
        }
        $user->delete();
        Session::flush();
        return redirect('');
    }

    public function unsubscribe($token){
        $token = JWT::decode($token, 'secret-2021', array('HS256'));
        if (empty($token)){
            return json_encode("Access Denied");
        }
        $user = User::where('id', $token)->first();
        $user->active= 0;
        $user->update();

        $subject = new SendEmailService(new EmailSubject("Sad to see you go from dreaming123 community!"));
        $mailTo = new EmailAddress($user->email);
        $invitationMessage = new UnsubscribeMessage();
        $emailBody = $invitationMessage->unsubscribeMessageBody();
        $body = new EmailBody($emailBody);
        $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
        $sendEmail = new EmailSender(new PhpMail(new MailConf("smtp.gmail.com", "admin@dispatch.com", "secret-2021")));
        $result = $sendEmail->send($emailMessage);
        $dreams = dreams::where('user_id', $user->id)->get();
        foreach ($dreams as  $dream){
            $dream->delete();
        }
        $user->delete();
        Session::flush();
        return $emailBody;
    }

    public function activateSubscription($id){
        $user = User::where('id', Session::get('userId'))->first();
        $user->active= 1;
        $user->update();
        return redirect()->back();
    }

    public function saveDream(Request $request){
        $dream = new dreams();
        $dream->dream = $request->dream;
        $dream->user_id = Session::get('userId');
        $dream->save();
        return redirect('translate/' . $dream->id);
    }
    public function translate($id){
        if (\App\User::where('id',\Illuminate\Support\Facades\Session::get('userId'))->first()['active'] != 1){
            return redirect()->back();
        }

        $dream = dreams::where('id', $id)->first();
        $dreamStr = $dream->dream;
        $dreamStr = str_replace(',', '', $dreamStr);
        $dreamStr = str_replace('.', '', $dreamStr);

        preg_replace("/\b\S{1,3}\b/", "", $dreamStr);
        $dreamStr = preg_split("/\s+/", $dreamStr);
        $wordMeaning = [];
        foreach ($dreamStr as $word){

          if (WordMeaning::where('word', $word)->exists()){
              $index = WordMeaning::where('word', $word)->first();
              array_push($wordMeaning, $index);
          }
          else if (WordMeaning::where('word', strtolower($word))->exists()){
              $index = WordMeaning::where('word', strtolower($word))->first();
              array_push($wordMeaning, $index);
          }
          else if (WordMeaning::where('word', strtoupper($word))->exists()){
              $index = WordMeaning::where('word', strtoupper($word))->first();
              array_push($wordMeaning, $index);
          }
          else if (WordMeaning::where('word', ucfirst($word))->exists()){
              $index = WordMeaning::where('word', ucfirst($word))->first();
              array_push($wordMeaning, $index);
          }

        }
        return view('translate')->with(['dream' => $dream, 'wordMeaning' => $wordMeaning]);
    }


    public function myProfile(){
        $user = User::where('id',Session::get('userId'))->first();
        return view('my-profile')->with(['user' => $user]);
    }

    public function updateprofile(Request $request){
        try {
            $user = User::where('id',Session::get('userId'))->first();
            $user->name = $request->name;
            if (!empty($request->password)){
                $user->password = md5($request->password);
            }
            $user->update();
            session()->flash('msg', 'Profile Updated Successfully!');
            return redirect('my-profile');
        }catch (\Exception $exception){
            return redirect()->back()->withErrors($exception->getMessage());
        }

    }

    public function updatecarddetails(Request $request){
        try {

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
                return redirect()->back()->withErrors("Invalid Card! Please try again!");
            }
            $user = User::where('id',Session::get('userId'))->first();
            $user->card = ($request->cardNumber);
            $user->exp_year = ($request->year);
            $user->exp_month = ($request->month);
            $user->cvv = ($request->cvv);
            $user->update();
            session()->flash('msg', 'Card Updated Successfully!');
            return redirect('payment-method');
        }catch (\Exception $exception){
            return redirect()->back()->withErrors($exception->getMessage());
        }

    }

    public function paymentMethod(){
        return view('payment-method');
    }

    public function contactUsers(){
        $users = User::where('id','!=',Session::get('userId'))->get();
        foreach ($users as $user){
            $user->newUser = 1;
            if (Chat::where('sender', $user->email)->orWhere('receiver', $user->email)->exists()){
                $user->newUser = 0;
            }
            $user->unread = Chat::where('sender', $user->email)->where('status', 0)->count();
        }
        return view('contact-users')->with(['users' => $users]);
    }

    public function startchat(Request $request){
        $chat = new Chat();
        $chat->sender = User::where('id', Session::get('userId'))->first()['email'];
        $chat->receiver = $request->receiver;
        $chat->message = $request->custom_message;
        $chat->save();
        $receiverId = User::where('email', $request->receiver)->first()['id'];
        return redirect('chat-details/' . $receiverId);
    }

    public function sendMessage(Request $request){
        $chat = new Chat();
        $chat->sender = User::where('id', Session::get('userId'))->first()['email'];
        $chat->receiver = $request->receiver;
        $chat->message = $request->message;
        $chat->save();
        return redirect('chat-details/');
    }

    public function chatDetails(){
        $me = User::where('id', Session::get('userId'))->first();
        $myEmail = $me['email'];


        $chat = Chat::where('id','>',0)->get();
        return view('chat-details')->with(['chat' => $chat, 'myEmail' => $myEmail]);

    }

    public function import(Request $request){
        set_time_limit(360000);
        $csvModal = new CSVModal();
        \Excel::import($csvModal, request()->file('select_file'));
        $dataList = $csvModal->getData();
        foreach ($dataList as $data) {
            $Letter = explode("-", $data['name']);
            $wordMeaning = new WordMeaning();
            $wordMeaning->word =  $Letter[0];
            $wordMeaning->meaning =  $Letter[1];
            $wordMeaning->save();
        }
        return json_encode(['status' => true, 'message' => 'Excel Data Imported successfully.']);
    }
}
