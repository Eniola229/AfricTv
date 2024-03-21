<?php
include "dbh.classes.php";

class Posts extends Dbh
{
    private $pdo;

    // Constructor receives an existing PDO instance
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPosts() {
        $stmt = $this->pdo->prepare("SELECT * FROM posts ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
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
        <div class="card">
          <div class="card-header">
            <h3><?php echo $post['name']; ?></h3>
            <p><?php echo $post['email']; ?></p>
             <p> <?php echo $post['created_at']; ?></p>
          </div>
          <div class="card-body">
            <p><?php echo $post['Intro']; ?></p>
            <p><?php echo $post['body']; ?></p>
           
          </div>
          <?php if (!empty($post['imgvid_part'])) { ?>
            <div class="card-file">
              <?php 
              $file_path = '';
              $file_extension = pathinfo($post['imgvid_part'], PATHINFO_EXTENSION);
              if (in_array($file_extension, array('jpg', 'jpeg', 'png'))) {
                $file_path = 'http://localhost/africtv/image_uploads/' . $post['imgvid_part'];
                echo '<img src="' . $file_path . '" alt="Image" class="card-image">';
              } elseif (in_array($file_extension, array('mp4', 'mov'))) {
                $file_path = 'http://localhost/africtv/video_uploads/' . $post['imgvid_part'];
                echo '<video controls class="card-image">';
                echo '<source src="' . $file_path . '" type="video/' . $file_extension . '">';
                echo 'Your browser does not support the video tag.';
                echo '</video>';
              }
              ?>
            </div>
          <?php } ?>
          <div class="card-footer">
  
            <p>Category: <?php echo $post['category']; ?></p>
            <p>Source: <?php echo $post['source']; ?></p>
            <p>Read Time: <?php echo $post['read_time']; ?></p>
            <p>Number of Views: <?php echo $post['number_of_views']; ?></p>
            <a href="<?php echo $post['share_url'] . $post['post_id']; ?>">
              <button style="width:100%; font-weight: bold;">Share</button>
            </a>
          </div>
        </div>
    <?php 
    }
} else {
    echo "No posts found.";
}
?>
