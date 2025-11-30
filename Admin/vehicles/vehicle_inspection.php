<?php
    session_start();
    require_once "../../db_connection.php";
    require_once "../../authorisation_check.php";

    $user_id = $_SESSION["user_id"];
    $full_name = $_SESSION["fname"] . " " . $_SESSION["lname"];
    $email = $_SESSION["email"];
    $initials = strtoupper($_SESSION["fname"][0] . $_SESSION["lname"][0]);

    $vid1   = $_GET['lp'];
    $vid2   = $_GET['fn'];
    $vid3   = $_GET['en'];

    $tsql = "SELECT *
             FROM [dbo].[Vehicle_Inspection]
             WHERE License_Plate = ?
                AND Frame_Number = ? 
                AND Engine_Number = ?;";

    $params = array($vid1, $vid2, $vid3);
    $stmt = sqlsrv_query($conn, $tsql, $params);

    $inspections = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $inspections[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OSRH – Vehicle Inspection</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="vehicle_inspection.css" />
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
                <h1 class="page-title">Vehicle Inspection</h1>

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

            <section class="panel">
                <button class="back-btn" onclick="window.location.href='vehicles.php'">← Back to Vehicles</button>

                <h2 class="section-title">Inspection Records</h2>

                <table class="inspection-table">
                    <thead>
                        <tr>
                            <th>Inspection ID</th>
                            <th>Result</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Operator ID</th>
                        </tr>
                    </thead>
                        
                    <tbody>
                        <?php foreach ($inspections as $i): ?>
                            <tr>
                                <td><?= htmlspecialchars($i["Insp_ID"]); ?></td>
                                <td>
                                    <span class="badge <?= htmlspecialchars(strtolower($i["Result"])); ?>">
                                    <?= htmlspecialchars($i["Result"]); ?></span>
                                </td>
                                <td><?= htmlspecialchars($i["Insp_Date"]); ?></td>
                                <td><?= htmlspecialchars($i["Description"]); ?></td>
                                <td><?= htmlspecialchars($i["Operator_ID"]); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>