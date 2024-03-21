
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | AfricTv</title>
    <link rel="stylesheet" type="text/css" href="index.css">
   
</head>
<body>
 <main>

	<form method="post" action="includes/login.inc.php">
		<h1>Login</h1>
		<p style="color: red; text-align: center;">
			  <?php
                    if (isset($_GET['status'])) {
                        $errorCode = $_GET['status'];
                        switch ($errorCode) {
                            case 'stmtfailed':
                                echo '<p style="color: red; text-align: center;">An unexpected error occurred!</p>';
                                break;
                            case 'emptyinput':
                                echo '<p style="color: red; text-align: center;">All field Required!</p>';
                                break;
                                case 'premuimsuccess':
                                echo '<p style="color: green; text-align: center;">Payment Successful, Kindly Login!</p>';
                                break;
                                 case 'meduimsuccess':
                                echo '<p style="color: green; text-align: center;">Payment Successful, Kindly Login!</p>';
                                break;
                            case 'loginfailed':
                                echo '<p style="color: red; text-align: center;">User not found or Wrong Password! Failed</p>';
                                break; 
                            default:
                                echo '<p style="color: red; text-align: center;">Login Here!</p>';
                                break;
                        }
                    } else {
                        echo '	<p style="color: red; text-align: center;">Kindly Login!</p>';
                    }
                    ?>
		</p>
		<input type="email" name="email" placeholder="E-Mail" />
		<input type="password" name="pwd" placeholder="Password" />
		<div style="display: flex; width: 50%; height: 5vh; align-items: center;">
		    <input type="checkbox" style="margin-right: 8px;">
		    <p style="margin: 0;">Remember Me</p>
		</div>

		<button type="submit" name="submit">Login</button>
		<a href="register.php">Register</a>
	</form>


</main>

</body>
</html>