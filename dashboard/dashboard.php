<?php
    session_start();
    require_once "../db_connection.php";
    require_once "../authorisation_check.php";

    $user_id = $_SESSION["user_id"];

    $tsql = "SELECT F_Name,
                    L_Name,
                    Email
            FROM [dbo].[User]
            WHERE User_ID = ?            
    ";

    $params = array($user_id);
    $stmt = sqlsrv_query($conn, $tsql, $params);
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    $full_name = $user["F_Name"] . " " . $user["L_Name"];
    $email = $user["Email"];

    $initials = strtoupper($user["F_Name"][0] . $user["L_Name"][0]);
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

    <!-- HARD CODED SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="img/logo.svg" class="sidebar-logo" />
            <div class="sidebar-title">OSRH</div>
            <div class="sidebar-sub">Admin Portal</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-item active" onclick="window.location.href='../dashboard/dashboard.php'">Dashboard</div>
            <div class="nav-item" onclick="window.location.href='../users/users.php'">Users</div>
            <div class="nav-item" onclick="window.location.href='../drivers/drivers.php'">Drivers</div>
            <div class="nav-item" onclick="window.location.href='../vehicles/vehicles.php'">Vehicles</div>
            <div class="nav-item" onclick="window.location.href='../trips/trips.php'">Trips</div>
            <div class="nav-item" onclick="window.location.href='../payments/payments.php'">Payments</div>
            <div class="nav-item" onclick="window.location.href='../reports/reports.php'">Reports</div>
            <div class="nav-item" onclick="window.location.href='../gdpr/gdpr.php'">GDPR</div>

            <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>

            <div class="nav-item" onclick="window.location.href='../simulation/simulation.php'">User Simulation</div>
        </nav>
    </aside>

    <main class="content">
        <header class="topbar">
            <h1 class="page-title">Dashboard</h1>

            <div class="profile-box">
                <button class="logout-btn" onclick="window.location.href='../index.php'">Logout</button>
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
                <div class="stat-value">12,483</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Active Drivers</div>
                <div class="stat-value">3,247</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Vehicles in Service</div>
                <div class="stat-value">2,891</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Total Trips</div>
                <div class="stat-value">47,892</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">GDPR Requests</div>
                <div class="stat-value">14</div>
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
</body>

</html>