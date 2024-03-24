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
            <div>
            <h3><?php echo $post['name']; ?></h3>
            <p><?php echo $post['email']; ?></p>
             <p> <?php echo $post['created_at']; ?></p>
           </div>
           <div>

           <?php
            if ($_SESSION['unix_id'] == $post['unix_id']) {?>
            <a href="http://localhost/africtv/edit_post.php?post_id=<?php echo $post['post_id']; ?>">
            <button>Edit</button>
        </a>

                 <form action='includes/delete_post.inc.php' method='post'>
                    <input type='hidden' name='post_id' value='<?php echo $post['post_id']; ?>'>
                    <button type='submit'>Delete</button>
                </form>
            <?php } else { ?>
               <button>Bookmark</button>
            <?php }

            if ($_SESSION['Subscription_plan'] == "free") {?>
                <a href="subscription.php"><button>Upgrade Plan to Download</button></a>
            <?php } else {

              $file_path = '';
              $file_extension = pathinfo($post['imgvid_part'], PATHINFO_EXTENSION);
              if (in_array($file_extension, array('jpg', 'jpeg', 'png'))) {
                $file_path = 'http://localhost/africtv/image_uploads/' . $post['imgvid_part'];
                echo ' <a href="' . $file_path . '" alt="Image" class="card-image" download><Button>Download</Button></a>';
              } elseif (in_array($file_extension, array('mp4', 'mov'))) {
                $file_path = 'http://localhost/africtv/video_uploads/' . $post['imgvid_part'];
                echo '<a href="' . $file_path . '" alt="Video" class="card-image" download><Button>Download</Button></a>';
              }
            
            }
            ?>

            
           </div>
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
          <form action="includes/comments.inc.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $post['post_id'] ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
            <textarea name="comment_body" rows="4" placeholder="Comments"></textarea>
           <div class="comment-section">
            <?php
            if ($_SESSION['Subscription_plan'] == "free") {?>
                <p>Upgrade subscription plan to be able to comment images</p>
            <?php }
            elseif ($_SESSION['Subscription_plan'] == "medium" || $_SESSION['Subscription_plan'] == "premium") {?>
                <label>Images or Video</label>
                <input type="file" name="file" accept="image/*, video/*">
            <?php } ?>
        </div>

            <button type="submit">Comments</button>

          </form>
        </div>
    <?php 
    }
} else {
    echo "No posts found.";
}
?>
