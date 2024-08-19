<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body id="SignUp">
    <div class="SignUpBox">
        
        <form method="POST" action="Connection.php" enctype="multipart/form-data">
            <p>First Name</p>
            <input type="text" name="Fname" placeholder="Enter First Name" required style="color: #000; background-color: #fff;">
            <p>Last Name</p>
            <input type="text" name="Lname" placeholder="Enter Last Name" required style="color: #000; background-color: #fff;">
            <p>Email</p>
            <input type="email" name="user_email" placeholder="Enter Email" required style="color: #000; background-color: #fff;">
            <p>Username</p>
            <input type="text" name="Username" placeholder="Enter Username" required style="color: #000; background-color: #fff;">
            <p>Set Password</p>
            <input type="password" name="user_password" placeholder="Enter Password" required style="color: #000; background-color: #fff;">
            <p>Confirm Password</p>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required style="color: #000; background-color: #fff;">

            <select id="usertype" name="usertype" required style="color: black; background-color: white;">
    <option value="" disabled selected>No user type selected</option>
    <?php
    $servername = "localhost";
    $username_db = "root";
    $password_db = "Leomessi10.";
    $dbname = "recipewebapp";

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM usertypes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Ensure htmlspecialchars for safe HTML output
            $usertype = htmlspecialchars($row['Usertype']);
            echo '<option  style="Color: #000;" value="' . $usertype . '">' . $usertype . '</option>';
        }
    } else {
        echo '<option style="Color: black;" value="">No Usertypes Available</option>';
    }
      echo "<pre>";
      echo print_r($row);
      echo "</pre>";

    $conn->close();
    ?>
</select>



            <input type="file" name="User_Image" id="User_Image" accept="image/*" required style="color: #000; background-color: #fff;"><br>
            <input type="submit" value="SignUp">
            <a href="Login.html">Have an account?</a>
        </form>
    </div>
</body>
</html>
