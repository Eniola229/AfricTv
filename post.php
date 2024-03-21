<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post | AfricTv</title>
   
</head>
<body>
    <div class="post-form-container">
        <h2>Post Form</h2>
        <form id="post-form" action="includes/post.inc.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="name" placeholder="Profile Title" value="<?php echo $_SESSION['name']; ?>"><br><br>
            <input type="hidden" name="email" placeholder="Profile Title" value="<?php echo $_SESSION['email']; ?>"><br><br>
            <input type="hidden" name="unix_id" placeholder="Profile Title" value="<?php echo $_SESSION['unix_id']; ?>"><br><br> 

            <label for="post-title">Title:</label>
            <input type="text" name="Intro" id="post-title" name="post-title" >
            
            <select name="category">
                <option>Politics</option>
                <option>Bussiness</option>
                <option>Quotes</option>
                <option>Tech</option>
                <option>Entertainment</option>
                <option>Sports</option>
            </select>

             <label for="post-title">Source:</label>
            <input type="text" name="source" id="post-title" name="post-title" >

             <label for="post-image" class="file-label">
                <div class="file-icon">
                    <img src="camera-icon.png" alt="Camera Icon">
                </div>
                Upload Image or Video:
            </label>
            <input type="file" id="post-image" name="file" accept="image/*, video/*">

            <label for="post-content">Content:</label>
            <textarea name="body" id="post-content" name="body" rows="4" ></textarea>

            <label for="post-content">Extra Paragraph:</label>
            <textarea name="extra_paragraph" id="post-content" name="post-content" rows="2" ></textarea>
            
            
            <button type="submit">Submit Post</button>
        </form>
    </div>

    <style type="text/css">
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.post-form-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 10px;
    font-weight: bold;
}

input[type="text"],
textarea {
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.file-label {
    display: flex;
    align-items: center;
    font-weight: bold;
    background-color: blue;
    color: whitesmoke;
}

.file-icon {
    width: 30px;
    height: 30px;
    margin-right: 10px;
}

.file-icon img {
    max-width: 100%;
}

input[type="file"] {
    display: none;
}

button[type="submit"] {
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>

</body>
</html>
