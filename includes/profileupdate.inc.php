<?php

	require_once "../classes/dbh.classes.php";
	require_once "../classes/profileupdate.classes.php";
	require_once "../classes/profileupdate-contr.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Sanitize inputs
    $user_id = htmlspecialchars($_POST['user_id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number = htmlspecialchars($_POST['phone_number']);

    // Instantiate ProfileContr object
    $profileInfo = new ProfileContr($user_id, $name, $email, $phone_number);

    // Update user profile
    $result = $profileInfo->UpdateUser();

    // Redirect based on result
    if ($result['success']) {
        header("location: ../home.php?status=updatesuccess");
        exit();
    } else {
        header("location: ../profilesetting.php?status=" . $result['status']);
        exit();
    }
}