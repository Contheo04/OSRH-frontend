<?php
    session_start();
    require_once "../../db_connection.php";
    require_once "../../authorisation_check.php";

    $user_id = $_SESSION["user_id"];
    $full_name = $_SESSION["fname"] . " " . $_SESSION["lname"];
    $email = $_SESSION["email"];
    $initials = strtoupper($_SESSION["fname"][0] . $_SESSION["lname"][0]);

    $uid = (int) $_GET['id'];

    $tsql = 'SELECT *
             FROM [dbo].[User]
             WHERE User_ID = ?';  

    $params = array($uid);
    $stmt = sqlsrv_query($conn, $tsql, $params);
    $info = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    $uusername  = $info['Username'];
    $uemail     = $info['Email'];
    $ufname     = $info['F_Name'];
    $ulname     = $info['L_Name'];
    $uphone     = $info['Phone'];
    $ugender    = $info['Gender'];
    $ubdate     = $info['B_Date'];
    $uaddress   = $info['Address'];
    $urating    = $info['Rating'];
    $utype      = $info['Type_ID'];

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
    <title>OSRH – Edit User</title>

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
                <!-- MAIN NAV -->
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
                <h1 class="page-title">Edit <?= htmlspecialchars($ufname); ?>'s Profile</h1>

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

            <section class="panel">
                <h2 class="section-title">User Information</h2>

                <form class="edit-form" method="POST" action="user_update.php?id=<?= urldecode($uid); ?>">
                    
                    <div class="form-grid">

                        <div class="readonly-value">
                            <label>User ID</label>
                            <input type="text" name="User_ID" value=<?= htmlspecialchars($uid); ?> readonly />
                        </div>

                        <div class="readonly-value">
                            <label>Type</label>
                            <input type="text" name="Type_ID" value="<?= htmlspecialchars($userTypes[$utype]); ?>" readonly />
                        </div>

                        <div class="form-field">
                            <label>Password (leave blank to keep existing)</label>
                            <input type="password" name="Password" placeholder="Enter new password" />
                        </div>

                        <div class="form-field">
                            <label>Retype Password</label>
                            <input type="password" name="PasswordConfirm" placeholder="Retype new password" />
                        </div>

                        <?php if (isset($_SESSION['edit_error'])): ?>
                            <div style="color: #ff4d4d; margin-bottom: 10px; font-weight: 500;">
                                <?= htmlspecialchars($_SESSION['edit_error']); ?>
                            </div>
                            <?php unset($_SESSION['edit_error']); ?>
                        <?php endif; ?>


                        <div class="form-field">
                            <label>First Name</label>
                            <input type="text" name="F_Name" value="<?= htmlspecialchars($ufname); ?>" />
                        </div>

                        <div class="form-field">
                            <label>Last Name</label>
                            <input type="text" name="L_Name" value=<?= htmlspecialchars($ulname); ?> />
                        </div>

                        <div class="form-field">
                            <label>Username</label>
                            <input type="text" name="Username" value="<?= htmlspecialchars($uusername); ?>" />
                        </div>

                        <div class="form-field">
                            <label>Email</label>
                            <input type="email" name="Email" value="<?= htmlspecialchars($uemail); ?>" />
                        </div>

                        <div class="form-field">
                            <label>Phone</label>
                            <input type="text" name="Phone" value="<?= htmlspecialchars($uphone); ?>" />
                        </div>

                        <div class="form-field">
                            <label>Gender</label>
                            <select name="Gender">
                                <option value="M" <?= $ugender === "M" ? "selected" : "" ?>>Male</option>
                                <option value="F" <?= $ugender === "F" ? "selected" : "" ?>>Female</option>
                                <option value="O" <?= $ugender === "O" ? "selected" : "" ?>>Other</option>
                            </select>
                        </div>

                        <div class="form-field">
                            <label>Birth Date</label>
                            <input type="date" name="B_Date" value="<?= htmlspecialchars($ubdate); ?>" />
                        </div>

                        <div class="form-field">
                            <label>Address</label>
                            <input type="text" name="Address" value="<?= htmlspecialchars($uaddress); ?>" />
                        </div>

                    </div>

                    <div class="edit-actions">
                        <button type="submit" class="action-btn">Save Changes</button>
                        <button type="button" class="back-btn"
                            onclick="window.location.href='user_view.php?id=<?= urldecode($uid); ?>'">Cancel</button>
                    </div>

                </form>
            </section>

        </main>
    </div>

</body>

</html>