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
	<script>
	const paymentForm = document.getElementById('paymentForm');
	paymentForm.addEventListener("submit", payWithPaystack, false);

	function payWithPaystack(e) {
	  e.preventDefault();

	  let handler = PaystackPop.setup({
	    key: 'pk_test_5e40b48a11ca718c1aba31670ce58ecd302c4094', // Replace with your public key
	    email: document.getElementById("email-address").value,
	    amount: 2000 * 100,
	    ref: 'AfricTv'+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
	    // label: "Optional string that replaces customer email"
	    onClose: function(){
	    	window.location = "http://localhost/africtvApi/auth/subscription.php?status=cancel"
	      alert('Transaction Cancelled!');
	    },
	    callback: function(response){
	      let message = 'Payment complete! Reference: ' + response.reference;
	      alert(message);
	      window.location = "http://localhost/africtvApi/auth/classes/verify_premiumpayment.classes.php?reference=" + response.reference;
	    }
	  });

	  handler.openIframe();
	}
</script>

</body>
</html>