<?php
// Always start fresh for every user visit
session_start();

if (isset($_POST['connect'])) {

    $sqlDBname = trim($_POST['dbName']);
    $sqlUser   = trim($_POST['userName']);
    $sqlPass   = trim($_POST['pswd']);

    $errors = [];

    if ($sqlDBname === "") $errors[] = "Database name is empty.";
    if ($sqlUser === "")   $errors[] = "Username is empty.";
    if ($sqlPass === "")   $errors[] = "Password is empty.";

    if (empty($errors)) {

        // Prepare SQL connection details
        $serverName = "mssql.cs.ucy.ac.cy";
        $connectionOptions = array(
            "Database"     => $sqlDBname,
            "Uid"          => $sqlUser,
            "PWD"          => $sqlPass,
            "CharacterSet" => "UTF-8"
        );

        // Attempt to connect
        $conn = sqlsrv_connect($serverName, $connectionOptions);

        if ($conn === false) {
            // SQL Server rejected credentials → show error
            $errors[] = "SQL Server connection failed:<br>" . print_r(sqlsrv_errors(), true);
        } else {
            // SUCCESS → store credentials in session
            $_SESSION["serverName"]        = $serverName;
            $_SESSION["connectionOptions"] = $connectionOptions;

            // Close test connection
            sqlsrv_close($conn);

            // Redirect to OSRH login
            header("Location: index.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SQL Server Login</title>
</head>
<body>

<h2>Enter SQL Server Credentials</h2>

<?php if (!empty($errors)): ?>
    <div style="color:red; margin-bottom: 20px;">
        <?php foreach ($errors as $e): ?>
            <?= $e . "<br>" ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="connect.php">
    <label>Database Name:</label><br>
    <input type="text" name="dbName"><br><br>

    <label>Username:</label><br>
    <input type="text" name="userName"><br><br>

    <label>Password:</label><br>
    <input type="password" name="pswd"><br><br>

    <button type="submit" name="connect">Connect</button>
</form>

</body>
</html>