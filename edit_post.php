<?php 
    include "classes/edit_post_get.classes.php"
?>

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