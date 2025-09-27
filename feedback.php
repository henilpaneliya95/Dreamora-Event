<?php
include("header.php");
?>
<!-- start contact -->
<section id="contact">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="wow bounceIn" data-wow-offset="50" data-wow-delay="0.3s">Feed<span> Back </span></h2>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12 wow fadeInLeft" data-wow-offset="50" data-wow-delay="0.9s">
				<form action="feedbackdata.php" method="post">
					<label>NAME</label>
					<input name="fullname" type="text" class="form-control" id="fullname" required>
					
					<label>EMAIL</label>
					<input name="email" type="email" class="form-control" id="email" required>
					
					<label>MESSAGE</label>
					<textarea style="color: white;" name="message" rows="4" class="form-control" id="message" required></textarea>
					
					<!-- ⭐ Rating Section -->
					<label>RATE OUR SERVICE</label>
					<div class="star-rating">
						<input type="radio" id="star5" name="rating" value="5" required/><label for="star5" title="5 stars">★</label>
						<input type="radio" id="star4" name="rating" value="4"/><label for="star4" title="4 stars">★</label>
						<input type="radio" id="star3" name="rating" value="3"/><label for="star3" title="3 stars">★</label>
						<input type="radio" id="star2" name="rating" value="2"/><label for="star2" title="2 stars">★</label>
						<input type="radio" id="star1" name="rating" value="1"/><label for="star1" title="1 star">★</label>
					</div>
					
					<br>
					<input type="submit" class="form-control btn btn-primary" value="Submit Feedback">
				</form>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12 wow fadeInRight" data-wow-offset="50" data-wow-delay="0.6s">
				<address>
					<p class="address-title">OUR ADDRESS</p>
					<p><i class="fa fa-phone"></i> +91 6360177263</p>
					<p><i class="fa fa-envelope-o"></i> deramora16@gmail.com</p>
					<p><i class="fa fa-map-marker"></i> 6City Bright Building, Mangalore, 579211</p>
				</address>
				<ul class="social-icon">
					<li><h4>WE ARE SOCIAL</h4></li>
					<li><a href="#" class="fa fa-facebook"></a></li>
					<li><a href="#" class="fa fa-twitter"></a></li>
					<li><a href="#" class="fa fa-instagram"></a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<!-- end contact -->

<style>
/* ⭐ Star Rating CSS */
.star-rating {
  direction: rtl;
  display: inline-flex;
}
.star-rating input {
  display: none;
}
.star-rating label {
  font-size: 30px;
  color: #ccc;
  cursor: pointer;
  padding: 5px;
}
.star-rating input:checked ~ label {
  color: gold;
}
.star-rating label:hover,
.star-rating label:hover ~ label {
  color: orange;
}
</style>

<?php
include("footer.php");
?>
