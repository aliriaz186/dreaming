@extends('layouts.landing')
@section('content')
    <style>
        .first-bg {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;;
            height: 900px;
            background-repeat: no-repeat;
            background-image: url('images/Use this 1.png');
            padding: 35px;
        }

        .second-bg {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;;
            /*height: 900px;*/
            background-repeat: no-repeat;
            background-image: url('images/Use this 2.png');
            padding: 35px;
        }

        .third-bg {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;;
            height: 2000px;
            background-repeat: no-repeat;
            background-image: url('images/Use this 3.png');
            padding: 35px;
        }

        .fourth-bg {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;;
            height: 1000px;
            background-repeat: no-repeat;
            background-image: url('images/Use this 4.png');
            padding: 35px;
        }

        .blue-color {
            color: #39c0de;
        }

        .grey-color {
            color: #D3D3D3;
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
        .href-color{
            color: white;
            font-size: 18px;
        }
        .href-color:hover{
            color: white!important;
        }
        .circle {
            /*margin: 0 auto;*/
            /*max-width: 500px;*/
            /*width: 500px;*/
            /*height: 500px;*/
            /*margin-top: -200px;*/
            /*!*line-height: 500px;*!*/
            /*border-radius: 50%;*/
            /*!*font-size: 50px;*!*/
            /*color: #fff;*/
            /*text-align: center;*/
            /*background: transparent;*/
            /*border: 2px solid white;*/
        }
        .fa {
            padding: 12px;
            font-size: 15px;
            width: 40px;
            text-align: center;
            text-decoration: none;
            margin: 5px 2px;
            border-radius: 50%;
        }

        .fa:hover {
            /*opacity: 0.7;*/
            color: white!important;
            text-decoration: none;
        }

        .fa-facebook {
            background: #3B5998;
            color: white;
        }

        .fa-twitter {
            background: #55ACEE;
            color: white;
        }

        .fa-google {
            background: #dd4b39;
            color: white;
        }

        .fa-linkedin {
            background: #007bb5;
            color: white;
        }

        .fa-youtube {
            background: #bb0000;
            color: white;
        }

        .fa-instagram {
            background: #125688;
            color: white;
        }

        .fa-pinterest {
            background: #cb2027;
            color: white;
        }

        .fa-snapchat-ghost {
            background: #fffc00;
            color: white;
            text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
        }

        .fa-skype {
            background: #00aff0;
            color: white;
        }

        .fa-android {
            background: #a4c639;
            color: white;
        }

        .fa-dribbble {
            background: #ea4c89;
            color: white;
        }

        .fa-vimeo {
            background: #45bbff;
            color: white;
        }

        .fa-tumblr {
            background: #2c4762;
            color: white;
        }

        .fa-vine {
            background: #00b489;
            color: white;
        }

        .fa-foursquare {
            background: #45bbff;
            color: white;
        }

        .fa-stumbleupon {
            background: #eb4924;
            color: white;
        }

        .fa-flickr {
            background: #f40083;
            color: white;
        }

        .fa-yahoo {
            background: #430297;
            color: white;
        }

        .fa-soundcloud {
            background: #ff5500;
            color: white;
        }

        .fa-reddit {
            background: #ff5700;
            color: white;
        }

        .fa-rss {
            background: #ff6600;
            color: white;
        }
    </style>
    <div class="first-bg">
{{--       <a href="{{url('')}}"> <h2 class="blue-color" style="position:fixed;">Your Dream is here</h2></a>--}}
        @if(\Illuminate\Support\Facades\Session::has('userId'))
            <a class="href-color" href="{{url('home')}}" style="float: right;">Dashboard</a>
        @else
            <a class="href-color" href="{{url('user-login')}}" style="float: right;">Login</a>
        @endif
        <div style="margin-top: 250px" class="circle">
            <h1 class="blue-color" style="text-align: center;font-size: 60px">Allow your Dreams</h1>
            <h1 class="blue-color" style="text-align: center;font-size: 60px">to</h1>
            <h1 class="blue-color" style="text-align: center;font-size: 60px">become Real!</h1>
        </div>
    </div>

    <div class="second-bg">
        <div style="margin-top: 25px">
            <h3 style="text-align: center;color: white">...Have you ever woken up and think to your self</h3>
            <h3 style="text-align: center;color: white"> what was that dream about... ?</h3>
            <h3 style="text-align: center;" class="grey-color">Or have you had a really horrible nightmare and
                never</h3>
            <h3 style="text-align: center;" class="grey-color"> knew what was that all about...?</h3>
            <div style="margin: 0 auto;max-width: 500px;margin-top: 50px">
                <h6 style="text-align: right;" class="grey-color font-size-small">... Dreams can be a </h6>
                <h6 style="text-align: right;" class="grey-color font-size-small">useful tool for</h6>
                <h6 style="text-align: right;" class="grey-color font-size-small"> problem solving ... </h6>
            </div>
            <div style="margin: 0 auto;max-width: 500px">
                <h1 style="color: white;font-size: 40px">63%</h1>
                <h6 class="grey-color font-size-small"> Dreams Predict Future </h6>
            </div>
            <h1 style="text-align: center;margin-top: 100px" class="grey-color">*WE ALL DREAM*</h1>
            <h1 style="text-align: center;margin-top: 100px" class="blue-color">REAL</h1>
            <h1 style="text-align: center;margin-top: 5px" class="blue-color">STORIES</h1>

        </div>
    </div>
    <div class="third-bg">
        <div style="margin-top: 25px">
            <div style="margin: 0 auto;max-width: 10px">
                <div style="height: 10vh;border-left: 5px dotted #39c0de"></div>
            </div>
            <div class="main-content">
                <div class="left-section">
                    <h3 style="border-bottom: 5px solid #39c0de;color: white;width: 180px">RELATIONSHIP</h3>
                    <h4 style="color: white;margin-top: 15px">I had a dream about flying </h4>
                    <h4 style="color: white"> ducks, and I had no idea why</h4>
                    <h4 style="color: white"> would I dream that, but then I </h4>
                    <h4 style="color: white">look up what means "Ducks"  </h4>
                    <h4 style="color: white">and it all made sense.</h4>
                    <h4 style="color: white;margin-top: 25px">Thank you so much, this site  </h4>
                    <h4 style="color: white">has changed my life.</h4>
                    <h4 style="color: white">Emma</h4>
                </div>
                <div class="left-section">

                </div>
                <div class="right-section">
                    <h3 style="border-bottom: 5px solid #39c0de;color: white">MONEY</h3>
                    <h4 style="color: white;margin-top: 15px">My dream was so strange...
                    </h4>
                    <h4 style="color: white">I was on vacation and was
                    </h4>
                    <h4 style="color: white"> riding an elephant....  </h4>
                    <h4 style="color: white">In real life I would never ride   </h4>
                    <h4 style="color: white">an elephant, but meaning of</h4>
                    <h4 style="color: white;"> vacation and the elephant is   </h4>
                    <h4 style="color: white">unexpected gain, a gift, and </h4>
                    <h4 style="color: white">wealth.
                    </h4><h4 style="color: white">In a couple of days I got
                    </h4><h4 style="color: white">promotion and much bigger
                    </h4>
                    <h4 style="color: white">pay slip, and my team gave
                    </h4>
                    <h4 style="color: white">me a wonderful gift.

                    </h4>
                    <h4 style="color: white">Claire

                    </h4>
                </div>
            </div>

            <div class="main-content">
                <div class="left-section" style="margin-left: 40px;margin-top: -150px; flex: 1 0 300px;">
                                        <h3 style="border-bottom: 5px solid #39c0de;color: white;width: 180px">MY DREAM CAME TRUE</h3>
                                        <h4 style="color: white;margin-top: 15px">Today I woke and the first  </h4>
                                        <h4 style="color: white"> thing I did was open this site </h4>
                                        <h4 style="color: white"> on my phone. I was looking to  </h4>
                                        <h4 style="color: white">see what my dream was telling  </h4>
                                        <h4 style="color: white">me.
                                        </h4>
                                        <h4 style="color: white;margin-top: 25px"> In my dream I was at the train  </h4>
                                        <h4 style="color: white"> station waiting for a train, but</h4>
                                        <h4 style="color: white"> it never came so I left a </h4>
                                        <h4 style="color: white"> station...
                                        </h4>
                                        <h4 style="color: white">  For my interpretation this </h4>
                                        <h4 style="color: white">  dream means I will have  </h4>
                                        <h4 style="color: white"> unexpected happy news and  </h4>
                                        <h4 style="color: white"> financial gain.
                                        </h4>
                                        <h4 style="color: white">  The same day, I got a call from  </h4>
                                        <h4 style="color: white">my friend and he had a </h4>
                                        <h4 style="color: white"> business idea and if I am  </h4>
                                        <h4 style="color: white"> interested he would like me to   </h4>
                                        <h4 style="color: white"> be a partner, to be honest, the  </h4>
                                        <h4 style="color: white"> idea was amazing and it did  </h4>
                                        <h4 style="color: white"> not take me long to say YES
                                        </h4>
                                        <h4 style="color: white"> My dream really came true!
                                        </h4>
                                        <h4 style="color: white"> James Oliver
                                        </h4>
                </div>
                <div class="left-section">

                </div>
                <div class="right-section">

                </div>
            </div>

            <div style="margin: 0 auto;max-width: 1000px;margin-top: 100px;">
                <div>
                    <h3 style="text-align: center;color: white">HOW IT WORKS</h3>
                    <h4 style="color: white;margin-top: 25px">You start by describing your dream. </h4>
                    <h4 style="color: white"> Example-I received big salary, and I went to store and bought many things on sale. </h4>
                    <h4 style="color: white"> In this description there is key words, what have interpretations, key words are SALARY, STORE, SALE.   </h4>
                    <h4 style="color: white">These words are important whey are ones that make your dream into a story.  </h4>
                    <h4 style="color: white">Example-SALE means, financial increase, gift and wealth etc.
                    </h4>
                    <h4 style="color: white;margin-top: 25px"> From interpretations you begin to create your own story, you take only what resonates with you at this time in your life. </h4>
                    <h4 style="color: white"> Dreams tell you what you really feel, or will soon have.</h4>
                    <h4 style="color: white"> Some words can be in different synonyms as a key word. </h4>
                </div>


            </div>




        </div>
    </div>


    <div class="fourth-bg" id="translatedream">

        <div style="margin: 0 auto;max-width: 800px;margin-top: 200px;">
            <div>
                <h3 style="text-align: center;" class="blue-color">TYPE YOUR DREAM</h3>
                <h3 style="text-align: center;" class="blue-color">BELOW</h3>
                <form method="post" action="{{url('/open-payment')}}">
                    @csrf
                    <textarea class="form-control" style="height: 400px;margin-top: 20px;margin-bottom: 20px;padding: 15px;background: #a9dbff" name="dream" placeholder="Write your dream here.." required></textarea>
                    <div style="margin: 0 auto;max-width: 200px">
                        <button style="padding: 20px;border: 1px solid #39c0de;background: #0d1c9a" class="blue-color">Translate Your Dream</button>
                    </div>
                </form>
            </div>


        </div>
    </div>

    <div class="fourth-bg">

        <div style="margin: 0 auto;max-width: 800px;margin-top: 200px;">
            <div>
                <form method="post" action="{{url('send-email')}}">
                    @csrf
                    <h3 style="text-align: center;" class="blue-color">CONTACT</h3>
                    <div class="row" style="margin-top: 30px">
                        <div class="col-md-6">
                            <input style=";color: white" type="text" class="form-control myinput" name="name" placeholder="Name" required>
                        </div>
                        <div class="col-md-6">
                            <input style=";color: white" type="email" class="form-control myinput" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 30px">
                        <div class="col-md-12">
                            <input style=";color: white" type="text" class="form-control myinput" placeholder="Subject" name="subject" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 30px">
                        <div class="col-md-12">
                            <textarea class="form-control myinput" style="height: 200px;margin-top: 20px;margin-bottom: 20px;padding: 15px;color: white" placeholder="Message" name="message" required></textarea>
                        </div>
                    </div>
                    <div style="margin: 0 auto;max-width: 200px">
                        <button type="submit" style="padding: 20px;border: none;background: #0d1c9a;font-weight: bold" class="blue-color">SUBMIT</button>
                    </div>
                </form>

            </div>


        </div>
    </div>
    <div style="background: #0d1c9a ">
        <div style="padding: 30px;margin: 0 auto;max-width: 350px">
            <a href="#" class="fa fa-facebook"></a>
            <a href="#" class="fa fa-twitter"></a>
            <a href="#" class="fa fa-snapchat-ghost"></a>
            <a href="#" class="fa fa-instagram"></a>
            <a href="#" class="fa fa-pinterest"></a>
            <a href="#" class="fa fa-reddit"></a>
        </div>
    </div>



@endsection
