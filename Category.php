<?php
$serverName="localhost";
$username="root";
$password="Leomessi10.";
$dbName="recipewebapp";

$conn = new mysqli($serverName, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "Connected Successfully";
}
if($_SERVER["REQUEST_METHOD"]=="POST"){

 $CategoryName=$_POST["Category_name"];

    $sql="INSERT INTO Category (Category_Name) values (?)";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("s", $CategoryName);
    if($stmt->execute()){
        echo "New category added";
        header("Location: admin_dashboard.php");
    }else{
        echo "Error: " . $stmt->error;
    }
$stmt->close();
}else{
    echo "Form not submited";
}

$conn->close();
?>