<?php
session_start();
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query the database for this user
    $tsql = "SELECT User_ID, Username, Password, Type_ID 
             FROM [dbo].[User] 
             WHERE Username = ?";

    $params = array($username);
    $stmt = sqlsrv_query($conn, $tsql, $params);

    if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        
        // Compare password (plain for now — hashing later)
        if ($password === $row["Password"]) {
            
            // Store OSRH login session
            $_SESSION["user_id"] = $row["User_ID"];
            $_SESSION["role"] = $row["Type_ID"];
            $_SESSION["username"] = $row["Username"];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
