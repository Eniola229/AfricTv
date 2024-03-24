<?php

require_once "dbh.classes.php";

class DeletePost extends Dbh
{
    public function deletePost()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_id"])) {
            $post_id = $_POST["post_id"];

            try {
                // Prepare SQL statement to delete post
                $sql = "DELETE FROM posts WHERE post_id = :post_id";

                // Prepare the statement
                $stmt = $this->connect()->prepare($sql);

                // Bind parameters and execute the statement
                $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   header("location: ../home.php?status=post_deleted");
                   exit();
                } else {
                   header("location: ../home.php?status=post_deleted_error");
                   exit();
                }
            } catch (PDOException $e) {
                echo "Error deleting post: " . $e->getMessage();
                exit();
            }
        }
    }
}

?>
