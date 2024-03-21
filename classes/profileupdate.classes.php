<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

class Profile extends Dbh
{
    private $user_id;
    private $name;
    private $email;
    private $phone_number;

    function __construct($user_id, $name, $email, $phone_number)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }

    public function UpdateUser()
    {
        if ($this->emptyInput() == false) {
            return ['success' => false, 'status' => 'emptyInput'];
        }
        if ($this->invalidEmail() == false) {
            return ['success' => false, 'status' => 'invalidEmail'];
        }

        return $this->setNewProfileUpdate();
    }

    private function emptyInput()
    {
        return !empty($this->name) && !empty($this->email) && !empty($this->phone_number);
    }

    private function invalidEmail()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    private function setNewProfileUpdate()
    {
        try {
            $stmt = $this->connect()->prepare('UPDATE users SET name = ?, email = ?, phone_number = ? WHERE user_id = ?;');
            $stmt->execute([$this->name, $this->email, $this->phone_number, $this->user_id]);

            // Send email notification
            $this->sendEmail();

            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'status' => 'profilefailed'];
        }
    }

    private function sendEmail()
    {
        // Load Composer's autoloader
        require '../vendor/autoload.php';

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
        $mail->setFrom('your-email@gmail.com', 'Your Name');
        $mail->addAddress($this->email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Your profile was Updated Successfully';
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $email_template = "Verify it is you! $this->email" .
            "<p>Device: $userAgent</p>" .
            "<p>Time Updated: " . date('Y-m-d H:i:s') . "</p>" .
            "<a href='http://localhost/africtvApi/verify-profileupdate.php?email=$this->email'>Click here</a><br/>" .
            "<b>AfricTv Team</b>";

        $mail->Body = $email_template;

        // Attempt to send the email
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}