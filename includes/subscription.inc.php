<?php
session_start();

include "../classes/dbh.classes.php";
include "../classes/subscription.classes.php";
include "../classes/subscription-contr.classes.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if user_id is set in the session
    if (!isset($_SESSION['user_id'])) {
        // Redirect to index page if user is not logged in
        header("location: ../index.php");
        exit();
    }

    // Get subscription plan from form
    $subscription_plan = htmlspecialchars($_POST['Subscription_plan']);
   
    // Retrieve userId from session
    $user_id = $_SESSION['user_id']; 

    // Instantiate SubscriptionContr class
    $subscriptionContr = new SubscriptionContr($subscription_plan); 

    // Process subscription plan
    $subscriptionContr->PickPlan($user_id); 

    // Redirect after subscription plan has been processed
    
    header("location: ../home.php");
    exit(); 
}
