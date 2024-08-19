<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure the user is logged in and is a recipe owner
if (!isset($_SESSION['Username']) || $_SESSION['Usertype'] != 'Recipe Owner') {
    header("Location: index.php"); // Redirect to appropriate location for recipe owners
    exit;
}

// Database connection setup
$serverName = "localhost";
$userName = "root";
$password = "Leomessi10.";
$dbName = "recipewebapp";

$conn = new mysqli($serverName, $userName, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$username = $_SESSION['Username'];
$query = "SELECT * FROM clientusers WHERE Username=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recipe Owner Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
          body {font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #55fa55;
            color: black;
            padding: 10px 0;
            text-align: center;
        }
        .header .user-info {
            margin: 0;
            padding: 10px;
        }
        .header .user-info a {
            color: #f4f4f4;
            text-decoration: none;
            margin-left: 10px;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #f4f4f4;
            padding-bottom: 10px;
        }
        p {
            color: #666;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #333;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #555;
        }
        .profile-pic {
            max-width: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }
    
    </style>
</head>
<body>
    <div class="header">
        <div class="user-info">
            Welcome, <?php echo htmlspecialchars($_SESSION['Username']); ?> | <a href="login.html">Logout</a>
        </div>
    </div>
    <div class="container">
        <h2>Your Profile</h2>
        <!-- Display user profile information -->
        <?php if (!empty($user['UserImage'])): ?>
            <img src="<?php echo htmlspecialchars($user['UserImage']); ?>" alt="Profile Picture" class="profile-pic">
        <?php endif; ?>
        <p><strong>User_ID:</strong> <?php echo htmlspecialchars($user['user_id']); ?></p>
        <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['FName']); ?></p>
        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['LName']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['Username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
        <!-- Link to add recipe page -->
        <h2>Add a Recipe</h2>
        <a href="RecipeForm.php" class="btn">Add </a>
        <h2>View Recipies</h2>
        <a href="displayUserRecipe.php" class="btn">View</a>
        <h2>Edit Recipes</h2>
        <a href="update_recipe.php" class=btn>Edit</a>
    </div>
</body>
</html>
