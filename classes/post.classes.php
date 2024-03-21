<?php

    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

class Post extends Dbh
{
protected function sendEmail($name, $email, $Intro, $uniqueFileName, $share_url)
{
    // Load Composer's autoloader
    require '../vendor/autoload.php';

    try {
        // Initialize PHPMailer
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $mail->isSMTP(); // Send using SMTP
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'joshuaadeyemi445@gmail.com'; // SMTP username
        $mail->Password = 'zfqqiuyjflogdmqq'; // App-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
        $mail->Port = 465; // TCP port to connect to

        // Set sender and recipient
        $mail->setFrom('joshuaadeyemi445@gmail.com', $name);
        $mail->addAddress($email);    

        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Subject = 'Post Successful | AfricTv';

        // Construct email template
        $email_template = "<h1>" . $name .  "</h1><br/>" .
                          "<p>" . $Intro .  "</p/><br/>";

        // Determine file type
        $file_extension = strtolower(pathinfo($uniqueFileName, PATHINFO_EXTENSION));

        // If it's an image, include <img> tag
        if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $email_template .= "<img src='$share_url$uniqueFileName' alt='Uploaded Image' style='max-width: 100%;'><br/>";
        } 
        // If it's a video, include <video> tag
        elseif (in_array($file_extension, ['mp4', 'avi', 'mov', 'mkv'])) {
            $email_template .= "<video width='320' height='240' controls><source src='$share_url$uniqueFileName' type='video/mp4'>Your browser does not support the video tag.</video><br/>";
        }

        // Add link and footer
        $email_template .= "<a href='http://localhost/africtv/.php?share_url=$share_url'>Click here to view post</a><br/>" .
                           "<br/><b>AfricTv Team</b>";

        // Set email body
        $mail->Body = $email_template;
        
        // Attempt to send the email
        if ($mail->send()) {
            header("location: ../index.php?status=emailsent");
        } else {
            header("location: ../index.php?status=sentemailfailed&error=" . urlencode($mail->ErrorInfo));
        }
    } catch (Exception $e) {
        header("location: ../index.php?status=sentemailfailed&error=" . urlencode($mail->ErrorInfo));
    }
}


	
protected function setPost($name, $email, $unix_id, $body, $Intro, $extra_paragraph, $file, $category, $source, $tags, $essentials_link, $share_url) {
{   
    // Check if a file was uploaded
    if(isset($_FILES['file'])) {
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];

    // Array of allowed image and video file types
    $allowed_image_types = array('image/jpeg', 'image/png', 'image/gif');
    $allowed_video_types = array('video/mp4', 'video/mpeg', 'video/quicktime');

    // Check if the uploaded file type is allowed
    if(in_array($file_type, $allowed_image_types)) {
        // File is an image
        $uploadDirectory = '../image_uploads/';
    } elseif (in_array($file_type, $allowed_video_types)) {
        // File is a video
        $uploadDirectory = '../video_uploads/';
    } else {
        // File type is not allowed
        header("location: ../post.php?status=invalidfiletype");
        exit();
    }


        // Generate a unique name for the file
        $uniqueFileName = uniqid() . '_' . $file_name;

        // Move the uploaded file to the server
        $uploadPath = $uploadDirectory . $uniqueFileName;
        if(move_uploaded_file($file_tmp, $uploadPath)) {
          

            // Insert the unique filename into the database
           $stmt = $this->connect()->prepare('INSERT INTO posts (name, email, unix_id, body, Intro, extra_paragraph, imgvid_part, category, source, tags, essentials_link, share_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');

               if ($stmt->execute(array($name, $email, $unix_id, $body, $Intro, $extra_paragraph, $uniqueFileName, $category, $source, implode(',', $tags), $essentials_link, $share_url))) {
                  // File upload successful, now send email
                  $this->sendEmail($name, $email, $Intro, $uniqueFileName, $share_url);
                // Success: redirect to home page
                header("location: ../home.php?status=postsuccess");
                exit();
            } else {
                // Database insertion failed
                header("location: ../post.php?status=stmtfailed");
                exit();
            }
        } else {
            // File upload failed
            header("location: ../post.php?status=fileuploadfailed");
            exit();
        }
    } else {
        // No file uploaded
        header("location: ../post.php?status=nofileuploaded");
        exit();
    }
}
}
}