@extends('layouts.master')


@section('script')
<script src="js/jquery.stellar.min.js"></script>
<script>
$(document).ready(function(){
    $('.parallax').stellar({
  scrollProperty: 'transform'
});
});
</script>
@endsection

@section('content')



<div class="home">
   <div class="home__background parallax" data-stellar-ratio="2"
   
     data-stellar-background-ratio="0.5"
     >
       <div class="home__text">
            <h1>{{env('APP_NAME')}}</h1>
            <p>
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.

            </p>
            <div class="action">
             <a class="button primary" href="/register">Sign Up Now!</a>
             </div>
            <div class="arrow bounce">
                <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
            </div>
       </div>
   </div>
</div>


@endsection
