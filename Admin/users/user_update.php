<?php
    session_start();
    require_once "../../db_connection.php";
    require_once "../../authorisation_check.php";

    $uid      = (int) $_GET['id'];
    $fname    = $_POST['F_Name'];
    $lname    = $_POST['L_Name'];
    $username = $_POST['Username'];
    $email    = $_POST['Email'];
    $phone    = $_POST['Phone'];
    $gender   = $_POST['Gender'];
    $bdate    = $_POST['B_Date'];
    $address  = $_POST['Address'];
    $password = $_POST['Password'];
    $confirm  = $_POST['PasswordConfirm'];

    if ($password !== "" || $confirm !== "") {

        if ($password !== $confirm) {
            $_SESSION['edit_error'] = "Passwords do not match.";
            header("Location: user_edit.php?id=" . $uid);
            exit();
        }

    } else {
        $password = NULL;
    }
    
    $tsql = "{CALL UpdateUser(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)}";

    $params = [
        $uid,
        $username,
        $password,   // now dynamic (hashed or NULL)
        $email,
        $fname,
        $lname,
        $phone,
        $gender,
        $bdate,
        $address
    ];

    $stmt = sqlsrv_prepare($conn, $tsql, $params);
    sqlsrv_execute($stmt);

    header("Location: users.php?success=1");
    exit();
?>
