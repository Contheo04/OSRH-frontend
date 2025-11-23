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
    <title>OSRH – User Simulation</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="simulation.css" />
    <style>
        .sim-container {
            padding: 25px;
        }

        .panel {
            margin-bottom: 25px;
        }

        .sim-option {
            padding: 14px 20px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            margin: 8px 0;
            cursor: pointer;
            transition: 0.25s;
        }

        .sim-option:hover {
            background: rgba(0, 150, 255, 0.25);
            border-color: rgba(0, 150, 255, 0.4);
        }
    </style>
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
            <div class="nav-item" onclick="window.location.href='../trips/trips.php'">Trips</div>
            <div class="nav-item" onclick="window.location.href='../payments/payments.php'">Payments</div>
            <div class="nav-item" onclick="window.location.href='../reports/reports.php'">Reports</div>
            <div class="nav-item" onclick="window.location.href='../gdpr/gdpr.php'">GDPR</div>

            <!-- BLUE LINE -->
            <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>

            <!-- USER SIMULATION SECTION -->
            <div class="nav-item active" onclick="window.location.href='simulation.php'">
                User Simulation
            </div>
        </nav>
    </aside>

    <main class="content sim-container">
        <header class="topbar">
            <h1 class="page-title">User Simulation</h1>

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
            <h2 class="section-title">Passenger View</h2>

            <div class="sim-option" onclick="alert('Not implemented – this is a mock option.\n(Passenger Profile)')">
                View Profile
            </div>

            <div class="sim-option" onclick="alert('Trip request UI mock – nothing implemented yet.')">
                Request Trip (Mock)
            </div>

            <div class="sim-option" onclick="alert('Opens passenger trip history (mock).')">
                Trip History
            </div>

            <div class="sim-option" onclick="alert('Opens passenger payment history (mock).')">
                Payments
            </div>

            <div class="sim-option" onclick="alert('Opens passenger feedback (mock).')">
                Feedback
            </div>
        </section>
    </main>

</body>

</html>