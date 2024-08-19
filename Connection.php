<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  

    if(!isset($_FILES['User_Image']['name'])){
        echo "File not set";
    }
    // Establish database connection
    $serverName = "localhost";
    $userName = "root";
    $password = "Leomessi10.";
    $dbName = "recipewebapp";
    $conn = new mysqli($serverName, $userName, $password, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $Username = $_POST['Username'];
    $Password = $_POST['user_password'];
    $Email = $_POST['user_email'];
    $ConfirmPassword = $_POST['confirm_password'];
    $User_Image=$_FILES['User_Image'];
    $Usertype=$_POST['usertype'];

    // Check if passwords match
    if ($Password !== $ConfirmPassword) {
        die("Error: Passwords do not match");
    }

    // Hash the password
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // File upload handling
    $target_directory = "uploads/";
    $target_file = $target_directory . basename($_FILES['User_Image']['name']);
    $ImageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is submitted without errors
    if (!empty($_FILES["User_Image"]["name"])) {
        $check = getimagesize($_FILES['User_Image']['tmp_name']);
        if ($check === false) {
            die("Error: File is not an image.");
        }

        // Check file size
        if ($_FILES["User_Image"]["size"] > 2000000) {
            die("Error: File is too large.");
        }

        // Allow certain file formats
        $allowed_types = array("jpg", "jpeg", "png", "gif");
        if (!in_array($ImageFileType, $allowed_types)) {
            die("Error: File type is not allowed.");
        }

        // Move the file to the target directory
        if (!move_uploaded_file($_FILES["User_Image"]["tmp_name"], $target_file)) {
            die("Error: There was an error uploading your file.");
        }
    } else {
        die("Error: No file was uploaded.");
    }

    // Insert data into database
    $sql = "INSERT INTO clientusers (fname, lname, username, password, email, userimage,Usertype) VALUES (?, ?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $Fname, $Lname, $Username, $hashedPassword, $Email, $target_file,$Usertype);

    if ($stmt->execute()) {
        header("Location: login.html");
        echo "New client added successfully";
    } else {
        echo "Error: Failed to add client " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();

} else {
    echo "Form not submitted correctly.";
}
?>
