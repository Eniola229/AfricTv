<?php

	
	//instantaite signupContr class
	include "../classes/dbh.classes.php";
	include "../classes/login.classes.php";
	include "../classes/login-contr.classes.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST' )
{
	//grabbing data from form

	$email = htmlspecialchars($_POST['email']);
	$pwd = htmlspecialchars($_POST['pwd']);
	

	$login = new LoginContr($email, $pwd);

	$login->loginUser();

	//going to back to front page

	header("location: ../home.php?error=none");
}