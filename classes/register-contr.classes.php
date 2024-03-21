<?php
	
	class RegisterContr extends Register
{
    private $name;
    private $email;
    private $phone_number;
    private $unix_id;
    private $Subscription_plan;
    private $Verification_status;
    private $pwd;
    private $pwdRepeat;

    public function __construct($name, $email, $phone_number, $unix_id, $Subscription_plan, $Verification_status, $pwd, $pwdRepeat)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->unix_id = $unix_id;
        $this->Subscription_plan = $Subscription_plan;
        $this->Verification_status = $Verification_status;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
    }

    public function RegisterUser()
    {
        if ($this->emptyInput() == false) {
            echo "All Field Required";
            header('location: ../register.php?status=emptyInput');
            exit();
        }
        if ($this->invalidEmail() == false) {
            echo "Invalid Email";
            header('location: ../register.php?status=invalidEmail');
            exit();
        }
        if ($this->pwdMatch() == false) {
            echo "Password dont Match!";
            header('location: ../register.php?status=passwordmatch');
            exit();
        }
        if ($this->idTakenCheck() == false) {
            echo "User Name Of Email Taken";
            header('location: ../register.php?status=useroremailtaken');
            exit();
        }

        // If all checks pass, proceed with user registration
        $this->setUser($this->name, $this->email, $this->phone_number, $this->unix_id, $this->Subscription_plan, $this->Verification_status, $this->pwd);

        // Send confirmation email
    	$this->sendEmail($this->name, $this->email, $this->unix_id);

    }

    private function emptyInput()
    {
        return !empty($this->name) && !empty($this->email) && !empty($this->phone_number);
    }

    private function invalidEmail()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    private function pwdMatch()
    {
        return $this->pwd === $this->pwdRepeat;
    }

    private function idTakenCheck()
    {
        return $this->checkUser($this->name, $this->email);
    }

    public function FetchUserIdByEmail($email) {
        // Prepare and execute SQL query to fetch user ID by email
        $stmt = $this->connect()->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user['user_id'] ?? null; // Return user ID or null if not found
    }
}
