<?php 
 session_start();
?>


    <form action="includes/profileupdate.inc.php" method="post">
        <input type="hidden" name="user_id" placeholder="Profile Title" value="<?php echo $_SESSION['user_id']; ?>"><br><br>
        <button disabled><?php echo $_SESSION['unix_id']; ?></button><br><br>
        <input type="text" name="name" placeholder="Profile Title" value="<?php echo $_SESSION['name']; ?>"><br><br>
        <input type="text" name="email" placeholder="Profile Title" value="<?php echo $_SESSION['email']; ?>"><br><br>
        <input type="text" name="phone_number" placeholder="Profile Title" value="<?php echo $_SESSION['phone_number']; ?>"><br><br>
        <button type="submit" name="submit">UPDATE</button>
    </form>

  

</body>
</html>