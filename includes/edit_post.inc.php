<?php

require_once "../classes/dbh.classes.php";
require_once "../classes/edit_post.classes.php";
require_once "../classes/edit_post_contr.classes.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve form data
    $post_id = isset($_POST['post_id']) ? htmlspecialchars($_POST['post_id']) : '';
    $Intro = isset($_POST['Intro']) ? htmlspecialchars($_POST['Intro']) : '';
    $category = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : ''; // Check if key is set
    $source = isset($_POST['source']) ? htmlspecialchars($_POST['source']) : '';
    $file = isset($_FILES['file']) ? $_FILES['file'] : null; 
    $body = isset($_POST['body']) ? htmlspecialchars($_POST['body']) : ''; 
    $extra_paragraph = isset($_POST['extra_paragraph']) ? htmlspecialchars($_POST['extra_paragraph']) : ''; 

    // Instantiate EditContr object
    $editController = new PostEditContr();
    $editController->handleEditPost($post_id, $body, $Intro, $extra_paragraph, $file, $category, $source);
}

