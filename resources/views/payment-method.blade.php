@extends('layouts.app')
@section('content')

    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-7 mt-2">
                <h2>Card Details</h2>
            </div>
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
        <h3 style="margin-top: 10px">Change Card Details</h3>
        <form action="{{url('updatecarddetails')}}" method="post">
            @csrf
            <div class="row" style="margin-top: 30px">
                <div class="col-md-6">
                    <input type="text" name="cardNumber" id="cardNumber"
                           class="form-control"
                           placeholder="Card number" required>

                </div>
                <div class="col-md-6">
                    <input type="text" name="cvv" id="cvv"
                           class="form-control"
                           placeholder="CVV"  required>
                </div>
            </div>
            <div class="row" style="margin-top: 30px">
                <div class="col-md-6">


                    <select name="year" id="year"
                            class="form-control">
                        <option selected value=''>Exp Year</option>
                        @for($i=2020;$i<=2040;$i++)
                            <option
                                value='{{$i+1}}'>{{$i+1}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-6">
                    <select name="month" id="month"
                            class="form-control">
                        <option selected value=''>Exp Month</option>
                        @for($i=0;$i<12;$i++)
                            <option
                                value='{{$i+1}}'>{{$i+1}}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <br>
            <br>
            <button class="btn btn-success">Update Card Details</button>
        </form>
    </div>


@endsection
