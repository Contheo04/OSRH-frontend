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
    <title>OSRH – Trips</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="trips.css" />
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
                <div class="nav-item" onclick="window.location.href='../vehicles/vehicles.php'">Vehicles</div>
                <div class="nav-item active" onclick="window.location.href='../trips/trips.php'">Trips</div>
                <div class="nav-item" onclick="window.location.href='../payments/payments.php'">Payments</div>
                <div class="nav-item" onclick="window.location.href='../reports/reports.php'">Reports</div>
                <div class="nav-item" onclick="window.location.href='../gdpr/gdpr.php'">GDPR</div>

                <!-- BLUE LINE SEPARATOR -->
                <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>


            </nav>
        </aside>

        <main class="content">
            <header class="topbar">
                <h1 class="page-title">Trips</h1>

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
                <input type="text" class="search-input" placeholder="Search trips..." />

                <select class="filter-select">
                    <option value="">Method</option>
                    <option>Card</option>
                    <option>Cash</option>
                    <option>Online</option>
                </select>
            </section>

            <section class="panel table-panel">
                <table class="trips-table">
                    <thead>
                        <tr>
                            <th>Trip ID</th>
                            <th>Payment Time</th>
                            <th>Payment Method</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2024-02-15 14:22</td>
                            <td>Card</td>
                            <td class="actions">
                                <button class="action-btn"
                                    onclick="window.location.href='segments.php?tt_id=1'">Segments</button>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>2024-02-16 10:05</td>
                            <td>Cash</td>
                            <td class="actions">
                                <button class="action-btn"
                                    onclick="window.location.href='segments.php?tt_id=2'">Segments</button>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </section>
        </main>
    </div>
</body>

</html>