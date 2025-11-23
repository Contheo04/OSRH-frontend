<?php
session_start();
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $username = $_POST["username"];
    $password = $_POST["password"];

    if($username === "" || $password === ""){
        $_SESSION["login_error"] = "Please enter both username and password.";
        header("Location: index.php");
        exit();
    }

    $tsql = "SELECT User_ID, Username, Password, Type_ID
             FROM [dbo].[User]
             WHERE Username = ?";

    $params = array($username);
    $stmt = sqlsrv_query($conn, $tsql, $params);

    if ($stmt === false){
        $_SESSION["login_error"] = "Database error occured.";
        header("Location: index.php");
        exit();
    }
        
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if(!$row){
        $_SESSION["login_error"] = "User not found.";
        header("Location: index.php");
        exit();
    }

    if ($password !== $row["Password"]) {
        $_SESSION["login_error"] = "Incorrect password";
        header("Location: index.php");
        exit();
    }

    if((int)$row["Type_ID"] !== 1){
        $_SESSION["login_error"] = "Access restricted: Only Administrators may log in.";
        header("Location: index.php");
        exit();
    }

            
    // Store OSRH login session
    $_SESSION["user_id"] = $row["User_ID"];
    $_SESSION["username"] = $row["Username"];
    $_SESSION["role"] = $row["Type_ID"];            

    header("Location: ./dashboard/dashboard.php");
    exit();
    
}

header("Location: index.php");
exit();
?>
