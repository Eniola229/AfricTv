<?php

class Subscription extends Dbh {

   
    protected function setSubscription($subscription, $user_id) {
        // Check if user_id and subscription are valid
        if (empty($user_id) || empty($subscription)) {
            // Handle invalid input appropriately
            header("Location: ../subscription.php?status=invalidinput");
            exit(); 
        }


        // Prepare the update query
        $stmt = $this->connect()->prepare('UPDATE users SET Subscription_plan = ? WHERE user_id = ?');


        // Bind user_id along with subscription
        if (!$stmt->execute(array($subscription, $user_id))) { 
            // Handle database error or failed update appropriately
            $stmt = null;
            header("Location: ../subscription.php?status=stmtfailed"); 
            exit(); 
        }
        $stmt = null;
    }
}
