<?php include_once("roguelytics_header.php"); ?>
<div class="roguelytics_signup_container">
	<ul class="tab_select">
		<li class="active">Sign Up</li>
		<li>Sign In</li>
	</ul>
	<ul class="tab_content">
		<li class="active">
			<div class="signup_form_contain">
				<h3 class="login-box-msg"><strong>Welcome</strong>, Please Sign Up </h3>
				<form class="roguelytics_site_form" id="roguelytics_new_user" action="" accept-charset="UTF-8" method="post">
					<ul class="m1">
						<li>
							<input required="required" name="firstname" placeholder="First Name*" type="text">
						</li>
						<li>
							<input required="required" name="lastname" placeholder="Last Name*" type="text">
						</li>
						<li>
							<input required="required" name="email" placeholder="Email*" type="email">
						</li>
						<li>
							<label>*6 Character Minimum</label>
							<input required="required" name="password" placeholder="Password*" type="password">
						</li>
						<li>
							<input required="required" name="password_confirmation" id="user_password_confirmation" placeholder="Password confirmation*" type="password">  
						</li>
						<li>
							<label>Site Name</label>
							<input required="required" name="site_name" placeholder="Site Name*" type="text">  
						</li>
						<li>
							<input name="rogueltyics_signup" value="Sign Up" type="submit">
						</li>
					</ul>
				</form>
		   </div>
		</li>
		<li>
			<div class="signup_form_contain">
				<h3 class="login-box-msg"><strong>Welcome</strong>, Please Sign In</h3>
				<form class="roguelytics_site_form" id="roguelytics_signin" action="/users" accept-charset="UTF-8" method="post">
					<ul class="m1">
						<li>
							<input required="required" name="user[email]" id="user_email" placeholder="Email*" type="email">
						</li>
						<li>
							<input required="required" name="user[password]" id="user_password" placeholder="Password*" type="password">
						</li>
						<li>
							<input value="Sign Up" type="submit">
						</li>
					</ul>
				</form>
		   </div>
		</li>
	</ul>
</div>