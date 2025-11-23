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
    <title>OSRH – Trip Segments</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="segments.css" />
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
            <div class="nav-item" onclick="window.location.href='../vehicles/vehicles.php'">Vehicles</div>
            <div class="nav-item active" onclick="window.location.href='../trips/trips.php'">Trips</div>
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
            <h1 class="page-title">Trip Segments</h1>

            <div class="profile-box">
                <button class="logout-btn" onclick="window.location.href='../index.php'">Logout</button>
                <div class="profile-info">
                    <div class="profile-name">Admin User</div>
                    <div class="profile-email">admin@osrh.com</div>
                </div>
                <div class="profile-circle">AU</div>
            </div>
        </header>

        <section class="panel search-panel">
            <button class="back-btn" onclick="window.location.href='trips.php'">← Back to Trips</button>
            <div class="trip-info">Trip ID: <strong>1</strong></div>
        </section>

        <section class="panel table-panel">
            <table class="segments-table">
                <thead>
                    <tr>
                        <th>Segment ID</th>
                        <th>Driver ID</th>
                        <th>User ID</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Distance (km)</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>101</td>
                        <td>34</td>
                        <td>87</td>
                        <td>Limassol</td>
                        <td>Nicosia</td>
                        <td>2024-02-15 13:10</td>
                        <td>2024-02-15 14:00</td>
                        <td>68.2</td>

                        <td class="actions">
                            <button class="action-btn" onclick="window.location.href='messages.php'">Messages</button>
                        </td>
                    </tr>

                    <tr>
                        <td>102</td>
                        <td>34</td>
                        <td>87</td>
                        <td>Nicosia</td>
                        <td>Lakatamia</td>
                        <td>2024-02-15 14:02</td>
                        <td>2024-02-15 14:22</td>
                        <td>7.4</td>

                        <td class="actions">
                            <button class="action-btn" onclick="window.location.href='messages.php'">Messages</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>


    </main>
</body>

</html>