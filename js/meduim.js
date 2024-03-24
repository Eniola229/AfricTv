const paymentForm = document.getElementById('paymentForm');
	paymentForm.addEventListener("submit", payWithPaystack, false);

	function payWithPaystack(e) {
	  e.preventDefault();

	  let handler = PaystackPop.setup({
	    key: 'pk_test_5e40b48a11ca718c1aba31670ce58ecd302c4094', // Replace with your public key
	    email: document.getElementById("email-address").value,
	    amount: 1500 * 100,
	    ref: 'AfricTv'+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
	    // label: "Optional string that replaces customer email"
	    onClose: function(){
	    	window.location = "http://localhost/africtvApi/auth/subscription.php?status=cancel"
	      alert('Transaction Cancelled!');
	    },
	    callback: function(response){
	      let message = 'Payment complete! Reference: ' + response.reference;
	      alert(message);
	      window.location = "http://localhost/africtv/payments/verify_mediumpayment.classes.php?reference=" + response.reference;
	    }
	  });

	  handler.openIframe();
	}