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
                <th >Unread Messages</th>
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
                        <td class="text-left">{{$item->unread}}</td>
                        <td class="text-left">
                            @if($item->newUser == 1)
                                    <button onclick="openModalOfMessage('{{$item->email}}')" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">Start CHAT</button>
                            @else
                                <a href="{{url('/chat-details/'.$item->id)}}">
                                    <button class="btn btn-secondary">OPEN CHAT</button>
                                </a>
                            @endif

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


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Start Chat</h4>
                </div>
                <div class="modal-body">
                    <form action="{{url('startchat')}}" method="post">
                        @csrf
                        <div class="form-group" id="message-template-div">
                            <label>Write message</label><br>
                            <textarea class="form-control" id="open-custom-input" required name="custom_message" placeholder="enter message..."></textarea>
                            <input type="hidden" id="receiver" name="receiver">
                        </div>
                        <button type="submit" class="btn btn-secondary">SEND</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
<script>
    function openModalOfMessage(email) {
        document.getElementById('receiver').value = email;
    }
</script>
@endsection
