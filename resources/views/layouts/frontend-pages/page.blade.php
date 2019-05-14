<?php 
$Content = DB::table('pages')->select('description','title')->where('id',request()->route('id'))->get();

?>
@extends('index')
@section('content')
<section class="page-top mt20">
	<div class="container">
    @foreach($Content as $ct)
		<h2>{{$ct->title}}</h2>
        @endforeach
	</div>
</section>
<!--====================
Innerpage Start 
=====================-->
<section class="innerpage">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb10 mt10">
                <div >
                @foreach($Content as $content)
                 <?php echo $content->description; ?>
                @endforeach
                </div>

               
                </div>
            </div>
           
        </div>
    </div>
    
</section>
<!--====================
Team Start 
=====================-->

@endsection