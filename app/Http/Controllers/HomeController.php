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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use services\CSVModal;
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
//        $thirtyDays = date("Y-m-d", strtotime("+32 days"));
//        $eventsList = Event::where('user_id', Auth::user()->id)->where('start', '<' ,$thirtyDays)->where('start', '>=' ,date("Y-m-d"))->get();
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
        return redirect()->back();
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

    public function chatDetails($id){
        $chat = Chat::where('id_chat', $id)->get();
        foreach ($chat as $item)
        {
            if($item->status == 0)
            {
                $item->status = 1;
                $item->update();
            }
        }
        $chatMembers = Chat::where('id_chat', $id)->distinct()->get(['sender']);
        $customerNumber = ChatParent::where('id', $id)->first()['number'];
        $customerName = Customer::where('number', $customerNumber)->first()['name'];
        return view('chat-details')->with(['customerNumber' => $customerNumber,'customerName' => $customerName,'chatMembers' => $chatMembers, 'chats' => Chat::where('id_chat', $id)->get(), 'parentId' => $id]);
    }


    public function paymentMethod(){
        return view('payment-method');
    }

    public function sendSMS($parentId, Request $request){
        $number = ChatParent::where('id', $parentId)->first()['number'];
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($number,
            ['from' => $twilio_number, 'body' => $request->message] );

        $chat = new Chat();
        if (!empty(Session::get('isAdmin'))){
            $chat->sender = Admin::where('id', Session::get('id'))->first()['email'];
        }
        else {
            $chat->sender = Staff::where('id', Session::get('id'))->first()['name'];
        }

        $chat->message = $request->message;
        $chat->id_chat = $parentId;
        $chat->save();
        return redirect()->back();
    }

    public function icomingSms(Request $request){
        try {
            $chatParentId = ChatParent::where('number', $request->From)->first()['id'];
            $chat = new Chat();
            $chat->sender = $request->From;
            $chat->message = $request->Body;
            $chat->id_chat = $chatParentId;
            $chat->status = 0;
            $chat->ping_status = 0;
            $chat->save();
            print "<Response></Response>";
        }catch (\Exception $exception){
            print "<Response></Response>";
        }

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
