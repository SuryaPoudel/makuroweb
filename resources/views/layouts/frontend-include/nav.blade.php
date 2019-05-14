<?php 
$Pages = DB::table('pages')->select('id','title')->whereNull('parent')->get();
?>
<div class="fullmenu" id="fullmenu">
        <div class="inner-container">
            <div class="inner-logo"> <img src="/inspection/img/logo1.png" alt="Inception Innovation"> </div>
            <ul class="inner-navbar">
                <li><a href="/">Home</a></li>
                @foreach($Pages as $page)
                <li><a href="{{url('page/').'/'.$page->id}}" > {{ $page->title }}</a></li>
   
                @endforeach
                <li><a href="contact">Contact Us</a></li>
            </ul>
            <div class="social-link">
                <h4>Follow Us</h4>
                <ul>
                    <li><a href="https://www.facebook.com/nandssuperiorcleaningservices/"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
</div>