<?php

class SubscriptionContr extends Subscription {
    private $subscription_plan;

    public function __construct($subscription_plan) {
        $this->subscription_plan = $subscription_plan;
    }

    private function emptyInput($value) {
        return empty($value);
    }

    public function PickPlan($user_id)  {
        if ($this->emptyInput($this->subscription_plan)) {
            // Handle empty input error
            header("location: ../subscription.php?status=failed");
            exit();
        }

     
        // Pass user_id to setSubscription method
        $this->setSubscription($this->subscription_plan, $user_id); 

    }
}
