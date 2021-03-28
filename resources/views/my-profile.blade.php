@extends('layouts.app')
@section('content')

    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-7 mt-2">
                <h2>My Dream</h2>
            </div>
        </div>
    </div>

    <div class="px-5"  style="margin-left: 20px">
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
                <input class="form-control" name="password" required value="">
            </div><br>
            <br>
            <button class="btn btn-success">Update Profile</button>
        </form>
    </div>


@endsection
