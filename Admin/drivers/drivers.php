<?php
    session_start();
    require_once "../../db_connection.php";
    require_once "../../authorisation_check.php";

    $user_id = $_SESSION["user_id"];
    $full_name = $_SESSION["fname"] . " " . $_SESSION["lname"];
    $email = $_SESSION["email"];
    $initials = strtoupper($_SESSION["fname"][0] . $_SESSION["lname"][0]);

    $tsql = "SELECT *
             FROM [dbo].[User]
             WHERE Type_ID = 3;";

    $stmt = sqlsrv_query($conn, $tsql);
    
    $drivers = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $drivers[] = $row;
    }   
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OSRH – Drivers</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="drivers.css" />
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
                <div class="nav-item active">Drivers</div>
                <div class="nav-item" onclick="window.location.href='../vehicles/vehicles.php'">Vehicles</div>
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
                <h1 class="page-title">Drivers</h1>

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
                <input type="text" class="search-input" placeholder="Search drivers..." />

                <select class="filter-select">
                    <option value="">Driver Status</option>
                    <option>Active</option>
                    <option>Pending</option>
                    <option>Blocked</option>
                </select>

                <select class="filter-select">
                    <option value="">Document Status</option>
                    <option>Complete</option>
                    <option>Missing</option>
                    <option>Rejected</option>
                    <option>Expired</option>
                </select>

                <select class="filter-select">
                    <option value="">Vehicle Assigned</option>
                    <option>Assigned</option>
                    <option>Unassigned</option>
                </select>
            </section>

            <section class="panel table-panel">
                <table class="drivers-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Rating</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($drivers as $d): ?>
                            <tr>
                                <td><?= htmlspecialchars($d["User_ID"]); ?></td>
                                <td><?= htmlspecialchars($d["F_Name"]); ?></td>
                                <td><?= htmlspecialchars($d["L_Name"]); ?></td>
                                <td><?= htmlspecialchars($d["Email"]); ?></td>
                                <td><?= htmlspecialchars($d["Rating"]); ?></td>

                                <td class="actions">
                                    <button class="action-btn"
                                            onclick="window.location.href='view.php?id=<?= $d['User_ID'] ?>'">
                                        View
                                    </button>

                                    <button class="action-btn"
                                            onclick="window.location.href='documents.php?id=<?= urlencode($d['User_ID']) ?>&fn=<?= urlencode($d['F_Name']) ?>'">
                                        Documents
                                    </button>

                                    <button class="delete-btn"
                                            onclick="window.location.href='disable.php?id=<?= $d['User_ID'] ?>'">
                                        Disable
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </section>
        </main>
    </div>
</body>

</html>