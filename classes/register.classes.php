<?php

	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Register extends Dbh
{


	protected function sendEmail($name, $email, $unix_id)
{

    //Load Composer's autoloader
    require '../vendor/autoload.php';

    try {
        // code...
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'joshuaadeyemi445@gmail.com';           //SMTP username
        $mail->Password   = 'zfqqiuyjflogdmqq';                     //App-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to

        //Recipients
        $mail->setFrom('joshuaadeyemi445@gmail.com', $name);
        $mail->addAddress($email);    

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'You have Registered with AfricTv';
        $email_template  = "Verify it is you! ". $name ." <p>Unique Id</p> " . $unix_id . "<br/>" ."
         <a href='http://localhost/africtvApi/verify-email.php?unix_id=$unix_id'>Click here</a>
         <br/><b>AfricTv Team</b>
         ";
        $mail->Body = $email_template;
        
        // Attempt to send the email
        if ($mail->send()) {
          header("location: ../index.php?status=emailsent");
        } else {
            header("location: ../index.php?status=sentemailfailed". $mail->ErrorInfo);
        }
    } catch (Exception $e) {
       header("location: ../index.php?status=sentemailfailed&error=" . urlencode($mail->ErrorInfo));

    }
}


	protected function setUser($name, $email, $phone_number, $unix_id, $Subscription_plan, $Verification_status, $pwd)
	{   



	    // Hash the password
	    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

	    // Prepare the SQL statement
	    $stmt = $this->connect()->prepare('INSERT INTO users (name, email, phone_number, unix_id, Subscription_plan, Verification_status, pwd) VALUES (?, ?, ?, ?, ?, ?, ?);');

	    // Bind the parameters and execute the statement
	    if (!$stmt->execute(array($name, $email, $phone_number, $unix_id, $Subscription_plan, $Verification_status, $hashedPwd)))
	    {
	        $stmt = null;
	        header("location: ../index.php?status=stmtfailed");
	        exit();
	    }
	    $stmt = null;
	}


	protected function checkUser($name, $email)
	{
		$stmt = $this->connect()->prepare('SELECT user_id FROM users WHERE name = ? or email = ?');

		if (!$stmt->execute(array($name, $email))) 
		{
			$stmt = null;
			header("location: ../index.php?status=usertaken");
			exit();
		}

		$resultCheck;
		if ($stmt->rowCount() > 0)
		{
			$resultCheck = false;
		}
		else
		{
			$resultCheck = true;
		}
		return $resultCheck;
	}

	protected function getUserId($email)
{
    $stmt = $this->connect()->prepare('SELECT user_id FROM users WHERE email = ?;');

    $stmt->execute([$email]); // Execute the prepared statement

    if ($stmt->rowCount() == 0) {
        // If no user is found, redirect with an appropriate status
        header("location: ../index.php?status=stmtfailed");
        exit();
    }

    $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $profileData;

	$userData = $stmt->fetch(PDO::FETCH_ASSOC);
	return $userData['email'];
}
}