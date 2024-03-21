<?php
	
session_start();

include "../classes/dbh.classes.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

	 if (!isset($_SESSION['user_id'])) {
        // Handle the case when user is not logged in or user_id is not available
        // redirect to index page
        header("location: ../index.php");
        exit();
    }
    
    $Subscription_plan = isset($_POST['Subscription_plan']) ? htmlspecialchars($_POST['Subscription_plan']) : '';
    $userId = $_SESSION['user_id'];

    switch ($Subscription_plan) {
        case "free":
           header("Location: subscription.inc.php?status=userId=$userId");
            exit();
        case "medium":
            header("Location: mediumsubscription.inc.php");
            exit();
        case "premium":
            header("Location: premiumsubscription.inc.php");
            exit();
        default:
            header("Location: ../subscription.php");
            exit();
    }
}
