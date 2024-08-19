<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and is a Recipe Owner


// Connect to database (adjust database credentials as per your setup)
$serverName = "localhost";
$userName = "root";
$password = "Leomessi10.";
$dbName = "recipewebapp";

$conn = new mysqli($serverName, $userName, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details based on user_id from session
$Category="Vegeterian dishes";
$query = "SELECT user_id, recipe_owner, recipe_name, ingredients, instructions, recipe_image, category_name FROM recepies WHERE category_name = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $Category);
    if (!$stmt->execute()) {
        die("Error executing query: " . $stmt->error);
    }
    $stmt->store_result();
    $stmt->bind_result($user_id, $recipe_owner, $recipe_name, $ingredients, $instructions, $recipe_image, $category_name);

    // Check if user has any recipes
    if ($stmt->num_rows > 0) {
        // Display user details in a form
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Recipes</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                h1 {
                    text-align: center;
                    color: #333;
                }
                form {
                    max-width: 800px;
                    margin: 20px auto;
                    padding: 20px;
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                .form-group {
                    margin-bottom: 15px;
                }
                label {
                    display: block;
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                input[type="text"], textarea {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }
                img {
                    max-width: 100%;
                    height: 300px;
                    display: block;
                    margin-top: 10px;
                }
                hr {
                    margin: 20px 0;
                    border: 0;
                    border-top: 1px solid #eee;
                }
            </style>
        </head>
        <body>
            <h1>Vegeterian Dishes</h1>
            <form>
                <?php while ($stmt->fetch()) { ?>
                    <div class="form-group">
                        <label>Recipe Name:</label>
                        <input type="text" value="<?php echo htmlspecialchars($recipe_name); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Recipe Owner:</label>
                        <input type="text" value="<?php echo htmlspecialchars($recipe_owner); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Ingredients:</label>
                        <textarea readonly><?php echo htmlspecialchars($ingredients); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Instructions:</label>
                        <textarea readonly><?php echo htmlspecialchars($instructions); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Categories:</label>
                        <input type="text" value="<?php echo htmlspecialchars($category_name); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Recipe Image:</label>
                        <img src="<?php echo htmlspecialchars($recipe_image); ?>" alt="Recipe Image">
                    </div>
                    <hr>
                <?php } ?>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "No recipes found ";
    }

    $stmt->close();
}

$conn->close();
?>
