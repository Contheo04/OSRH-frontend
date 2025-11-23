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
    <title>OSRH – Vehicles</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="vehicles.css" />
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

            <!-- ADMIN SECTION -->
            <div class="nav-item" onclick="window.location.href='../dashboard/dashboard.php'">Dashboard</div>
            <div class="nav-item" onclick="window.location.href='../users/users.php'">Users</div>
            <div class="nav-item" onclick="window.location.href='../drivers/drivers.php'">Drivers</div>
            <div class="nav-item active">Vehicles</div>
            <div class="nav-item" onclick="window.location.href='../trips/trips.php'">Trips</div>
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
            <h1 class="page-title">Vehicles</h1>

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
            <input type="text" class="search-input" placeholder="Search vehicles..." />

            <select class="filter-select">
                <option value="">Car Type</option>
                <option>SUV</option>
                <option>Sedan</option>
                <option>Taxi</option>
                <option>Van</option>
            </select>

            <select class="filter-select">
                <option value="">Seats</option>
                <option>2</option>
                <option>4</option>
                <option>5</option>
                <option>7</option>
            </select>
        </section>

        <section class="panel table-panel">
            <table class="vehicles-table">
                <thead>
                    <tr>
                        <th>License Plate</th>
                        <th>Frame Number</th>
                        <th>Engine Number</th>
                        <th>Car Type</th>
                        <th>Load Space</th>
                        <th>Seats</th>
                        <th>Owner ID</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>KYZ-2043</td>
                        <td>FRM9034234</td>
                        <td>ENGR234982</td>
                        <td>Sedan</td>
                        <td>0.68 m³</td>
                        <td>5</td>
                        <td>1</td>
                        <td class="actions">
                            <button class="action-btn" onclick="window.location.href='vehicle_view.php'">View</button>
                            <button class="action-btn"
                                onclick="window.location.href='vehicle_documents.php'">Documents</button>
                            <button class="action-btn"
                                onclick="window.location.href='vehicle_inspection.php'">Inspection</button>
                            <button class="action-btn" onclick="window.location.href='vehicle_edit.php'">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>TAX-1120</td>
                        <td>FRM1289371</td>
                        <td>ENG4438291</td>
                        <td>Taxi</td>
                        <td>0.75 m³</td>
                        <td>4</td>
                        <td>2</td>
                        <td class="actions">
                            <button class="action-btn" onclick="window.location.href='vehicle_view.php'">View</button>
                            <button class="action-btn"
                                onclick="window.location.href='vehicle_documents.php'">Documents</button>
                            <button class="action-btn"
                                onclick="window.location.href='vehicle_inspection.php'">Inspection</button>
                            <button class="action-btn" onclick="window.location.href='vehicle_edit.php'">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                </tbody>

            </table>
        </section>
    </main>

</body>

</html>