@extends('layouts.app')
@section('content')
    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-7 mt-2">
                <h2>Contact Users</h2>
            </div>
        </div>
    </div>

    <div class="px-5"  style="margin-left: 20px">
        <table class="table" id="customer-table">
            <thead style="background: #05728f;color: white">
            <tr>
                <th>#</th>
                <th >Name</th>
                <th >Email</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
            @if(count($users) != 0)
                @foreach($users as $key => $item)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td class="text-left">{{$item->name}}</td>
                        <td class="text-left">{{$item->email}}</td>
                        <td class="text-left">
                            <a href="{{url('/open-chat/'.$item->id)}}">
                                <button class="btn btn-secondary">OPEN CHAT</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td></td>
                    <td>No Users found!</td>
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>


@endsection
