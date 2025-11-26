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
    <title>OSRH – Request Trip</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="request.css" />
</head>

<body>

    <div class="background-glow glow-left"></div>
    <div class="background-glow glow-right"></div>

    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../dashboard/img/logo.svg" class="sidebar-logo" />
                <div class="sidebar-title">OSRH</div>
                <div class="sidebar-sub">Passenger Portal</div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item" onclick="window.location.href='../dashboard/dashboard.php'">Dashboard</div>
                <div class="nav-item" onclick="window.location.href='../profile/profile.php'">Profile</div>
                <div class="nav-item active" onclick="window.location.href='request.php'">Request Trip</div>
                <div class="nav-item" onclick="window.location.href='../history/history.php'">Trip History</div>
                <div class="nav-item" onclick="window.location.href='../payments/payments.php'">Payments</div>
                <div class="nav-item" onclick="window.location.href='../feedback/feedback.php'">Feedback</div>

                <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>
                <div class="nav-item logout" onclick="window.location.href='../../index.php'">Log Out</div>
            </nav>
        </aside>

        <main class="content">

            <header class="topbar">
                <h1 class="page-title">Request Trip</h1>

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
                <h2 class="section-title">Trip Details</h2>

                <form class="request-form">

                    <div class="form-group">
                        <label class="form-label">Pickup Location</label>
                        <input type="text" class="form-input" placeholder="Enter your pickup point...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Dropoff Location</label>
                        <input type="text" class="form-input" placeholder="Enter your destination...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Service Type</label>
                        <select class="form-input">
                            <option>Standard</option>
                            <option>Premium</option>
                            <option>XL</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pickup Time</label>
                        <select class="form-input">
                            <option>Now</option>
                            <option>Schedule</option>
                        </select>
                    </div>

                    <div class="form-group schedule-group" style="display:none;">
                        <label class="form-label">Select Date & Time</label>
                        <input type="datetime-local" class="form-input">
                    </div>

                    <button type="button" class="submit-btn">Submit Request</button>

                </form>
            </section>

        </main>
    </div>

    <script>
        // Show scheduler only when "Schedule" is selected
        document.querySelectorAll("select")[1].addEventListener("change", function () {
            const scheduleGroup = document.querySelector(".schedule-group");
            scheduleGroup.style.display = (this.value === "Schedule") ? "block" : "none";
        });
    </script>

</body>

</html>