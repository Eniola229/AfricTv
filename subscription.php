<?php
	session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscription Plan | AfricTv</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card h1 {
            margin-top: 0;
        }

        .card p {
            margin-bottom: 20px;
            color: #555;
        }

        .card button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .card button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome <?php if (isset($_SESSION['user_id'])) {
            echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Error';
        } ?></h1>



    <h3>Kindly Choose a Plan</h3>

    <div class="card">
        <form action="includes/subscription.inc.php" method="POST">
            <h1>Free Plan</h1>
            <p>This plan is completely free.</p>
            <p>
            	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <select name="Subscription_plan">
                <option value="free">Free Plan</option>
                <option value="remindplan">Remind To Pay for a Plan After 30days</option>
            </select>
            <button type="submit">Next</button>
        </form>
    </div>

    <div class="card">
        <form action="mediumPayment.php" method="POST">
            <h1>Medium Plan</h1>
            <p>$2 2-Month</p>
            <p>
            	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <button type="submit">Next</button>
        </form>

        

    </div>


    <div class="card">
        <form action="premiumPayment.php" method="POST">
            <h1>Premium Plan</h1>
            <p>$4 2-Month</p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <button type="submit">Next</button>
        </form>

        

    </div>
</div>


</body>
</html>
