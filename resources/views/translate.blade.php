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
            <table class="table" id="customer-table">
                <thead style="background: #05728f;color: white">
                <tr>
                    <th>Word</th>
                    <th>Meaning</th>
                </tr>
                </thead>
                <tbody>
                @if(count($wordMeaning) != 0)
                    @foreach($wordMeaning as $key => $item)
                        <tr>
                            <td class="text-left">{{$item->word}}</td>
                            <td class="text-left">{{$item->meaning}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No Translation found!</td>
                        <td></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>


@endsection
