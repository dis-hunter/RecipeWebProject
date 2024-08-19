<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Display Users</title>
    <style>
        body, html {
            background-color: #ccc;
            color: white;
            font-family: Arial, sans-serif;
        }
        .UserTable {
            background-color: #55fa55;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            margin: auto;
            margin-top: 50px;
        }
        .UserTable table {
            width: 100%;
            border-collapse: collapse;
        }
        .UserTable th, .UserTable td {
            padding: 10px;
            border: 1px solid #000;
            color: #fff;
        }
        .UserTable th {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="UserTable">
        <h2 style="color: white;">Display Users</h2>
        <?php

        $serverName = "localhost";
        $userName = "root";
        $password = "Leomessi10.";
        $dbName = "recipewebapp";
        $conn = new mysqli($serverName, $userName, $password, $dbName);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
            $FName = $_POST['Fname'];
            $LName = $_POST['Lname'];
            $Email = $_POST['Email'];
            $Username = $_POST['Username'];
            $UserImage = $_POST['UserImage'];

            // Update user in the database
            $sql = "UPDATE clientUsers SET Fname=?, Lname=?, Email=?, Username=?, UserImage=? WHERE Email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssss', $FName, $LName, $Email, $Username, $UserImage, $Email);
            if ($stmt->execute()) {
                echo "<p style='color: white;'>User Updated Successfully</p>";
            } else {
                echo "<p style='color: white;'>Error Updating User: " . $stmt->error . "</p>";
            }
        }

        // Fetch data from the table
        $sql = "SELECT Fname, Lname, Email, Username, UserImage FROM clientUsers";
        $result = $conn->query($sql);
        if ($result === false) {
            echo "Error executing query: " . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                echo "<table><tr><th>User Image</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Username</th><th>Action</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<form method='POST' action='displayusers.php'>";
                    echo "<td><img src='" . htmlspecialchars($row["UserImage"]) . "' alt='UserImage' width='50' height='50'></td>";
                    echo "<td><input type='text' name='Fname' value='" . htmlspecialchars($row['Fname']) . "'></td>";
                    echo "<td><input type='text' name='Lname' value='" . htmlspecialchars($row['Lname']) . "'></td>";
                    echo "<td><input type='email' name='Email' value='" . htmlspecialchars($row['Email']) . "' readonly></td>"; // Make email readonly
                    echo "<td><input type='text' name='Username' value='" . htmlspecialchars($row['Username']) . "'></td>";
                    echo "<input type='hidden' name='UserImage' value='" . htmlspecialchars($row['UserImage']) . "'>"; // Hidden input for UserImage
                    echo "<td><input type='submit' name='update_user' value='Update'></td>";
                    echo "</form>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: white;'>No User found</p>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
