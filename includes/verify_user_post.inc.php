<?php
session_start();

if ($_SESSION['Subscription_plan'] == "premium") {
	header("location: ../post.php");
	exit();
}
elseif ($_SESSION['Subscription_plan'] == "free")
{
	header("location: ../home.php?upgradeplantopost?");
	exit();
}
elseif ($_SESSION['Subscription_plan'] == "medium") {
	header("location: ../post.php");
	exit();
}
else{
	header("location: ../home.php?upgradeplantopost?");
	exit();
}