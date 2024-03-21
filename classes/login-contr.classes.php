<?php 
class LoginContr extends Login {

    private $email;
    private $pwd;

    public function __construct($email, $pwd) {
        $this->email = $email;
        $this->pwd = $pwd;
    }

  public function loginUser()
{
    if ($this->emptyInput() == false) {
        header('location: ../index.php?status=emptyinput');
        exit();
    }
    
    $userData = $this->getUser($this->email, $this->pwd);
    if (!$userData) {
        header('location: ../index.php?status=loginfailed');
        exit();
    }

    $this->sendEmail($this->email, $this->unix_id);

    // Call the method to set the login cookie
    $this->setLoginCookie($userData['user_id'], $this->email);

    // Redirect to the home page
    if ($_SESSION['Subscription_plan'] == "null") {
              header("location: ../subscription.php");
               exit;
            }
            else if ($_SESSION['Subscription_plan'] == "free") {
                $this->freePlan($this->email, $this->unix_id);
                header('Location: ../home.php');
                exit;
            }
             else if ($_SESSION['Subscription_plan'] == "remindplan") {
                header('Location: ../home.php');
                $this->reminder($this->email, $this->unix_id);
                exit;
            }
            elseif ($_SESSION['Subscription_plan'] == "medium") 
            {
                header('Location: ../home.php');
                exit;
            }
            elseif ($_SESSION['Subscription_plan'] == "premium") 
            {
                header('Location: ../home.php');
                exit;
            }
            else
            {
                header('Location: ../subscription.php');
                exit;
            }
           
   
}


    public function setLoginCookie($user_id, $email) {
     $expiration = time() + (30 * 24 * 60 * 60); // 30 days * 24 hours * 60 minutes * 60 seconds

    // Set the cookie
    setcookie('user_id', $user_id, $expiration, '/');
    setcookie('email', $email, $expiration, '/');
	}
       

    private function emptyInput() {
        return (!empty($this->email) && !empty($this->pwd));
    }   
}
?>
