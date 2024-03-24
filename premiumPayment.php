<?php
session_start();


	$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'eeror';
	echo $email;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Premium Payment | AfricTv </title>
</head>
<body>

	<div>
		<h2>Premium Payment | AfricTv</h2>
		<form id="paymentForm">
		  <div class="form-group">
		    <label for="email">Email Address</label>
		    <input type="text" id="email-address" value="<?php echo $email; ?>" disabled>
		  </div>
		  <div class="form-group">
		    <label for="first-name">First Name</label>
		    <input type="text" id="first-name" />
		  </div>
		  <div class="form-group">
		    <label for="last-name">Last Name</label>
		    <input type="text" id="last-name" />
		  </div>
		  <div class="form-submit">
		    <button type="submit" onclick="payWithPaystack()"> Pay </button>
		  </div>
		</form>
	</div>
<br>
	<script src="https://js.paystack.co/v1/inline.js"></script>
	<script type="text/javascript" src="js/premium.js"></script>

</body>
</html>