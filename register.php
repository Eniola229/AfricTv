
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | AfricTv</title>
    <link rel="stylesheet" type="text/css" href="index.css">
   
</head>
<body>
 <main>
	<form method="post" action="includes/register.inc.php">
		<h1>Create Account</h1>
			<p style="color: red; text-align: center;">
			 <?php
                    if (isset($_GET['status'])) {
                        $errorCode = $_GET['status'];
                        switch ($errorCode) {
                            case 'stmtfailed':
                                echo '<p class="alert alert-danger" role="alert">An unexpected error occurred!</p>';
                                break;
                            case 'emptyinput':
                                echo '<p class="alert alert-danger" role="alert">All field Required!</p>';
                                break;
                            case 'usernotfound':
                                echo '<p class="alert alert-danger" role="alert">User not found!</p>';
                                break;
                            case 'invalidEmail':
                                echo '<p class="alert alert-danger" role="alert">InvalidEmail!</p>';
                                break;
                            case 'passwordmatch':
                                echo '<p class="alert alert-danger" role="alert">Password Those not Match!</p>';
                                break;
                             case 'useroremailtaken':
                                echo '<p class="alert alert-danger" role="alert">User Name Or Email Taken!</p>';
                                break;
                            default:
                                echo '<p class="alert alert-danger" role="alert">Unknown Error!</p>';
                                break;
                        }
                    } else {
                        echo '	<p style="color: red; text-align: center;">Kindly fill in all the details correctly!</p>';
                    }
                    ?>
		</p>
		<input type="text" name="name" placeholder="Username" />
	    <input type="email" name="email" placeholder="E-mail">
	    <input type="number" name="phone_number" placeholder="Phone Number">
	  	<!-- <input type="hidden" name="Subscription_plan" value="normal"> -->
		<input type="password" name="pwd" placeholder="Password" />
		<input type="password" name="pwdRepeat" placeholder="Password" />
		<button type="submit" name="submit">Submit</button>
	</form>
</main>

</body>
</html>
