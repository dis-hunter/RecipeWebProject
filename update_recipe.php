<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and is a Recipe Owner
if (!isset($_SESSION['user_id']) || $_SESSION['Usertype'] !== 'Recipe Owner') {
    // Redirect to login or unauthorized page if not logged in as Recipe Owner
    header("Location: login.php");
    exit;
}

// Connect to database (adjust database credentials as per your setup)
$serverName = "localhost";
$userName = "root";
$password = "Leomessi10.";
$dbName = "recipewebapp";

$conn = new mysqli($serverName, $userName, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_recipe'])) {
    $recipe_id = $_POST['recipe_id'];
    $recipe_name = $_POST['recipe_name'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $category_name = $_POST['category_name'];
    $recipe_image = $_POST['recipe_image'];

    // Update recipe in the database
    $sql = "UPDATE recepies SET recipe_name=?, ingredients=?, instructions=?, category_name=?, recipe_image=? WHERE recipe_id=? AND user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssi', $recipe_name, $ingredients, $instructions, $category_name, $recipe_image, $recipe_id, $_SESSION['user_id']);
    if ($stmt->execute()) {
        echo "<p style='color: white;'>Recipe Updated Successfully</p>";
        header("Location: displayUserRecipe.php");
        
    } else {
        echo "<p style='color: white;'>Error Updating Recipe: " . $stmt->error . "</p>";
    }
}

// Fetch recipes for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT recipe_id, recipe_name, ingredients, instructions, category_name, recipe_image FROM recepies WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Display Recipes</title>
    <style>
        body, html {
            background-color: #ccc;
            color: white;
            font-family: Arial, sans-serif;
        }
        .RecipeTable {
            background-color: #55fa55;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            margin: auto;
            margin-top: 50px;
        }
        .RecipeTable table {
            width: 100%;
            border-collapse: collapse;
        }
        .RecipeTable th, .RecipeTable td {
            padding: 10px;
            border: 1px solid #000;
            color: #fff;
        }
        .RecipeTable th {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="RecipeTable">
        <h2 style="color: white;">Display Recipes</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Recipe Image</th><th>Recipe Name</th><th>Ingredients</th><th>Instructions</th><th>Category</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<form method='POST' action=''>";
                echo "<td><img src='" . htmlspecialchars($row["recipe_image"]) . "' alt='Recipe Image' width='50' height='50'></td>";
                echo "<td><input type='text' name='recipe_name' value='" . htmlspecialchars($row['recipe_name']) . "'></td>";
                echo "<td><textarea name='ingredients'>" . htmlspecialchars($row['ingredients']) . "</textarea></td>";
                echo "<td><textarea name='instructions'>" . htmlspecialchars($row['instructions']) . "</textarea></td>";
                echo "<td><input type='text' name='category_name' value='" . htmlspecialchars($row['category_name']) . "'></td>";
                echo "<input type='hidden' name='recipe_id' value='" . htmlspecialchars($row['recipe_id']) . "'>";
                echo "<input type='hidden' name='recipe_image' value='" . htmlspecialchars($row['recipe_image']) . "'>";
                echo "<td><input type='submit' name='update_recipe' value='Update'></td>";
                echo "</form>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: white;'>No Recipes found</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
