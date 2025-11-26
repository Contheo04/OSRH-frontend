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
    <title>OSRH – Passenger Profile</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="profile.css" />
</head>

<body>

    <div class="background-glow glow-left"></div>
    <div class="background-glow glow-right"></div>

    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../dashboard/img/logo.svg" class="sidebar-logo" />
                <div class="sidebar-title">OSRH</div>
                <div class="sidebar-sub">Passenger Portal</div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item" onclick="window.location.href='../dashboard/dashboard.php'">Dashboard</div>
                <div class="nav-item active" onclick="window.location.href='profile.php'">Profile</div>
                <div class="nav-item" onclick="window.location.href='../request/request.php'">Request Trip</div>
                <div class="nav-item" onclick="window.location.href='../history/history.php'">Trip History</div>
                <div class="nav-item" onclick="window.location.href='../payments/payments.php'">Payments</div>
                <div class="nav-item" onclick="window.location.href='../feedback/feedback.php'">Feedback</div>

                <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>
                <div class="nav-item logout" onclick="window.location.href='../../index.php'">Log Out</div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="content">

            <!-- Header -->
            <header class="topbar">
                <h1 class="page-title">Profile</h1>

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

            <!-- PERSONAL INFORMATION -->
            <section class="panel personal-section">
                <div class="panel-header">
                    <h2 class="section-title">Personal Information</h2>
                    <button class="edit-btn" onclick="enableEdit('personal')">Edit</button>
                </div>

                <div class="profile-grid personal">

                    <!-- NAME -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Name:</strong> Passenger User</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Name:</strong> <input type="text" value="Passenger User">
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Email:</strong> passenger@example.com</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Email:</strong> <input type="email" value="passenger@example.com">
                        </div>
                    </div>

                    <!-- PHONE -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Phone:</strong> +357 99001122</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Phone:</strong> <input type="text" value="+357 99001122">
                        </div>
                    </div>

                    <!-- GENDER -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Gender:</strong> M</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Gender:</strong>
                            <select>
                                <option selected>M</option>
                                <option>F</option>
                                <option>Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- BIRTH DATE -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Birth Date:</strong> 1998-05-14</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Birth Date:</strong> <input type="date" value="1998-05-14">
                        </div>
                    </div>

                    <!-- ADDRESS -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Address:</strong> Nicosia, Cyprus</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Address:</strong> <input type="text" value="Nicosia, Cyprus">
                        </div>
                    </div>

                </div>

                <button id="save-personal" class="save-btn" style="display:none;" onclick="saveEdit('personal')">Save
                    Changes</button>
                <button id="cancel-personal" class="cancel-btn" style="display:none;"
                    onclick="cancelEdit('personal')">Cancel</button>

            </section>

            <!-- SETTINGS / PREFERENCES -->
            <section class="panel prefs-section">
                <div class="panel-header">
                    <h2 class="section-title">Settings & Preferences</h2>
                    <button class="edit-btn" onclick="enableEdit('prefs')">Edit</button>
                </div>

                <div class="profile-grid prefs">

                    <!-- DARK MODE -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Dark Mode:</strong> Enabled</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Dark Mode:</strong>
                            <select>
                                <option>Enabled</option>
                                <option>Disabled</option>
                            </select>
                        </div>
                    </div>

                    <!-- LANGUAGE -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Language:</strong> English</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Language:</strong>
                            <select>
                                <option selected>English</option>
                                <option>Greek</option>
                            </select>
                        </div>
                    </div>

                    <!-- FONT SIZE -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Font Size:</strong> 16px</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Font Size:</strong>
                            <input type="number" min="10" max="30" value="16">
                        </div>
                    </div>

                    <!-- LOCATION SERVICES -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Location Services:</strong> Allowed</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Location Services:</strong>
                            <select>
                                <option>Allowed</option>
                                <option>Blocked</option>
                            </select>
                        </div>
                    </div>

                    <!-- NOTIFICATIONS -->
                    <div class="info-item">
                        <div class="view-mode"><strong>Notifications:</strong> On</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>Notifications:</strong>
                            <select>
                                <option>On</option>
                                <option>Off</option>
                            </select>
                        </div>
                    </div>

                    <!-- REGION -->
                    <div class="info-item">
                        <div class="view-mode"><strong>App Region:</strong> Cyprus</div>
                        <div class="edit-mode" style="display:none;">
                            <strong>App Region:</strong>
                            <input type="text" value="Cyprus">
                        </div>
                    </div>

                </div>

                <button id="save-prefs" class="save-btn" style="display:none;" onclick="saveEdit('prefs')">Save
                    Changes</button>
                <button id="cancel-prefs" class="cancel-btn" style="display:none;"
                    onclick="cancelEdit('prefs')">Cancel</button>

            </section>

        </main>
    </div>

</body>

<script>

    function enableEdit(section) {

        document.querySelectorAll(`.${section} .view-mode`)
            .forEach(el => el.style.display = "none");

        document.querySelectorAll(`.${section} .edit-mode`)
            .forEach(el => el.style.display = "flex");

        document.getElementById(`save-${section}`).style.display = "inline-block";
        document.getElementById(`cancel-${section}`).style.display = "inline-block";
    }

    function cancelEdit(section) {

        document.querySelectorAll(`.${section} .edit-mode`)
            .forEach(el => el.style.display = "none");


        document.querySelectorAll(`.${section} .view-mode`)
            .forEach(el => el.style.display = "flex");

        document.getElementById(`save-${section}`).style.display = "none";
        document.getElementById(`cancel-${section}`).style.display = "none";
    }

    function saveEdit(section) {

        // TODO: Add PHP integration:

        // For now, simply switch back to normal view
        cancelEdit(section);
    }

</script>


</html>