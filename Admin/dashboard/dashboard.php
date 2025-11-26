<?php
    session_start();
    require_once "../../db_connection.php";
    require_once "../../authorisation_check.php";

    $user_id = $_SESSION["user_id"];
    $full_name = $_SESSION["fname"] . " " . $_SESSION["lname"];
    $email = $_SESSION["email"];
    $initials = strtoupper($_SESSION["fname"][0] . $_SESSION["lname"][0]);

    $tsql = "{CALL [dbo].[GetDashboardStats]}";
    $stmt = sqlsrv_query($conn, $tsql);
    $stats = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    $usersCnt       = $stats['TotalUsers'];
    $driversCnt     = $stats['ActiveDrivers'];
    $vehiclesCnt    = $stats['VehiclesInService'];
    $tripsCnt       = $stats['TotalTrips'];
    $reqsCnt        = $stats['GdprRequests'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OSRH – Admin Dashboard</title>
    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="dashboard.css" />
</head>

<body>
    <div class="background-glow glow-left"></div>
    <div class="background-glow glow-right"></div>

    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="img/logo.svg" class="sidebar-logo" />
                <div class="sidebar-title">OSRH</div>
                <div class="sidebar-sub">Admin Portal</div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item active" onclick="window.location.href='../dashboard/dashboard.php'">Dashboard
                </div>
                <div class="nav-item" onclick="window.location.href='../users/users.php'">Users</div>
                <div class="nav-item" onclick="window.location.href='../drivers/drivers.php'">Drivers</div>
                <div class="nav-item" onclick="window.location.href='../vehicles/vehicles.php'">Vehicles</div>
                <div class="nav-item" onclick="window.location.href='../trips/trips.php'">Trips</div>
                <div class="nav-item" onclick="window.location.href='../payments/payments.php'">Payments</div>
                <div class="nav-item" onclick="window.location.href='../reports/reports.php'">Reports</div>
                <div class="nav-item" onclick="window.location.href='../gdpr/gdpr.php'">GDPR</div>

                <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>

            </nav>
        </aside>

        <main class="content">
            <header class="topbar">
                <h1 class="page-title">Dashboard</h1>

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

            <section class="panel stats-panel">
                <div class="stat-card">
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value">
                        <?= htmlspecialchars($usersCnt); ?>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-title">Active Drivers</div>
                    <div class="stat-value">
                        <?= htmlspecialchars($driversCnt); ?>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-title">Vehicles in Service</div>
                    <div class="stat-value">
                        <?= htmlspecialchars($vehiclesCnt); ?>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-title">Total Trips</div>
                    <div class="stat-value">
                        <?= htmlspecialchars($tripsCnt); ?>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-title">GDPR Requests</div>
                    <div class="stat-value">
                        <?= htmlspecialchars($reqsCnt
                        ); ?>
                    </div>
                </div>
            </section>

            <section class="panel quick-links">
                <h2 class="section-title">More Info</h2>

                <div class="info-grid">

                    <div class="info-card">
                        <h3>System Information</h3>
                        <p>Version: <strong>1.0.0</strong></p>
                        <p>Last Update: <strong>2 days ago</strong></p>
                        <p>Status: <span class="status-tag ok">Operational</span></p>
                    </div>

                    <div class="info-card">
                        <h3>Admin Notifications</h3>
                        <p>Pending Reviews: <strong>8</strong></p>
                        <p>Unassigned Drivers: <strong>3</strong></p>
                        <p>System Alerts: <strong>0</strong></p>
                    </div>

                    <div class="info-card">
                        <h3>Security Overview</h3>
                        <p>Two-Factor Authentication: <strong>Enabled</strong></p>
                        <p>Encrypted Storage: <strong>Active</strong></p>
                        <p>Firewall Status: <span class="status-tag ok">Secure</span></p>
                    </div>

                </div>
            </section>

        </main>
    </div>
</body>

</html>