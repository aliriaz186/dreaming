@extends('layouts.app')
@section('content')

    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-7 mt-2">
                <h2>Translate New Dream</h2>
            </div>
        </div>
    </div>

    <div class="px-5"  style="margin-left: 20px">
        <form action="{{url('save-dream')}}" method="post">
            @csrf
            <textarea class="form-control" style="height: 250px;" name="dream" required placeholder="Write your dream..."></textarea>
            <br>
            <button class="btn btn-success">Translate</button>
        </form>
    </div>


@endsection
