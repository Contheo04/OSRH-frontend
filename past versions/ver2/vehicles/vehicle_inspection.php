<?php
    session_start();
    require_once "../db_connection.php";
    require_once "../authorisation_check.php";
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

            <!-- USER SIMULATION SECTION -->
            <div class="nav-item section-label" onclick="window.location.href='../simulation/simulation.php'">
                User Simulation
            </div>
        </nav>
    </aside>

    <main class="content">
        <header class="topbar">
            <h1 class="page-title">Vehicle Inspection</h1>

            <div class="profile-box">
                <button class="logout-btn" onclick="window.location.href='../index.php'">Logout</button>
                <div class="profile-info">
                    <div class="profile-name">Admin User</div>
                    <div class="profile-email">admin@osrh.com</div>
                </div>
                <div class="profile-circle">AU</div>
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
                    <tr>
                        <td>12</td>
                        <td><span class="badge pass">Pass</span></td>
                        <td>2024-02-10</td>
                        <td>Routine check passed successfully.</td>
                        <td>55</td>
                    </tr>

                    <tr>
                        <td>13</td>
                        <td><span class="badge fail">Fail</span></td>
                        <td>2024-03-01</td>
                        <td>Brake issue detected during inspection.</td>
                        <td>55</td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>
</body>

</html>