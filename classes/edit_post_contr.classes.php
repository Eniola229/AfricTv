<?php

class PostEditContr extends EditPost {
    public function handleEditPost($post_id, $body, $Intro, $extra_paragraph, $file, $category, $source) {
        // Validation
       if (empty($Intro)) {
        // Both intro and file are empty
        header("location: ../edit_post.php?status=imgorintrorequired");
        exit();
    }



        // Process post content
        $this->setEditPost($post_id, $body, $Intro, $extra_paragraph, $file, $category, $source);

        // Redirect to success page
        header("location: ../home.php?status=edit_success");
        exit();
    }
}

?>
