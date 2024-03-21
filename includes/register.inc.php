<?php

include "../classes/dbh.classes.php";
include "../classes/register.classes.php";
include "../classes/register-contr.classes.php";
// include "../classes/profileinfo.classes.php";
// include "../classes/profileinfo-contr.classes.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // grabbing the data 
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $Subscription_plan = "null";
    $Verification_status = "0";
    $pwd = htmlspecialchars($_POST['pwd']);
    $pwdRepeat = htmlspecialchars($_POST['pwdRepeat']);

    //Generating unique_id
	// Extract the first word from the name
	$firstWord = strtok($name, ' ');
	// Generate a random four-digit number
	$randomNumber = rand(1000, 9999);

	$unix_id = '@' .$firstWord . $randomNumber;
	    




    // Instantiate RegisterContr class
    $register = new RegisterContr($name, $email, $phone_number, $unix_id, $Subscription_plan, $Verification_status, $pwd, $pwdRepeat);

    // Running error handlers and user register
    $register->RegisterUser();

    // Get user ID after registration
    $userId = $register->FetchUserIdByEmail($email);


    // Instantiate ProfileInfoContr Class
    // $profileInfo = new ProfileInfoContr($userId, $user_id);
    // $profileInfo->defaultProfileInfo();


    
    // head to sub page when successful
    header("location: ../index.php?status=userId=$userId");
    exit();

}


