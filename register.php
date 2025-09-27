<?php
error_reporting(E_ALL & ~E_NOTICE  &  ~E_STRICT  &  ~E_WARNING);
$con = mysqli_connect("localhost", "root", "", "eventplanner");
echo mysqli_connect_error();
?>

<?php include("header.php");

if (isset($_POST['submitregister'])) {
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$pass = mysqli_real_escape_string($con, $_POST['pass']);
	$address = mysqli_real_escape_string($con, $_POST['address']);
	$contactno = mysqli_real_escape_string($con, $_POST['contactno']);
	$image_name = rand() . "_" . $_FILES["photo"]["name"];
	$temp = isset($_FILES["photo"]["tmp_name"]) ? $_FILES["photo"]["tmp_name"] : '';
	$folder = "uploads/" . $image_name;

	if (!is_dir("uploads")) {
		mkdir("uploads");
	}

	// ✅ Duplicate email check
	$checkEmail = mysqli_query($con, "SELECT * FROM customer WHERE email_id='$email'");
	if (mysqli_num_rows($checkEmail) > 0) {
		// Email already exists
		echo "
		<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
		<script>
			Swal.fire({
				icon: 'error',
				title: 'Email Already Registered!',
				text: 'Please use a different email address.',
				confirmButtonColor: '#d33'
			});
		</script>";
	} else {
		// Insert if email is unique
		if (!empty($temp) && is_uploaded_file($temp)) {
			if (move_uploaded_file($temp, $folder)) {
				$sql = "INSERT INTO customer (customer_name, email_id, password, contactno, address, photo, status) 
						VALUES ('$name', '$email', '$pass', '$contactno', '$address', '$image_name', 'Active')";
				$qsql = mysqli_query($con, $sql);
				echo mysqli_error($con);
				if (mysqli_affected_rows($con) == 1) {
					echo "
					<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
					<script>
						Swal.fire({
							icon: 'success',
							title: 'Registration Successful!',
							showConfirmButton: false,
							timer: 2000
						}).then(function() {
							window.location='custlogin.php';
						});
					</script>";
				} else {
					echo "<p>Something went wrong.</p>";
				}
			} else {
				echo "<p style='color:red;'>Image upload failed!</p>";
			}
		} else {
			echo "<p style='color:red;'>No image selected or upload error!</p>";
		}
	}
}
?>

<style>
	input[type="file"] {
		display: block;
		margin-top: 50px;
		margin-bottom: 20px;
		padding: 10px;
		width: 100%;
		max-width: 100%;
		border: 2px dashed #fb9a08ff;
		border-radius: 10px;
		background-color: #fff;
		font-size: 16px;
		color: black;
		transition: all 0.3s ease-in-out;
		cursor: pointer;
	}
	input[type="file"]:hover {
		background-color: #d4a373;
		border-color: #eed6b3;
		color: #fff;
	}
	.validateformSwal.fire {
		font-size: 16px;
		width: 250px;
		height: 200px;

	}
</style>

<!-- start contact -->
<section id="contact">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="wow bounceIn" data-wow-offset="50" data-wow-delay="0.3s">REGISTER <span>PANEL</span></h2>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12 wow fadeInLeft" data-wow-offset="50" data-wow-delay="0.9s">
				<form action="" method="post" name="frmform" onsubmit="return validateform()" enctype="multipart/form-data">

					<label>Name</label><span id="idname" class="errdisplay" style="color:red;font-weight: bold;padding-left:10px;"></span>
					<input name="name" type="text" class="form-control" id="name">

					<label>Email ID</label><span id="idemail" class="errdisplay" style="color:red;font-weight: bold;padding-left:10px;"></span>
					<input name="email" type="text" class="form-control" id="email">

					<label>Password</label><span id="idpass" class="errdisplay" style="color:red;font-weight: bold;padding-left:10px;"></span>
					<input name="pass" type="password" class="form-control" id="pass">

					<label>Confirm Password</label><span id="idconfirm" class="errdisplay" style="color:red;font-weight: bold;padding-left:10px;"></span>
					<input name="confirm" type="password" class="form-control" id="confirm">

					<label>Contact</label><span id="idcontactno" class="errdisplay" style="color:red;font-weight: bold;padding-left:10px;"></span>
					<input name="contactno" type="text" class="form-control" id="contactno">

					<label>Address</label><span id="idaddress" class="errdisplay" style="color:red;font-weight: bold;padding-left:10px;"></span>
					<textarea name="address" class="form-control" id="address"></textarea>

					<label>Select image:</label>
					<input type="file" name="photo" required><br><br>

					<input type="submit" name="submitregister" class="form-control" value="Click here to Register">
				</form>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12 wow fadeInRight" data-wow-offset="50" data-wow-delay="0.6s">
				<address>
					<p class="address-title">Existing User</p>
				</address>
				<ul class="social-icon">
					<li><input type="submit" class="form-control" value="Click here to Login" onclick="window.location='custlogin.php'"></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<!-- end contact -->

<?php include("footer.php"); ?>

<script>
	function validateform() {
		var numericExpression = /^[0-9]+$/;
		var alphaspaceExp = /^[a-zA-Z\s]+$/;
		var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,6}$/;

		var confirmreturn = "true";
		$(".errdisplay").html("");

		if (!document.getElementById("name").value.match(alphaspaceExp)) {
			document.getElementById("idname").innerHTML = "Name should contain alphabets...";
			confirmreturn = "false";
		}
		if (document.getElementById("name").value == "") {
			document.getElementById("idname").innerHTML = "Name should not be empty..";
			confirmreturn = "false";
		}
		if (!document.getElementById("email").value.match(emailExp)) {
			document.getElementById("idemail").innerHTML = "Entered Email ID is not in valid format...";
			confirmreturn = "false";
		}
		if (document.getElementById("email").value == "") {
			document.getElementById("idemail").innerHTML = "Email ID should not be empty..";
			confirmreturn = "false";
		}
		if (document.getElementById("pass").value.length < 8) {
			document.getElementById("idpass").innerHTML = "Password should contain more than 8 characters...";
			confirmreturn = "false";
		}
		if (document.getElementById("pass").value == "") {
			document.getElementById("idpass").innerHTML = "Password should not be empty..";
			confirmreturn = "false";
		}
		if (document.getElementById("pass").value != document.getElementById("confirm").value) {
			document.getElementById("idconfirm").innerHTML = "Password and Confirm password not matching....";
			confirmreturn = "false";
		}
		if (document.getElementById("confirm").value == "") {
			document.getElementById("idconfirm").innerHTML = "Confirm password should not be empty..";
			confirmreturn = "false";
		}
		if (document.getElementById("contactno").value.length != 10 || !document.getElementById("contactno").value.match(numericExpression)) {
			document.getElementById("idcontactno").innerHTML = "Contact number should be 10 digits only...";
			confirmreturn = "false";
		}
		if (document.getElementById("contactno").value == "") {
			document.getElementById("idcontactno").innerHTML = "Contact number should not be empty..";
			confirmreturn = "false";
		}

		return confirmreturn === "true";
	}
</script>