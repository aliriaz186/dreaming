@extends('layouts.landing')
@section('content')
    <style>
        .first-bg {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;;
            height: 900px;
            background-repeat: no-repeat;
            background: #0d1c9a;
            padding: 35px;
        }

        .second-bg {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;;
            /*height: 900px;*/
            background-repeat: no-repeat;
            background: #0d1c9a;
            padding: 35px;
        }

        .third-bg {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;;
            height: 2000px;
            background-repeat: no-repeat;
            background: #0d1c9a;
            padding: 35px;
        }

        .fourth-bg {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;;
            height: 1200px;
            background-repeat: no-repeat;
            background: #0d1c9a;
            padding: 35px;
        }

        .blue-color {
            color: #39c0de;
        }

        .grey-color {
            color: grey;
        }

        .font-size-small {
            font-size: 18px;
        }
        .left-section{
            flex: 1 0 250px;
            padding: 15px;

        }
        .middle-section{
            flex: 1 0 100px;
            padding: 15px;
        }
        .right-section{
            flex: 1 0 250px;
            padding: 15px;
            margin-top: 40px;
        }
        .main-content{
            display: flex;
            flex-wrap: wrap;
            margin: 0 auto;
            max-width: 800px;
        }
        .myinput{
            background: #0d1c9a!important;
            border: none;
            border-bottom: 1px solid lightgrey;
        }

    </style>



    <div class="fourth-bg">

        <div style="margin: 0 auto;max-width: 800px;margin-top: 50px;">
            <div>
                @if($errors->any())
                    <div class="alert alert-danger">
                        <h4>{{$errors->first()}}</h4>
                    </div>
                @endif
                <form method="post" action="{{url('userlogin')}}">
                    @csrf
                    <h3 style="text-align: center;" class="blue-color">Login</h3>
                    <div class="row" style="margin-top: 30px">
                        <div class="col-md-6">
                            <input style=";color: white" type="email" class="form-control myinput" name="email" placeholder="Email" required>
                        </div>
                        <div class="col-md-6">
                            <input style=";color: white" type="password" class="form-control myinput" placeholder="password" name="password" required>
                        </div>
                    </div>




                    <div style="margin: 0 auto;max-width: 200px;margin-top: 35px">
                        <button type="submit" style="padding: 20px;border: 1px solid #39c0de;background: #0d1c9a;font-weight: bold" class="blue-color">LOGIN</button>
                        <br>
                        <br>
                        <span style="color: lightgrey">New Member?</span><a href="{{url('')}}#translatedream" style="color: white"> Register here!</a>
                    </div>
                </form>

            </div>

        </div>


@endsection
