<?php
session_start();

$isLoggedIn = isset($_SESSION["user_id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>LearnSmart AI - Home</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f3ff;
            color: #263238;
        }

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            padding: 20px 7%;
            background: linear-gradient(90deg, #4527a0, #1976d2);
            color: white;
            box-shadow: 0 4px 15px #00000015;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .nav-links a:hover {
            color: #ffeb3b;
        }

        .nav-btn {
            background: white;
            color: #4527a0 !important;
            padding: 11px 18px;
            border-radius: 8px;
        }

        /* Hero Section */
        .hero {
            padding: 85px 7%;
            text-align: center;
            color: white;
            background: linear-gradient(
                135deg,
                #673ab7,
                #3f51b5,
                #2196f3
            );
        }

        .hero h1 {
            font-size: 46px;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .hero h1 span {
            color: #ffeb3b;
        }

        .hero p {
            max-width: 700px;
            margin: 0 auto 30px;
            font-size: 18px;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn {
            display: inline-block;
            padding: 14px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-primary {
            background: #ffeb3b;
            color: #39217d;
        }

        .btn-secondary {
            border: 2px solid white;
            color: white;
        }

        .btn:hover {
            transform: translateY(-3px);
        }

        /* Features */
        .section {
            padding: 65px 7%;
        }

        .section-title {
            text-align: center;
            color: #4527a0;
            font-size: 32px;
            margin-bottom: 15px;
        }

        .section-description {
            text-align: center;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 35px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(220px, 1fr)
            );
            gap: 24px;
        }

        .feature-card {
            background: white;
            padding: 30px 24px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 8px 25px #4527a010;
            border-bottom: 5px solid #7c4dff;
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 14px 30px #4527a025;
        }

        .feature-card:nth-child(2) {
            border-bottom-color: #ff9800;
        }

        .feature-card:nth-child(3) {
            border-bottom-color: #00b894;
        }

        .feature-card:nth-child(4) {
            border-bottom-color: #2196f3;
        }

        .feature-icon {
            font-size: 42px;
            margin-bottom: 18px;
        }

        .feature-card h3 {
            color: #4527a0;
            margin-bottom: 13px;
        }

        .feature-card p {
            color: #64748b;
            line-height: 1.7;
        }

        /* Call to Action */
        .cta {
            margin: 0 7% 60px;
            padding: 45px 25px;
            text-align: center;
            color: white;
            background: linear-gradient(90deg, #4527a0, #1976d2);
            border-radius: 22px;
        }

        .cta h2 {
            margin-bottom: 15px;
            font-size: 30px;
        }

        .cta p {
            line-height: 1.7;
            margin-bottom: 25px;
        }

        /* Footer */
        footer {
            background: #20134b;
            color: white;
            text-align: center;
            padding: 25px;
            line-height: 1.8;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 18px 5%;
            }

            .logo {
                font-size: 21px;
            }

            .nav-links {
                gap: 14px;
            }

            .hero {
                padding: 60px 6%;
            }

            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 16px;
            }

            .section {
                padding: 45px 6%;
            }

            .section-title {
                font-size: 27px;
            }

            .cta {
                margin: 0 5% 40px;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar">

        <div class="logo">
            🎓 LearnSmart AI
        </div>

        <div class="nav-links">

            <a href="index.php">Home</a>

            <?php if ($isLoggedIn): ?>

                <a href="dashboard.php" class="nav-btn">
                    Dashboard
                </a>

                <a href="logout.php">Logout</a>

            <?php else: ?>

                <a href="login.php">Login</a>

                <a href="register.php" class="nav-btn">
                    Register
                </a>

            <?php endif; ?>

        </div>

    </nav>

    <!-- Hero Section -->
    <section class="hero">

        <h1>
            Learn Smarter.<br>
            Grow <span>Faster!</span> 🚀
        </h1>

        <p>
            Welcome to LearnSmart AI, your personalized
            learning platform. Explore courses, practice
            your skills, complete assignments and track
            your learning progress in one place.
        </p>

        <div class="hero-buttons">

            <?php if ($isLoggedIn): ?>

                <a href="dashboard.php" class="btn btn-primary">
                    Go to Dashboard →
                </a>

            <?php else: ?>

                <a href="register.php" class="btn btn-primary">
                    Get Started →
                </a>

                <a href="login.php" class="btn btn-secondary">
                    Login to Continue
                </a>

            <?php endif; ?>

        </div>

    </section>

    <!-- Features Section -->
    <section class="section">

        <h2 class="section-title">
            Everything You Need to Learn
        </h2>

        <p class="section-description">
            Build your skills with a simple and personalized
            learning experience.
        </p>

        <div class="features">

            <div class="feature-card">
                <div class="feature-icon">📚</div>

                <h3>Learning Courses</h3>

                <p>
                    Explore available courses and learn
                    new concepts step by step.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📝</div>

                <h3>Assignments</h3>

                <p>
                    Practice what you learn and submit
                    assignments to improve your skills.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📊</div>

                <h3>Track Progress</h3>

                <p>
                    Monitor your assignment completion
                    and follow your learning journey.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">💡</div>

                <h3>Recommendations</h3>

                <p>
                    Discover useful learning resources
                    and explore new topics.
                </p>
            </div>

        </div>

    </section>

    <!-- Call to Action -->
    <section class="cta">

        <h2>Ready to Start Learning? 🎯</h2>

        <p>
            Take the next step toward your goals.
            Start learning and improve your skills today!
        </p>

        <?php if ($isLoggedIn): ?>

            <a href="dashboard.php" class="btn btn-primary">
                Open Dashboard
            </a>

        <?php else: ?>

            <a href="register.php" class="btn btn-primary">
                Create Your Account
            </a>

        <?php endif; ?>

    </section>

    <!-- Footer -->
    <footer>
        <p>© <?php echo date("Y"); ?> LearnSmart AI</p>
        <p>Keep Learning, Keep Growing! 💜</p>
    </footer>

</body>
</html>