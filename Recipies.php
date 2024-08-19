<?php
session_start();
$ServerName = "localhost";
$db_Password = "Leomessi10.";
$db_Username = "root";
$db_Name = "recipewebapp";

// Create connection
$conn = new mysqli($ServerName, $db_Username, $db_Password, $db_Name);

// Check connection
if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
} else {
    echo "Connected Successfully<br>";
}

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit a recipe.");
}

// Debugging statement to check user_id


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $RecipeName = $_POST['Recipe_Name'];
    $RecipeOwner = $_POST['Owner_Name'];
    $Instructions = $_POST['Instruction'];
    $Ingredients = $_POST['Ingredients'];
    $user_id = $_SESSION['user_id']; // Retrieve user_id from session

    // Debugging statement to check user_id after retrieval
    echo "User ID from session: " . $user_id . "<br>";

    $Category = $_POST['category_name']; // Get the selected category

    // Check if file was uploaded without errors
    if (isset($_FILES["Recipe_Image"]) && $_FILES["Recipe_Image"]["error"] == 0) {
        $target_directory = "uploads/";

        if (!file_exists($target_directory)) {
            mkdir($target_directory, 0777, true);
        }

        $target_file = $target_directory . basename($_FILES['Recipe_Image']['name']);
        $ImageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        $check = getimagesize($_FILES['Recipe_Image']['tmp_name']);
        if ($check === false) {
            die("File is not an image.");
        }

        // Validate file size
        if ($_FILES["Recipe_Image"]["size"] > 2000000) {
            die("File is too large.");
        }

        // Allow file formats
        $allowed_types = array("jpg", "jpeg", "png", "gif");
        if (!in_array($ImageFileType, $allowed_types)) {
            die("File type is not allowed.");
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES['Recipe_Image']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO recepies (user_id, recipe_name, recipe_owner, ingredients, instructions, recipe_image, category_name) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssss", $user_id, $RecipeName, $RecipeOwner, $Ingredients, $Instructions, $target_file, $Category);

            if ($stmt->execute()) {
                echo "New recipe created successfully<br>";
                header("Location: recipe_owner_dashboard.php");
            } else {
                echo "Failed to add recipe: " . $stmt->error . "<br>";
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    } else {
        echo "No file was uploaded or there was an error with the upload.<br>";
    }
} else {
    echo "Form not submitted correctly.<br>";
}

$conn->close();
?>
