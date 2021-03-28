@extends('layouts.app')
@section('content')

    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-7 mt-2">
                <h2>Payments & Subscription</h2>
            </div>
            @if($user->active == 1)
                <div class="col-md-5 mt-2 row">
                    <div style="float: right;margin-bottom: 10px">
                        <a class="btn btn-danger" href="{{url('/end-subscription/')}}/{{\Illuminate\Support\Facades\Session::get('userId')}}">End Subscription</a>
                    </div>
                </div>
            @elseif($user->active == 0)
                <div class="col-md-5 mt-2 row">
                    <div style="float: right;margin-bottom: 10px">
                        <a class="btn btn-success" href="{{url('/activate-subscription/')}}/{{\Illuminate\Support\Facades\Session::get('userId')}}">Activate Subscription</a>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <div class="px-5"  style="margin-left: 20px">
        @if($errors->any())
            <div class="alert alert-danger">
                <h4 style="color: black;font-size: 14px">{{$errors->first()}}</h4>
            </div>
        @endif
        @if(\Illuminate\Support\Facades\Session::has('msg'))
            <div class="alert alert-success" style="margin-bottom: 0px!important;">
                <h4 style="color: black">{{\Illuminate\Support\Facades\Session::get("msg")}}</h4>
            </div>
        @endif

            @if($user->active == 1)
                <h4 class="alert alert-success">Your Subscription is active! You will be charged next month automatically!</h4>
            @elseif($user->active == 2)
                <h4 class="alert alert-danger">Your Subscription is not active (you cannot translate your dreams anymore) Please try these steps to activate it again!
                <ul>
                    <li>Recharge your card</li>
                    <li>Change your card details <a href="{{url('my-profile')}}">here</a></li>
                    <li>Contact your bank and turn on the online transactions session</li>
                </ul>
                </h4>
            @elseif($user->active == 0)
                <h4 class="alert alert-danger">You have manually ended your subscription.
                </h4>
                    @endif

        <table class="table" id="customer-table">
            <thead style="background: #05728f;color: white">
            <tr>
                <th>#</th>
                <th>Card</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @if(count($paymentHistory) != 0)
                @foreach($paymentHistory as $key => $item)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td class="text-left">{{$user->card}}</td>
                        <td class="text-left">{{$item->amount}}</td>
                        <td class="text-left">{{$item->date}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td></td>
                    <td>No Payment found!</td>
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>


@endsection
