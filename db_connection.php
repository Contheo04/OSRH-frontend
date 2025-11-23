<?php
    session_start();

    $serverName = "mssql.cs.ucy.ac.cy";

    $connectionOptions = array(
        "Uid" => "dkalli02",
        "PWD" => "LDA8Duev",
        "CharacterSet" => "UTF-8"
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die("<strong>SQL CONNECTION FAILED:</strong><br>" . print_r(sqlsrv_errors(), true));
    }
?>