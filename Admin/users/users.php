<?php
    session_start();
    require_once "../../db_connection.php";
    require_once "../../authorisation_check.php";

    $user_id = $_SESSION["user_id"];
    $full_name = $_SESSION["fname"] . " " . $_SESSION["lname"];
    $email = $_SESSION["email"];
    $initials = strtoupper($_SESSION["fname"][0] . $_SESSION["lname"][0]);

    $tsql = "SELECT *
            FROM [dbo].[User]";

    $stmt = sqlsrv_query($conn, $tsql);
    
    $users = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $users[] = $row;
    }

    $userTypes = [
        1 => "Admin",
        2 => "Operator",
        3 => "Driver",
        4 => "Basic User",
        5 => "Representative",
    ];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OSRH – Users</title>
    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="users.css" />
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
                <div class="nav-item active" onclick="window.location.href='users.php'">Users</div>
                <div class="nav-item" onclick="window.location.href='../drivers/drivers.php'">Drivers</div>
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
                <h1 class="page-title">Users</h1>

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
                <input type="text" class="search-input" placeholder="Search users..." />
                <select class="filter-select">
                    <option value="">All Types</option>
                    <option value="admin">Administrators</option>
                    <option value="operator">System Operators</option>
                    <option value="driver">Drivers</option>
                    <option value="user">Simple Users</option>
                </select>
                <select class="filter-select">
                    <option value="">Status</option>
                    <option>Active</option>
                    <option>Pending</option>
                    <option>Disabled</option>
                </select>
                <button class="add-btn">+ Add User</button>
            </section>

            <section class="panel table-panel">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= htmlspecialchars($u["User_ID"]); ?></td>
                                <td><?= htmlspecialchars($u["F_Name"]); ?></td>
                                <td><?= htmlspecialchars($u["L_Name"]); ?></td>
                                <td><?= htmlspecialchars($u["Email"]); ?></td>
                                <td><?= htmlspecialchars($userTypes[$u["Type_ID"]]); ?></td>

                                <td class="actions">
                                    <button class="action-btn"
                                            onclick="window.location.href='user_view.php?id=<?= urlencode($u['User_ID']) ?>'">
                                        View
                                    </button>

                                    <button class="action-btn"
                                            onclick="window.location.href='user_edit.php?id=<?= urlencode($u['User_ID']) ?>'">
                                        Edit
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