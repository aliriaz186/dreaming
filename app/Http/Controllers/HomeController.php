<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Chat;
use App\ChatParent;
use App\Customer;
use App\dreams;
use App\Staff;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
        $dreams = dreams::where('id', $id)->first()->delete();
        return redirect('my-dreams');
    }

    public function addDream(){
        return view('add-dream');
    }

    public function saveDream(Request $request){
        $dream = new dreams();
        $dream->dream = $request->dream;
        $dream->user_id = Session::get('userId');
        $dream->save();
        return redirect('translate/' . $dream->id);
    }
    public function translate($id){
        $dream = dreams::where('id', $id)->first();
        return view('translate')->with(['dream' => $dream]);
    }


    public function myProfile(){
        $user = User::where('id',Session::get('userId'))->first();
        return view('my-profile')->with(['user' => $user]);
    }

    public function updateprofile(Request $request){
        $user = User::where('id',Session::get('userId'))->first();
        $user->name = $request->name;
        if (!empty($request->password)){
            $user->password = md5($request->password);
        }
        $user->update();
        return redirect('my-profile');
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
}
