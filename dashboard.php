<?php
session_start();

// Check login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Database connection
require_once "db.php";

// Get logged-in user
$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$_SESSION["user_id"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$name = htmlspecialchars(
    $user["name"] ?? "Student",
    ENT_QUOTES,
    "UTF-8"
);

// Count all assignments
$totalStmt = $pdo->query("SELECT COUNT(*) FROM assignments");
$totalAssignments = (int) $totalStmt->fetchColumn();

// Count assignments submitted by this user
$submittedStmt = $pdo->prepare(
    "SELECT COUNT(*) FROM submissions WHERE user_id = ?"
);
$submittedStmt->execute([$_SESSION["user_id"]]);

$submittedAssignments = (int) $submittedStmt->fetchColumn();

// Calculate progress
$progress = $totalAssignments > 0
    ? min(100, (int) round(
        ($submittedAssignments / $totalAssignments) * 100
    ))
    : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard - LearnSmart AI</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0c3fc, #8ec5fc);
            min-height: 100vh;
            color: #263238;
        }

        .navbar {
            background: linear-gradient(90deg, #4527a0, #1976d2);
            color: white;
            padding: 20px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 4px 15px #00000020;
        }

        .navbar h2 {
            color: white;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .logout {
            background: #ff4757;
            padding: 10px 16px;
            border-radius: 8px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 35px auto;
        }

        .welcome {
            background: white;
            padding: 35px;
            border-radius: 20px;
            margin-bottom: 28px;
            box-shadow: 0 8px 25px #00000012;
        }

        .welcome h1 {
            color: #4527a0;
            margin-bottom: 12px;
            font-size: 30px;
        }

        .welcome p {
            color: #64748b;
            line-height: 1.7;
        }

        .section-title {
            color: #4527a0;
            margin: 25px 0 18px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(220px, 1fr)
            );
            gap: 22px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 8px 20px #00000012;
            border-top: 6px solid #7c4dff;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px #00000020;
        }

        .course-card {
            border-top-color: #7c4dff;
        }

        .assignment-card {
            border-top-color: #ff9800;
        }

        .progress-card {
            border-top-color: #00b894;
        }

        .recommendation-card {
            border-top-color: #2196f3;
        }

        .card h3 {
            color: #4527a0;
            margin-bottom: 14px;
            font-size: 20px;
        }

        .card p {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(90deg, #673ab7, #3f51b5);
            color: white;
            padding: 11px 17px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background: linear-gradient(90deg, #ff6f00, #ff4081);
        }

        .progress-bar {
            width: 100%;
            height: 18px;
            background: #e5e7eb;
            border-radius: 20px;
            overflow: hidden;
            margin: 15px 0;
        }

        .progress-fill {
            height: 100%;
            width: <?php echo $progress; ?>%;
            background: linear-gradient(90deg, #00c853, #64dd17);
            border-radius: 20px;
        }

        .progress-number {
            font-size: 25px;
            color: #00a878;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 25px;
            color: #4527a0;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 18px;
            }

            .container {
                width: 94%;
            }

            .welcome {
                padding: 24px;
            }

            .welcome h1 {
                font-size: 24px;
            }

            .nav-links {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <h2>🎓 LearnSmart AI</h2>

        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </nav>

    <main class="container">

        <section class="welcome">
            <h1>
                Welcome, <?php echo $name; ?>! 🎓
            </h1>

            <p>
                Your personalized learning journey starts here.
                Learn new skills, complete assignments and track
                your learning progress.
            </p>
        </section>

        <h2 class="section-title">📚 Your Learning Dashboard</h2>

        <section class="dashboard-grid">

            <div class="card course-card">
                <h3>📚 My Courses</h3>

                <p>
                    Explore learning materials and course topics.
                </p>

                <a href="courses.php" class="btn">
                    View Courses
                </a>
            </div>

            <div class="card assignment-card">
                <h3>📝 Assignments</h3>

                <p>
                    View your assignments and complete your work.
                </p>

                <a href="assignments.php" class="btn">
                    View Assignments
                </a>
            </div>

            <div class="card progress-card">
                <h3>📊 Learning Progress</h3>

                <p>
                    Track your assignment completion.
                </p>

                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>

                <div class="progress-number">
                    <?php echo $progress; ?>%
                </div>

                <p>
                    <?php echo $submittedAssignments; ?>
                    assignments submitted out of
                    <?php echo $totalAssignments; ?> total.
                </p>
            </div>

            <div class="card recommendation-card">
                <h3>💡 Recommendations</h3>

                <p>
                    Discover learning resources to improve your skills.
                </p>

                <a href="recommendations.php" class="btn">
                    Explore Resources
                </a>
            </div>

        </section>

    </main>

    <footer class="footer">
        <p>© <?php echo date("Y"); ?> LearnSmart AI |
            Keep Learning, Keep Growing 🚀
        </p>
    </footer>

</body>
</html>