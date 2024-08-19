<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch email and password from the form
    $email = trim($_GET['login_email']);
    $Login_password = trim($_GET['login_password']);

    $serverName = "localhost";
    $userName = "root";
    $password = "Leomessi10.";
    $dbName = "recipewebapp";

    // Create connection
    $conn = new mysqli($serverName, $userName, $password, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch user information including the role
    $query = "SELECT user_id, FName, LName, Username, Password, Usertype FROM clientusers WHERE Email=?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $email);

        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }
        $stmt->store_result();
        $stmt->bind_result($user_id, $FName, $LName, $Username, $db_password, $Usertype);
        $stmt->fetch();

        // Verify password
        if ($stmt->num_rows == 1 && password_verify($Login_password, $db_password)) {
            // At this point, login is successful, so we set session variables
            $_SESSION['First_name'] = $FName;
            $_SESSION["Last_name"] = $LName;
            $_SESSION['Username'] = $Username;
            $_SESSION['Email'] = $email;
            $_SESSION['Usertype'] = $Usertype;
            $_SESSION['user_id'] = $user_id;

            // Debug: Check session variables
            var_dump($_SESSION);

            // Redirect based on role
            if ($Usertype == 'Admin') {
                header("Location: admin_dashboard.php");
            } elseif ($Usertype == 'Recipe Owner') {
                header("Location: recipe_owner_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit; // Ensure script stops here after redirection
        } else {
            echo "Login failed, invalid email or password";
        }
        $stmt->close();
    }

    $conn->close();
}
?>
