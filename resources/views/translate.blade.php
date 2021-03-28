@extends('layouts.app')
@section('content')

    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-7 mt-2">
                <h2>Dream : {{$dream->dream}}</h2>
            </div>
        </div>
    </div>

    <div class="px-5"  style="margin-left: 20px">
        <div>
            <h3>Translation:</h3>
        </div>
    </div>


@endsection
