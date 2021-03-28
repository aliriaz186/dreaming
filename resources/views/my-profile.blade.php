@extends('layouts.app')
@section('content')

    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-7 mt-2">
                <h2>My Profile</h2>
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
        <form action="{{url('updateprofile')}}" method="post">
            @csrf
            <div>
                <label>Name</label>
                <input class="form-control" name="name" required value="{{$user->name}}">
            </div><br>
            <div>
                <label>Email</label>
                <input disabled class="form-control" name="email" required value="{{$user->email}}">
            </div><br>
            <div>
                <label>New password</label>
                <input class="form-control" name="password" value="">
            </div><br>
            <br>
            <button class="btn btn-success">Update Profile</button>
        </form>
    </div>


@endsection
