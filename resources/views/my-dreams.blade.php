@extends('layouts.app')
@section('content')
    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-7 mt-2">
                <h2>My Dreams</h2>
            </div>
            @if(\App\User::where('id',\Illuminate\Support\Facades\Session::get('userId'))->first()['active'] == 1)
            <div class="col-md-5 mt-2 row">
                <div style="float: right;margin-bottom: 10px">
                    <a class="btn btn-primary" href="{{url('/add-dream')}}">+ Translate New Dreams</a>
                </div>
            </div>
            @else
                <div class="col-md-5 mt-2 row">
                    <div style="float: right;margin-bottom: 10px">
                        <a disabled="disabled" class="btn btn-primary" href="#">+ Translate New Dreams</a>
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
        <table class="table" id="customer-table">
            <thead style="background: #05728f;color: white">
            <tr>
                <th>#</th>
                <th >Dream</th>
                <th>Options</th>
            </tr>
            </thead>
                        <tbody>
                        @if(count($dreams) != 0)
                            @foreach($dreams as $key => $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td class="text-left">{{$item->dream}}</td>
                                    <td class="text-left">
                                        @if(\App\User::where('id',\Illuminate\Support\Facades\Session::get('userId'))->first()['active'] == 1)
                                            <a href="{{url('/translate/'.$item->id)}}">
                                                <button class="btn btn-secondary">Translate</button>
                                            </a>
                                        @else
                                            <a href="#">
                                                <button class="btn btn-secondary" disabled>Translate</button>
                                            </a>
                                        @endif


                                        <a href="{{url('/delete-dream/'.$item->id)}}">
                                            <button class="btn btn-danger">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td></td>
                                <td>No Dreams found!</td>
                                <td></td>
                            </tr>
                        @endif
                        </tbody>
        </table>
    </div>


@endsection
