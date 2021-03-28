@extends('layouts.app')
@section('content')

    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-7 mt-2">
                <h2>My Dreams</h2>
            </div>
            <div class="col-md-5 mt-2 row">
                <div style="float: right;margin-bottom: 10px">
                    <a class="btn btn-primary" href="{{url('/add-dream')}}">+ Translate New Dreams</a>
                </div>
            </div>
        </div>
    </div>

    <div class="px-5"  style="margin-left: 20px">
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
                                        <a href="{{url('/translate/'.$item->id)}}">
                                            <button class="btn btn-secondary">Translate</button>
                                        </a>
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
