<?php

class EditPost extends Dbh {
    protected function setEditPost($post_id, $body, $Intro, $extra_paragraph, $file, $category, $source) {

        // Check if a file was uploaded
        if (!empty($file['name']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_type = $file['type'];

            // Array of allowed image and video file types
            $allowed_image_types = array('image/jpeg', 'image/png', 'image/gif');
            $allowed_video_types = array('video/mp4', 'video/mpeg', 'video/quicktime');

            // Check if the uploaded file type is allowed
            if (in_array($file_type, $allowed_image_types)) {
                // File is an image
                $uploadDirectory = '../image_uploads/';
            } elseif (in_array($file_type, $allowed_video_types)) {
                // File is a video
                $uploadDirectory = '../video_uploads/';
            } else {
                // File type is not allowed
                header("location: ../edit_post.php?status=invalidfiletype");
                exit();
            }

            // Generate a unique name for the file
            $uniqueFileName = uniqid() . '_' . $file_name;

            // Move the uploaded file to the server
            $uploadPath = $uploadDirectory . $uniqueFileName;
            if (move_uploaded_file($file_tmp, $uploadPath)) {
                // Prepare and execute SQL statement for updating post
                $sql = "UPDATE posts SET body = ?, Intro = ?, extra_paragraph = ?, imgvid_part = ?, category = ?, source = ? WHERE post_id = ?";
                $stmt = $this->connect()->prepare($sql);
                if ($stmt->execute([$body, $Intro, $extra_paragraph, $uploadPath, $category, $source, $post_id])) {
                    // Success: redirect to home page
                    header("location: ../home.php?status=post_update_success");
                    exit();
                } else {
                    // Database insertion failed
                    header("location: ../edit_post.php?status=stmtfailed");
                    exit();
                }
            } else {
                // File upload failed
                header("location: ../edit_post.php?status=fileuploadfailed");
                exit();
            }
        } else {
            // No file uploaded
            header("location: ../edit_post.php?status=nofileuploaded");
            exit();
        }
    }
}

?>
