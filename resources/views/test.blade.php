@extends('layouts.app')

@section('content')
   <div class="container">
    <p id="power">0</p>
    <div id="message"></div>
    </div>
@stop

@section('footer')
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://utility.dev:3000');
        socket.on("test-channel:App\\Events\\EventName", function(message){
            
            $('#message').append('<div>'+message.data.message + message.data.power+'</div>');
            // increase the power everytime we load test route
            $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        });
         socket.on("test-channel:EventName", function(message){
            
            $('#message').append('<div>Zavrsio sam generiranje excela '+message.data.message + message.data.power+'</div>');
            // increase the power everytime we load test route
            $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        });
    </script>
@stop