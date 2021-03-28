@extends('layouts.app')
@section('content')

    <div class="p-4 ml-3">
        <div class="row">
{{--            <div class="col-md-11 mt-2">--}}
{{--                <h2 class="text-center" style="text-decoration: underline">Upcoming Events</h2>--}}
{{--                <h6 class="text-center">(For Next 30 Days)</h6>--}}
{{--            </div>--}}
        </div>
    </div>
    <div class="px-5">
        <div class="row">
                    <div  class="col-xl-3 col-lg-3 order-lg-3 order-xl-2 ml-3" style="color: #646c9a;margin-left: 20px">
                        <div
                            style=";display: flex;flex-grow: 1;flex-direction: column;box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);background-color: #05728f;color: white;margin-bottom: 20px;border-radius: 4px;">
                            <div style="padding: 25px;">
                                <h4 class="text-center" style="text-decoration: underline">Total Translated Dreams</h4>
                                    <div class="mb-3"><h1 class="text-center">{{$totalDreams}}+</h1></div>
                                <div class="row" style="padding: 15px;text-align: center;">
                                    <div style="margin: 0 auto">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




    </div>
@endsection
