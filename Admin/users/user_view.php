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

    $genders = [
        "M" => "Male",
        "F" => "Female",
    ]
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OSRH – User Profile</title>

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
                <h1 class="page-title"><?= htmlspecialchars($ufname); ?>'s Profile</h1>

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

            <!-- Basic Information -->
            <section class="panel">
                <h2 class="section-title">Basic Information</h2>

                <div class="user-info-grid">
                    <div class="info-item"><strong>User ID:</strong>
                        <?= htmlspecialchars( $uid); ?>
                    </div>
                    <div class="info-item"><strong>Username:</strong>
                        <?= htmlspecialchars( $uusername); ?>
                    </div>
                    <div class="info-item"><strong>First Name:</strong>
                        <?= htmlspecialchars( $ufname); ?>
                    </div>
                    <div class="info-item"><strong>Last Name:</strong>
                        <?= htmlspecialchars( $ulname); ?>
                    </div>
                    <div class="info-item"><strong>Email:</strong>
                        <?= htmlspecialchars( $uemail); ?>
                    </div>
                    <div class="info-item"><strong>Phone:</strong>
                        <?= htmlspecialchars( $uphone); ?>
                    </div>
                    <div class="info-item"><strong>Gender:</strong>
                        <?= htmlspecialchars( $genders[$ugender] ?? "Other"); ?>
                    </div>
                    <div class="info-item"><strong>Birth Date:</strong>
                        <?= htmlspecialchars( $ubdate); ?>
                    </div>
                    <div class="info-item"><strong>Address:</strong>
                        <?= htmlspecialchars( $uaddress); ?>
                    </div>
                </div>
            </section>

            <!-- Account Information -->
            <section class="panel">
                <h2 class="section-title">Account Details</h2>

                <div class="user-info-grid">
                    <div class="info-item"><strong>Type:</strong>
                        <?= htmlspecialchars( $userTypes[$utype]); ?>
                    </div>
                    <div class="info-item"><strong>Rating:</strong>
                        <?= htmlspecialchars( $urating); ?>
                    </div>
                </div>
            </section>

            <!-- Related Data (Dynamic Placeholder for PHP)
            <section class="panel">
                <h2 class="section-title">Related User Data</h2>

                <p>This section will dynamically show related information based on the user type.</p>

                <ul class="related-list">
                    <li>If user is a <strong>Driver</strong>: show Driver Documents, Assigned Vehicle, Trip History.
                    </li>
                    <li>If user is a <strong>Simple User</strong>: show Trip History, Feedback Written.</li>
                    <li>If user is an <strong>Operator</strong>: show Reviewed Docs, Inspections Performed.</li>
                </ul>
            </section> -->

            <!-- Action Buttons -->
            <section class="panel action-panel">
                <button class="action-btn" 
                    onclick="window.location.href='user_edit.php?id=<?= urlencode($uid) ?>'">
                    Edit
                </button>
                
                <button class="delete-btn">GDPR Delete</button>
            </section>

        </main>
    </div>
</body>

</html>