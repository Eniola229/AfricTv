<?php
class PostContr extends Post {
    public function handlePost($name, $email, $unix_id, $body, $Intro, $extra_paragraph, $file, $category, $source, $tags, $essentials_link, $share_url) {
        // Validation
        if (empty($Intro) && empty($_FILES['file']['name'])) {
            // Both body and file are empty
            header("location: ../post.php?status=imgorbodyrequired");
            exit();
        }

        // Process post content
        $this->setPost($name, $email, $unix_id, $body, $Intro, $extra_paragraph, $file, $category, $source, $tags, $essentials_link, $share_url);

        // Redirect to success page
        header("location: ../success.php");
        exit();
    }
}
?>
