<?php
    session_start();
    require_once "../../db_connection.php";
    require_once "../../authorisation_check.php";

    $user_id = $_SESSION["user_id"];
    $full_name = $_SESSION["fname"] . " " . $_SESSION["lname"];
    $email = $_SESSION["email"];
    $initials = strtoupper($_SESSION["fname"][0] . $_SESSION["lname"][0]);

    $tsql = "SELECT V.*,
            U1.User_ID AS DriverUserID,
            U1.F_Name AS DriverFName,
            U1.L_Name AS DriverLName,
            U2.User_ID AS RepUserID,
            U2.F_Name AS RepFName,
            U2.L_Name AS RepLName
            FROM [dbo].[Vehicle] V
            LEFT JOIN [dbo].[User] U1 ON V.Driver_ID = U1.User_ID
            LEFT JOIN [dbo].[User] U2 ON V.Company_Rep_ID = U2.User_ID;";

    $stmt = sqlsrv_query($conn, $tsql);
    
    $vehicles = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $vehicles[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OSRH – Vehicles</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="vehicles.css" />
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

                <!-- ADMIN SECTION -->
                <div class="nav-item" onclick="window.location.href='../dashboard/dashboard.php'">Dashboard</div>
                <div class="nav-item" onclick="window.location.href='../users/users.php'">Users</div>
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
                <h1 class="page-title">Vehicles</h1>

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

            <section class="panel search-panel">
                <input type="text" class="search-input" placeholder="Search vehicles..." />

                <select class="filter-select">
                    <option value="">Car Type</option>
                    <option>SUV</option>
                    <option>Sedan</option>
                    <option>Taxi</option>
                    <option>Van</option>
                </select>

                <select class="filter-select">
                    <option value="">Seats</option>
                    <option>2</option>
                    <option>4</option>
                    <option>5</option>
                    <option>7</option>
                </select>
            </section>

            <section class="panel table-panel">
                <table class="vehicles-table">
                    <thead>
                        <tr>
                            <th>License Plate</th>
                            <th>Car Type</th>
                            <th>Owner ID</th>
                            <th>Owner Name</th>
                            <th>Owner Type</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($vehicles as $v): ?>

                            <?php
                                if ($v["DriverUserID"] !== null) {
                                    $ownerName = $v["DriverFName"] . " " . $v["DriverLName"];
                                    $ownerID = $v["DriverUserID"];
                                    $ownerType = "Driver";
                                } elseif ($v["RepUserID"] !== null) {
                                    $ownerName = $v["RepFName"] . " " . $v["RepLName"];
                                    $ownerID = $v["RepUserID"];
                                    $ownerType = "Representative";
                                }
                            ?>

                            <tr>
                                <td><?= htmlspecialchars($v["License_Plate"]); ?></td>
                                <td><?= htmlspecialchars($v["Car_Type"]); ?></td>
                                <td><?= htmlspecialchars($ownerID); ?></td>
                                <td><?= htmlspecialchars($ownerName); ?></td>
                                <td><?= htmlspecialchars($ownerType); ?></td>

                                <td class="actions">
                                    <button class="action-btn"
                                            onclick="window.location.href=
                                            'vehicle_view.php?lp=<?= urlencode($v["License_Plate"]); ?>&utype=<?= urlencode($ownerType); ?>'">
                                        View
                                    </button>

                                    <button class="action-btn"
                                            onclick="window.location.href=
                                            'vehicle_documents.php?lp=<?= urlencode($v["License_Plate"]); ?>
                                            &fn=<?= urlencode($v["Frame_Number"]); ?>
                                            &en=<?= urlencode($v["Engine_Number"]); ?>'">
                                        Documents
                                    </button>

                                    <button class="action-btn"
                                            onclick="window.location.href=
                                            'vehicle_inspection.php?lp=<?= urlencode($v["License_Plate"]); ?>
                                            &fn=<?= urlencode($v["Frame_Number"]); ?>
                                            &en=<?= urlencode($v["Engine_Number"]); ?>'">
                                        Inspection
                                    </button>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>


                </table>
            </section>
        </main>
    </div>

</body>

</html>