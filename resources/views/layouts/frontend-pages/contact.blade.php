
@extends('index')
@section('content')
<section class="page-top mt20">
	<div class="container">
    
		<h2>Contact Us</h2>
       
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
                <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="contact-box"> 
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="contact-box"> <i class="contact-icon"><img src="img/jeddha.png" alt=""></i>
                    <h4>NSW - SYDNEY</h4>
                    <ul>
                        <li><b>Office:</b>79-81 Lane street Wentworthville</li>
                        <li><b>Tel:</b>0426 431 646</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="contact-box"> 
                </div>
            </div>
        </div>
                </div>

                <div>
             
                <div class="contact-form mt50">
			<div class="title text-center">
            <h4 class="mt5 text-normal">Fill in your details and get in touch with us!</h4>
        </div>
            <form class="row mt30" action="#">
                <div class="form-group col-md-6">
                    <label for="name">Your Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email">
                </div>
               
                <div class="form-group col-md-12">
                    <label for="phone-number">Phone Number</label>
                    <input type="text" class="form-control" id="phone-number">
                </div>
                <div class="form-group col-md-12">
                    <label for="message">Message</label>
                    <textarea class="form-control" rows="5" id="message"></textarea>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn solid-btn">Send Message</button>
                </div>
            </form>
          
        </div>
                </div>
            </div>
           
        </div>
    </div>
    
</section>
<!--====================

@endsection