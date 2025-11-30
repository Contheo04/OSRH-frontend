<?php
    session_start();
    require_once "../../db_connection.php";
    require_once "../../authorisation_check.php";

    $user_id = $_SESSION["user_id"];
    $full_name = $_SESSION["fname"] . " " . $_SESSION["lname"];
    $email = $_SESSION["email"];
    $initials = strtoupper($_SESSION["fname"][0] . $_SESSION["lname"][0]);

    $lp     = $_GET['lp'];
    $utype  = $_GET['utype'];

    if ($utype == 'Driver') {
        $tsql = "SELECT V.*,
                 U.User_ID AS DriverUserID,
                 U.F_Name AS DriverFName,
                 U.L_Name AS DriverLName
                 FROM [dbo].[Vehicle] V
                 LEFT JOIN [dbo].[User] U ON V.Driver_ID = U.User_ID
                 WHERE V.License_Plate = ?;"; 
    } else if ($utype == 'Representative') {
        $tsql = "SELECT V.*,
                 U.User_ID AS RepUserID,
                 U.F_Name AS RepFName,
                 U.L_Name AS RepLName
                 FROM [dbo].[Vehicle] V
                 LEFT JOIN [dbo].[User] U ON V.Company_Rep_ID = U.User_ID
                 WHERE V.License_Plate = ?;";
    }

    $params = array($lp);
    $stmt = sqlsrv_query($conn, $tsql, $params);
    $vinfo = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    
    if ($utype == "Driver") {
        $ownerName = $vinfo["DriverFName"] . " " . $vinfo["DriverLName"];
        $ownerID = $vinfo["DriverUserID"];
    } elseif ($utype == "Representative") {
        $ownerName = $vinfo["RepFName"] . " " . $vinfo["RepLName"];
        $ownerID = $vinfo["RepUserID"];
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OSRH – Vehicle Profile</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="../vehicles/vehicles.css" />
</head>

<body>
    <div class="background-glow glow-left"></div>
    <div class="background-glow glow-right"></div>

    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../dashboard/img/logo.svg" class="sidebar-logo" />
                <div class="sidebar-title">OSRH</div>
                <div class="sidebar-sub">Admin Portal</div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item" onclick="window.location.href='../dashboard/dashboard.php'">Dashboard</div>
                <div class="nav-item" onclick="window.location.href='../users.php'">Users</div>
                <div class="nav-item" onclick="window.location.href='../drivers/drivers.php'">Drivers</div>
                <div class="nav-item active" onclick="window.location.href='../vehicles/vehicles.php'">Vehicles</div>
                <div class="nav-item" onclick="window.location.href='../trips/trips.php'">Trips</div>
                <div class="nav-item" onclick="window.location.href='../payments/payments.php'">Payments</div>
                <div class="nav-item" onclick="window.location.href='../reports/reports.php'">Reports</div>
                <div class="nav-item" onclick="window.location.href='../gdpr/gdpr.php'">GDPR</div>

                <!-- BLUE LINE SEPARATOR -->
                <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>

            </nav>
        </aside>

        <main class="content">
            <header class="topbar">                
                <h1 class="page-title"><?= htmlspecialchars($ownerName); ?>'s Vehicle Profile</h1>

                <div class="profile-box">
                    <button class="logout-btn" onclick="window.location.href='../../index.php'">Logout</button>
                    <div class="profile-info">
                        <div class="profile-name">
                            <?= htmlspecialchars($full_name); ?>
                        </div>
                        <div class="profile-email">
                            <?= htmlspecialchars($email); ?>
                        </div>
                    </div>
                    <div class="profile-circle">
                        <?= htmlspecialchars($initials); ?>
                    </div>
                </div>
            </header>

            <!-- Basic Information -->
            <section class="panel">
                <h2 class="section-title">Vehicle Information</h2>

                <div class="vehicles-info-grid">
                    <div class="info-item"><strong>License Plate:</strong>
                        <?= htmlspecialchars( $vinfo["License_Plate"]); ?>
                    </div>
                    <div class="info-item"><strong>Frame No.:</strong>
                        <?= htmlspecialchars( $vinfo["Frame_Number"]); ?>
                    </div>
                    <div class="info-item"><strong>Engine No.:</strong>
                        <?= htmlspecialchars( $vinfo["Engine_Number"]); ?>
                    </div>
                    <div class="info-item"><strong>Car Type:</strong>
                        <?= htmlspecialchars( $vinfo["Car_Type"]); ?>
                    </div>
                    <div class="info-item"><strong>Load Space:</strong>
                        <?= htmlspecialchars($vinfo["Load_Space"]); ?> m³
                    </div>
                    <div class="info-item"><strong>Seats:</strong>
                        <?= htmlspecialchars( $vinfo["Number_Of_Seats"]); ?>
                    </div>
                    <div class="info-item"><strong>Owner ID:</strong>
                        <?= htmlspecialchars( $ownerID); ?>
                    </div>
                    <div class="info-item"><strong>Owner Name:</strong>
                        <?= htmlspecialchars( $ownerName); ?>
                    </div>
                    <div class="info-item"><strong>Owner Type:</strong>
                        <?= htmlspecialchars( $utype); ?>
                    </div>
            </section>

            <!-- Action Buttons -->
            <section class="panel action-panel">
                <button class="action-btn" 
                    onclick="window.location.href=
                    'vehicle_documents.php?lp=<?= urlencode($vinfo["License_Plate"]); ?>
                    &fn=<?= urlencode($vinfo["Frame_Number"]); ?>
                    &en=<?= urlencode($vinfo["Engine_Number"]); ?>'">
                    Documents
                </button>

                <button class="action-btn" 
                    onclick="window.location.href='vehicle_inspection.php?lp=<?= urlencode($vinfo["License_Plate"]); ?>
                    &fn=<?= urlencode($vinfo["Frame_Number"]); ?>
                    &en=<?= urlencode($vinfo["Engine_Number"]); ?>'">
                    Inspections
                </button>
            </section>

        </main>
    </div>
</body>

</html>