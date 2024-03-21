<?php
include_once "../classes/dbh.classes.php";
include_once "../classes/post.classes.php";
include_once "../classes/post-contr.classes.php";

function generateTags($content) {
    $tags = [];

    // Split content into words
    $words = preg_split('/\s+/', $content);

    // Extract keywords or terms
    foreach ($words as $word) {
        // Filter out common words or irrelevant terms
        if (strlen($word) > 3 && !in_array($word, ['the', 'and', 'or', 'is'])) {
            // Add the word to tags array 
            $tags[] = $word;
        }
    }

    return $tags;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve form data
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; 
    $unix_id = isset($_POST['unix_id']) ? htmlspecialchars($_POST['unix_id']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $Intro = isset($_POST['Intro']) ? htmlspecialchars($_POST['Intro']) : '';
    $category = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : ''; // Check if key is set
    $source = isset($_POST['source']) ? htmlspecialchars($_POST['source']) : '';
    $file = isset($_FILES['file']) ? $_FILES['file'] : null; 
    $body = isset($_POST['body']) ? htmlspecialchars($_POST['body']) : ''; 
    $extra_paragraph = isset($_POST['extra_paragraph']) ? htmlspecialchars($_POST['extra_paragraph']) : ''; 
    $essentials_link = "http://localhost/africtv/$category/$Intro";
    $share_url = "http://localhost/africtv/share/$unix_id/$Intro";
    // Generate tags based on the post content
    $tags = generateTags($Intro);

    // Instantiate PostContr object
    $postController = new PostContr();
    $postController->handlePost($name, $email, $unix_id, $body, $Intro, $extra_paragraph, $file, $category, $source, $tags, $essentials_link, $share_url);
}
