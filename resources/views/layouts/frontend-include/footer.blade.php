<?php 
$Pages = DB::table('pages')->select('id','title')->whereNull('parent')->get();
?>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-sm-9">

				<ul class="footer-link">
				<li><a href="/">Home Page</a></li>
                     @foreach($Pages as $page)
                <li><a href="{{url('page/').'/'.$page->id}}" > {{ $page->title }}</a></li>
   
                @endforeach 
				<li><a href="contact">Contact Us</a></li>
				    </ul>
				<p class="copyright hidden-xs">
					Copyright 2019, N&S CLEANING SERVICES. All Rights Reserved.   
				</p>
			</div>
			<div class="col-md-3 col-sm-3">
				<div class="footer-right">
					<ul>
						<li><b>NSW - SYDNEY</b>
						<span>79-81 Lane street Wentworthville</span>
							<span>Tel : 0426 431 646</span>
							
						</li>
						
					</ul>
					<h4>Follow Us</h4>
					<ul class="footer-social-link">
						<li><a href="https://www.facebook.com/nandssuperiorcleaningservices/"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
						<li><a href="#"><i class="fa fa-youtube"></i></a></li>
						<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
					</ul>
					<p class="copyright visible-xs">
					Copyright 2018, INCEPTION MEDIA, Inc. All Rights Reserved.    <a href="privacypolicy.html">Privacy Policy</a>
				</p>
				</div>
			</div>
		</div>
		
	</div>	
</footer>