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
    <title>OSRH – GDPR Requests</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="gdpr.css" />
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
                <!-- MAIN NAV -->
                <div class="nav-item" onclick="window.location.href='../dashboard/dashboard.php'">Dashboard</div>
                <div class="nav-item" onclick="window.location.href='../users/users.php'">Users</div>
                <div class="nav-item" onclick="window.location.href='../drivers/drivers.php'">Drivers</div>
                <div class="nav-item" onclick="window.location.href='../vehicles/vehicles.php'">Vehicles</div>
                <div class="nav-item" onclick="window.location.href='../trips/trips.php'">Trips</div>
                <div class="nav-item" onclick="window.location.href='../payments/payments.php'">Payments</div>
                <div class="nav-item" onclick="window.location.href='../reports/reports.php'">Reports</div>
                <div class="nav-item active" onclick="window.location.href='../gdpr/gdpr.php'">GDPR</div>

                <!-- BLUE LINE SEPARATOR -->
                <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>

            </nav>
        </aside>

        <main class="content">
            <header class="topbar">
                <h1 class="page-title">GDPR Requests</h1>

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
                <input type="text" class="search-input" placeholder="Search GDPR requests..." />

                <select class="filter-select">
                    <option value="">Pending Status</option>
                    <option value="Y">Pending</option>
                    <option value="N">Completed</option>
                </select>

                <select class="filter-select">
                    <option value="">Approval Status</option>
                    <option value="Y">Approved</option>
                    <option value="N">Rejected</option>
                </select>
            </section>

            <section class="panel table-panel">
                <table class="gdpr-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>User (Requested By)</th>
                            <th>Managed By</th>
                            <th>Issue Date</th>
                            <th>Pending</th>
                            <th>Approval</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>12</td>
                            <td>87</td>
                            <td>4</td>
                            <td>2024-02-01</td>
                            <td>Pending</td>
                            <td>-</td>
                            <td class="actions">
                                <button class="action-btn">Approve</button>
                                <button class="action-btn">Reject</button>
                            </td>
                        </tr>

                        <tr>
                            <td>13</td>
                            <td>104</td>
                            <td>4</td>
                            <td>2024-01-23</td>
                            <td>Completed</td>
                            <td>Approved</td>
                            <td class="actions">
                                <button class="action-btn">View</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </section>

        </main>
    </div>

</body>

</html>