<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipe Form</title>
<link rel="stylesheet" href="RecipeStyle.css">
</head>
<body id="Recipe_Form">
    <main>
        <nav>
            <img src="logo2.png" class="Logo">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Dashboard</a></li>
            </ul>
        </nav>
        <div class="Recipe_Form_Box" style="height: 540px; margin-bottom: 10px;">
            <form method="POST" action="Recipies.php" enctype="multipart/form-data">
                <p>Recipe Name</p>
                <input type="text" name="Recipe_Name" placeholder="Enter Recipe name" required>
                <p>Owner Name</p>
                <input type="text" name="Owner_Name" placeholder="Enter Owner name" required>
                <p>Ingredients</p>
                <textarea  style="height: 70px;" id="Ingredients" name="Ingredients" rows="7" required></textarea>
                <p>Instruction</p>
                <textarea style="height: 70px;" id="Instruction" name="Instruction" rows="7" required></textarea>
                <p>Recipe Image</p>
                <input type="file" id="Recipe_Image" name="Recipe_Image" accept="image/*" required>
                <p>Category</p>

                <select id="category_name" name="category_name" required style="color: black;">
                    <option value="" selected disabled>No category selected</option>
                
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
                    
                    // Execute query to fetch categories
                    $sql = "SELECT category_name FROM category";
                    $result = $conn->query($sql);
                    
                    if ($result === false) {
                        // Handle query execution error
                        echo "Error executing query: " . $conn->error;
                    } else {
                        // Check if there are results
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                // Ensure correct column name is used
                                echo "<option value=\"" . htmlspecialchars($row['category_name']) . "\" style=\"color: black;\">" . htmlspecialchars($row['category_name']) . "</option>";
                            }
                        } else {
                            // No categories available
                            echo "<option value=\"\">No categories available</option>";
                        }
                    }
                    
                    // Close connection
                    $conn->close();
                    ?>

                </select><br>
                <input type="submit" value="Submit" style="padding:8px 40px; margin: 12px;">
            </form>
        </div>
    </main>
</body>
</html>
