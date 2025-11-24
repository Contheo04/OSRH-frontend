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
    <title>OSRH – Payments</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="./payments.css" />
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
                <div class="nav-item" onclick="window.location.href='../dashboard/dashboard.php'">Dashboard</div>
                <div class="nav-item" onclick="window.location.href='../profile/profile.php'">Profile</div>
                <div class="nav-item" onclick="window.location.href='../request/request.php'">Request Trip</div>
                <div class="nav-item" onclick="window.location.href='../history/history.php'">Trip History</div>
                <div class="nav-item active" onclick="window.location.href='payments.php'">Payments</div>
                <div class="nav-item" onclick="window.location.href='../feedback/feedback.php'">Feedback</div>

                <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>
                <div class="nav-item logout" onclick="window.location.href='../../index.php'">Log Out</div>
            </nav>
        </aside>

        <!-- Content -->
        <main class="content">

            <header class="topbar">
                <h1 class="page-title">Payments</h1>

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

            <section class="panel">
                <h2 class="section-title">Payment History</h2>

                <table class="payment-table">
                    <thead>
                        <tr>
                            <th>Trip ID</th>
                            <th>Payment Time</th>
                            <th>Method</th>
                            <th>Amount (€)</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Example rows -->

                        <tr>
                            <td>204</td>
                            <td>2024-04-10 14:22</td>
                            <td>Card</td>
                            <td>12.50</td>
                            <td><span class="status-tag paid">Paid</span></td>
                        </tr>

                        <tr>
                            <td>199</td>
                            <td>2024-04-07 10:41</td>
                            <td>Cash</td>
                            <td>9.80</td>
                            <td><span class="status-tag paid">Paid</span></td>
                        </tr>

                    </tbody>
                </table>
            </section>

        </main>
    </div>

</body>

</html>