@extends('layouts.master2')

@section('content')

<div class="content__wrapper">

<div class="container">

<h2 class="">My History</h2>

<style>
  .test1{
  	position: relative;
  	
  }
  .test{
  	height:300px;
  	background:url(http://wellnesscounselingmilwaukee.com/wp-content/uploads/2015/07/4-Nature-Wallpapers-2014-1.jpg) no-repeat;
  	position: relative;
  	width: 100%;
  	transition: all 3s;
  	//transition: width 2s, height 2s, transform 2s;
  	background-position: center;
  }
  .test:hover{
    cursor:pointer;
    margin-top: -100px;
   // margin-bottom: -500px;
    height: 600px;
  
   background-position: top;
  }

  @keyframes slideme {
  0% {
    height: 350px;
  }
  50% {
    height:450px;
  }
  100% {
    height:650px;
  }

}

  @keyframes slidemeout {
  0% {
    height:650px;
  }
  50% {
    height:450px;
  }
  100% {
    height: 350px;
  }

}
</style>





<div class="list">
   @foreach ($entries as  $index => $entry)
   <div class="list__item">
     <div class="list__actions">
           <a class="list__action" href="/download/{{$entry->id}}">
                <i class="fa fa-download" aria-hidden="true"></i>
                <h4>Download</h4>	
           </a>
           <a class="list__action" href="/results/{{$entry->redis_url}}">
                <i class="fa fa-cog" aria-hidden="true"></i>
                <h4>Redis</h4>	
           </a>
      </div>
      <h4 class="list__title">{{ $entry->filename }}</h4>
      <div class="date__description">{{ $entry->created_at->format('d.m.Y') }}</div>
      <p>
        
        
      </p>
    
     
   </div>
   @endforeach
</div>

<div class="table" style="display:none;">
<table class="table1 table-hover"> 
	<thead> 
		<tr> 
			<th>#</th>
			<th>Filename</th> 
			<th>Created at</th> 
			<th></th> 
			<th></th> 
		</tr> 
	</thead>
	<tbody>  

 @foreach ($entries as  $index => $entry)
 	<tr> 
 		<th scope="row">{{$index}}</th>
 		<td>{{ $entry->filename }}</td> 
 		<td>{{ $entry->created_at }}</td> 
 		<td><a href="/download/{{$entry->id}}">Preuzmi</a></td> 

 		@if ($entry->redis_url)
 		<td><a href="/results/{{$entry->redis_url}}">Servis</a></td> 
 		@else
 		<td>-</td> 
 		@endif 
    </tr>
 @endforeach
 </tbody>
 </table>
 </div>
 </div>
</div>
 @endsection