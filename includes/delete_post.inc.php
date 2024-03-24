<?php
include "../classes/DeletePost.classes.php"; 

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create an instance of the DeletePost class
    $deletePost = new DeletePost();

    // Call the deletePost() method to delete the post
    $deletePost->deletePost();
}
?>
