@extends('layouts.app')

@section('content')


<div class="about-section container">
   <div class="row">
     <div class="col-md-12 ">
<ol class="breadcrumb">
  <li><a href="/home">Home</a></li>
  <li class="active">Upload</li>
 
</ol>

        @if(Session::has('success'))
          <div class="alert alert-success" role="alert"> 
             <strong>Well done!</strong> 
             {!! Session::get('success') !!}
          </div>
        @endif

          @if(Session::has('error'))
          <div class="alert alert-danger" role="alert"> 
             <strong>Oh snap!</strong> 
             {!! Session::get('error') !!}
          </div>
        @endif

<div class="list-group">

  <div   class="list-group-item active" id="proccess-result" style="display:none">
    <h4 class="list-group-item-heading">Servis</h4>
    <div class="list-group-item-text" >
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum arcu magna, venenatis quis ante in, auctor rutrum turpis. Sed ac libero porta, laoreet neque in, laoreet dolor. Praesent eu porttitor enim. In dapibus imperdiet mi, ac sodales dolor auctor ut. Mauris vitae pretium nunc. Praesent eget ultrices nulla. Aenean viverra imperdiet purus, eget convallis leo semper id.

       <div class="row">
            <div class="col-md-9" id="message">
               

            </div>
            <div class="col-md-3">
              
                <a href="#" class="btn btn-primary btn-block" id="link-to-results">Pogledaj rezultate</a>
              
            </div>            

    </div>
  </div>
  </div>


  <a href="/download"  class="list-group-item active1">
    <h4 class="list-group-item-heading">Preuzmi Template</h4>
    <p class="list-group-item-text">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum arcu magna, venenatis quis ante in, auctor rutrum turpis. Sed ac libero porta, laoreet neque in, laoreet dolor. Praesent eu porttitor enim. In dapibus imperdiet mi, ac sodales dolor auctor ut. Mauris vitae pretium nunc. Praesent eget ultrices nulla. Aenean viverra imperdiet purus, eget convallis leo semper id.

    </p>
  </a>

  <div href="/download"  class="list-group-item active1">
    <h4 class="list-group-item-heading">Upload Template</h4>
    <p class="list-group-item-text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum arcu magna, venenatis quis ante in, auctor rutrum turpis. Sed ac libero porta, laoreet neque in, laoreet dolor. Praesent eu porttitor enim. In dapibus imperdiet mi, ac sodales dolor auctor ut. Mauris vitae pretium nunc. Praesent eget ultrices nulla. Aenean viverra imperdiet purus, eget convallis leo semper id.
            </p>
            <form action="upload" method="post" enctype="multipart/form-data" class="form-horizontal">
             {!! csrf_field() !!}
            
            <div class="row">
            <div class="col-md-9">
               <div class="form-group {{ $errors->has('file') ? ' has-error' : '' }}"  >
                 <label for="uploadFile" class="col-sm-2 control-label">Datoteka</label>
                  <div class="col-sm-10">
                    <input type="file" name="file" id="uploadFile" class="form-control">
                    <p class="help-block">{!!$errors->first('file')!!}</p>
                 </div>
                
             
              </div>

            </div>
            <div class="col-md-3">
              
                <button type="submit" class="btn btn-default btn-block">Upload</button>
              
            </div>            
          </form>
    </p>
  </div>
</div>




      </div>
   </div>
</div>
@endsection



@section('footer')
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://utility.dev:3000');
        socket.on("test-channel:App\\Events\\ExcelImportWasDone", function(message){
            console.log(message);
            $proces = $('#proccess-result');
            $proces.show();
            $proces.css('display','block');
            $message = $('#message');
            $message.html(message.data.message);
            $link = $('#link-to-results');
            $link.attr('href',message.data.link);
            // increase the power everytime we load test route
            
        });

    </script>
@stop