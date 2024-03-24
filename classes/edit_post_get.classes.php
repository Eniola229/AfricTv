<?php
include "dbh.classes.php";
session_start();

class Posts extends Dbh
{
    private $pdo;

    // Constructor receives an existing PDO instance
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPosts() {
    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_id = ?");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll();
    } else {
        // Handle the case when $_GET['post_id'] is not set
        return [];
    }
}

}

// Establish a database connection
$pdo = new PDO("mysql:host=localhost;dbname=africtv", 'root', '');

// Create an instance of the Posts class
$viewPost = new Posts($pdo);

// Retrieve posts
$posts = $viewPost->getPosts();

if (!empty($posts)) {
    foreach ($posts as $post) { ?>
        <div class="post-form-container">
          <div class="card-header">
                <button>Delete</button>
       </div>
        <form action="includes/edit_post.inc.php" method="post" enctype="multipart/form-data"> 
                <input type="hidden" value="<?php echo $post['post_id']; ?>">
                <input type="text" name="Intro" value="<?php echo $post['Intro']; ?>"><br> 
          
            <input type="text" name="source" value=" <?php echo $post['source']; ?>"><br>
             <select name="category">
                <option>Politics</option>
                <option>Bussiness</option>
                <option>Quotes</option>
                <option>Tech</option>
                <option>Entertainment</option>
                <option>Sports</option>
            </select><br>
             <label for="post-image" class="file-label">
                <div class="file-icon">
                    <img src="camera-icon.png" alt="Camera Icon">
                </div>
                Upload Image or Video:
            </label>
            <input type="file" id="post-image" name="file" accept="image/*, video/*">
            <label for="post-content">Content:</label>
            <textarea name="body" id="post-content" name="body" rows="4" ><?php echo $post['body']; ?></textarea>

            <label for="post-content">Extra Paragraph:</label>
            <textarea name="extra_paragraph" id="post-content" name="post-content" rows="2" ><?php echo $post['extra_paragraph']; ?></textarea>
      
        <button type="submit">Edit</button>
         </form>
     </div>
    <?php 
    }
} else {
    echo "Error Fetching Post!!";
}
?>
