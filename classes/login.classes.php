<?php 

    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

class Login extends Dbh
{
    protected function sendEmail($email, $unix_id)
    {
        // Load Composer's autoloader
        require '../vendor/autoload.php';

        try {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);
            
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'joshuaadeyemi445@gmail.com';
            $mail->Password = 'zfqqiuyjflogdmqq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Sender and recipient
            $mail->setFrom('joshuaadeyemi445@gmail.com', 'AfricTv Team');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'You logged into AfricTv';
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
           $email_template = "Verify it is you! $email" .
                  "<p>Device: $userAgent</p>" .
                  "<p>Time Logged In: " . date('Y-m-d H:i:s') . "</p>" .
                  "<a href='http://localhost/africtvApi/verify-email.php?email=$email'>Click here</a><br/>" .
                  "<b>AfricTv Team</b>";

            $mail->Body = $email_template;
            
            // Attempt to send the email
            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

     protected function reminder($email, $unix_id)
    {
        // Load Composer's autoloader
        require '../vendor/autoload.php';

        try {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);
            
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'joshuaadeyemi445@gmail.com';
            $mail->Password = 'zfqqiuyjflogdmqq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Sender and recipient
            $mail->setFrom('joshuaadeyemi445@gmail.com', 'AfricTv Team');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Reminder from AfricTv';
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
           $email_template = "This is a reminder for you to pay for a plan! $email" .
                  "<p>Time Logged In: " . date('Y-m-d H:i:s') . "</p>" .
                  "<a href='http://localhost/africtvApi/subscription.php?email=$email'>Click here</a><br/>" .
                  "<b>AfricTv Team</b>";

            $mail->Body = $email_template;
            
            // Attempt to send the email
            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

     protected function freePlan($email, $unix_id)
    {
        // Load Composer's autoloader
        require '../vendor/autoload.php';

        try {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);
            
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'joshuaadeyemi445@gmail.com';
            $mail->Password = 'zfqqiuyjflogdmqq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Sender and recipient
            $mail->setFrom('joshuaadeyemi445@gmail.com', 'AfricTv Team');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'AfricTv Free Plan';
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $email_template = "You are on a free plan! $unix_id" .
                  "<p>Time " . date('Y-m-d H:i:s') . "</p>" .
                  "<a href='http://localhost/africtvApi/auth/index.php?email=$email'>Click here to upgrade plan</a><br/>" .
                  "<b>AfricTv Team</b>";

            $mail->Body = $email_template;
            
            // Attempt to send the email
            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }



    protected function getUser($email, $pwd) {
    // Prepare and execute the query to fetch user data
    $stmt = $this->connect()->prepare('SELECT * FROM users WHERE email = ?;');
    if (!$stmt->execute([$email])) {
        // Handle execution error
        return false;
    }

    // Fetch user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and verify password
    if (!$user || !password_verify($pwd, $user['pwd'])) {
        // Invalid email or password
        return false;
    }

    // Start session and store necessary user data
    session_start();
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['phone_number'] = $user['phone_number'];
    $_SESSION['unix_id'] = $user['unix_id'];
    $_SESSION['Subscription_plan'] = $user['Subscription_plan'];
    $_SESSION['Verification_status'] = $user['Verification_status'];
    $_SESSION['joined_at'] =$user['joined_at'];

    // Close statement
    $stmt = null;

    // Return user data
    return $user;
}

}
