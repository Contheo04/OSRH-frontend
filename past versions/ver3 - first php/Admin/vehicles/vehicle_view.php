<?php
    session_start();
    require_once "../../db_connection.php";
    require_once "../../authorisation_check.php";

    $user_id = $_SESSION["user_id"];
    $full_name = $_SESSION["fname"] . " " . $_SESSION["lname"];
    $email = $_SESSION["email"];
    $initials = strtoupper($_SESSION["fname"][0] . $_SESSION["lname"][0]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OSRH – View Vehicle</title>

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
                <h1 class="page-title">View Vehicle</h1>

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
                <h2 class="section-title">Vehicle Details</h2>

                <div class="details-grid">
                    <div><strong>License Plate:</strong> KYZ-2043</div>
                    <div><strong>Frame Number:</strong> FRM9034234</div>
                    <div><strong>Engine Number:</strong> ENGR234982</div>
                    <div><strong>Car Type:</strong> Sedan</div>
                    <div><strong>Load Space:</strong> 0.68 m³</div>
                    <div><strong>Seats:</strong> 5</div>
                    <div><strong>Owner ID:</strong> 1</div>
                    <div><strong>Geofence:</strong> 3</div>
                </div>

                <button class="action-btn" style="margin-top:20px;"
                    onclick="window.location.href='vehicle_documents.php'">
                    View Documents
                </button>
            </section>
        </main>
    </div>
</body>

</html>