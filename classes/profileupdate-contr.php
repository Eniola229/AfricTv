<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
class ProfileContr extends Profile
{

	protected function sendEmail($email)
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
            $mail->Subject = 'Your profile was Updated Successfuly | AfricTv';
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
           $email_template = "Verify it is you! $email" .
                  "<p>Device: $userAgent</p>" .
                  "<p>Time Updated: " . date('Y-m-d H:i:s') . "</p>" .
                  "<a href='http://localhost/africtvApi/verify-profileupdate.php?email=$email'>Click here</a><br/>" .
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

	protected function setNewProfileUpdate($name, $email, $phone_number, $user_id) {
        $stmt = $this->connect()->prepare('UPDATE users SET name = ?, email = ?, phone_number = ? WHERE user_id = ?;');
         $this->sendEmail($email);

        if (!$stmt->execute(array($name, $email, $phone_number, $user_id))) {
            $stmt = null;
            header("location: profilesetting.php?status=profilefailed");
            exit();
        }

        $stmt = null;
    }

}