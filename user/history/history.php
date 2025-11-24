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
    <title>OSRH – Trip History</title>

    <link rel="stylesheet" href="../globals.css" />
    <link rel="stylesheet" href="./history.css" />
</head>

<body>

    <!-- Glows -->
    <div class="background-glow glow-left"></div>
    <div class="background-glow glow-right"></div>
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../../dashboard/img/logo.svg" class="sidebar-logo" />
                <div class="sidebar-title">OSRH</div>
                <div class="sidebar-sub">Passenger Portal</div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item" onclick="window.location.href='../dashboard/dashboard.php'">Dashboard</div>
                <div class="nav-item" onclick="window.location.href='../profile/profile.php'">Profile</div>
                <div class="nav-item" onclick="window.location.href='../request/request.php'">Request Trip</div>
                <div class="nav-item active" onclick="window.location.href='history.php'">Trip History</div>
                <div class="nav-item" onclick="window.location.href='../payments/payments.php'">Payments</div>
                <div class="nav-item" onclick="window.location.href='../feedback/feedback.php'">Feedback</div>

                <div style="border-top:1px solid rgba(0,150,255,0.35); margin:18px 0;"></div>
                <div class="nav-item logout" onclick="window.location.href='../../index.php'">Log Out</div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="content">

            <header class="topbar">
                <h1 class="page-title">Trip History</h1>

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

            <!-- Trip History Table -->
            <section class="panel">
                <h2 class="section-title">Your Trips</h2>

                <table class="trip-table">
                    <thead>
                        <tr>
                            <th>Trip ID</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Driver</th>
                            <th>Price (€)</th>
                            <th>Status</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <!-- Example Row -->
                        <tr>
                            <td>204</td>
                            <td>2024-04-10</td>
                            <td>Acropolis</td>
                            <td>Mall of Cyprus</td>
                            <td>Michael Ioannou</td>
                            <td>12.50</td>
                            <td><span class="status-tag completed">Completed</span></td>
                            <td style="text-align:right;">
                                <button class="feedback-btn" onclick="openFeedbackModal(204)">Give Feedback</button>
                            </td>
                        </tr>

                        <tr>
                            <td>199</td>
                            <td>2024-04-07</td>
                            <td>Strovolos</td>
                            <td>Lakatamia</td>
                            <td>Peter Andreou</td>
                            <td>9.80</td>
                            <td><span class="status-tag cancelled">Cancelled</span></td>
                            <td style="text-align:right;">
                                <button class="feedback-btn" onclick="openFeedbackModal(199)">Give Feedback</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </section>

            <!-- FEEDBACK MODAL -->
            <div id="feedbackModal" class="modal-overlay" style="display:none;">
                <div class="modal-panel">

                    <h2 class="modal-title">Give Feedback</h2>

                    <div class="modal-rating">
                        <span class="star" data-value="1">★</span>
                        <span class="star" data-value="2">★</span>
                        <span class="star" data-value="3">★</span>
                        <span class="star" data-value="4">★</span>
                        <span class="star" data-value="5">★</span>
                    </div>

                    <textarea id="feedbackComment" class="modal-textarea"
                        placeholder="Write your comments..."></textarea>

                    <div class="modal-buttons">
                        <button class="modal-btn cancel" onclick="closeFeedbackModal()">Cancel</button>
                        <button class="modal-btn submit" onclick="submitFeedback()">Submit</button>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- FEEDBACK JS -->
    <script>
        let selectedRating = 0;
        let selectedTripID = null;

        function openFeedbackModal(tripID) {
            selectedTripID = tripID;
            document.getElementById("feedbackModal").style.display = "flex";
        }

        function closeFeedbackModal() {
            document.getElementById("feedbackModal").style.display = "none";
            resetFeedbackForm();
        }

        function resetFeedbackForm() {
            selectedRating = 0;
            document.querySelectorAll(".star").forEach(s => s.classList.remove("active"));
            document.getElementById("feedbackComment").value = "";
        }

        // star click behavior
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".star").forEach(star => {
                star.addEventListener("click", function () {
                    selectedRating = this.dataset.value;

                    document.querySelectorAll(".star").forEach(s => s.classList.remove("active"));

                    for (let i = 0; i < selectedRating; i++) {
                        document.querySelectorAll(".star")[i].classList.add("active");
                    }
                });
            });
        });

        function submitFeedback() {
            const comment = document.getElementById("feedbackComment").value;

            // Placeholder for now
            alert(
                "Feedback submitted:\n" +
                "Trip ID: " + selectedTripID + "\n" +
                "Rating: " + selectedRating + "\n" +
                "Comment: " + comment
            );

            closeFeedbackModal();
        }
    </script>

</body>

</html>