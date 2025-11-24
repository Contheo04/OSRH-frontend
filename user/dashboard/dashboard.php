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
    <title>OSRH – Passenger Dashboard</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="./dashboard.css" />
</head>

<body>

    <!-- Glows -->
    <div class="background-glow glow-left"></div>
    <div class="background-glow glow-right"></div>

    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../../dashboard/img/logo.svg" class="sidebar-logo" />
                <div class="sidebar-title">OSRH</div>
                <div class="sidebar-sub">Passenger Portal</div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item active" onclick="window.location.href='dashboard.php'">Dashboard</div>
                <div class="nav-item" onclick="window.location.href='../profile/profile.php'">Profile</div>
                <div class="nav-item" onclick="window.location.href='../request/request.php'">Request Trip</div>
                <div class="nav-item" onclick="window.location.href='../history/history.php'">Trip History</div>
                <div class="nav-item" onclick="window.location.href='../payments/payments.php'">Payments</div>
                <div class="nav-item" onclick="window.location.href='../feedback/feedback.php'">Feedback</div>

                <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>
                <div class="nav-item logout" onclick="window.location.href='../../index.php'">Log Out</div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="content">

            <!-- Top Bar -->
            <header class="topbar">
                <h1 class="page-title">Hi, Passenger User</h1>

                <div class="profile-box">
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

            <!-- Stats Overview -->
            <section class="panel">
                <h2 class="section-title">Your Overview</h2>

                <div class="stats-grid">
                    <div class="stat-card">
                        <h3 class="stat-label">Total Trips</h3>
                        <div class="stat-value">32</div>
                    </div>

                    <div class="stat-card">
                        <h3 class="stat-label">Average Rating</h3>
                        <div class="stat-value">4.6 ★</div>
                    </div>

                    <div class="stat-card">
                        <h3 class="stat-label">Total Spent</h3>
                        <div class="stat-value">€241.30</div>
                    </div>

                    <div class="stat-card">
                        <h3 class="stat-label">Last Trip</h3>
                        <div class="stat-value">2024-04-10</div>
                    </div>

                    <div class="stat-card">
                        <h3 class="stat-label">Frequent Driver</h3>
                        <div class="stat-value">M. Ioannou</div>
                    </div>
                </div>
            </section>

            <!-- Recent Trips -->
            <section class="panel">
                <h2 class="section-title">Recent Trips</h2>

                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Trip ID</th>
                            <th>Date</th>
                            <th>Driver</th>
                            <th>Price (€)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>204</td>
                            <td>2024-04-10</td>
                            <td>Michael Ioannou</td>
                            <td>12.50</td>
                        </tr>

                        <tr>
                            <td>199</td>
                            <td>2024-04-07</td>
                            <td>Peter Andreou</td>
                            <td>9.80</td>
                        </tr>

                    </tbody>
                </table>
            </section>

        </main>
    </div>

</body>

</html>