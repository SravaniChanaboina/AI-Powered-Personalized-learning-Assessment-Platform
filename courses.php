<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Load database connection
require_once "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Courses - LearnSmart AI</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f3ff;
            color: #263238;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(90deg, #4527a0, #1976d2);
            padding: 20px 6%;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 4px 15px #00000015;
        }

        .navbar h2 {
            font-size: 25px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-left: 18px;
        }

        .navbar .home-btn {
            background: white;
            color: #4527a0;
            padding: 10px 16px;
            border-radius: 8px;
        }

        /* Hero */
        .hero {
            padding: 55px 7%;
            background: linear-gradient(135deg, #7c4dff, #2196f3);
            color: white;
        }

        .hero h1 {
            font-size: 36px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 17px;
            line-height: 1.7;
        }

        /* Main */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 35px auto;
        }

        .section-heading {
            color: #4527a0;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .section-description {
            color: #64748b;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        /* Search */
        .search-box {
            margin-bottom: 30px;
        }

        .search-box input {
            width: 100%;
            padding: 15px;
            border: 2px solid #d1c4e9;
            border-radius: 12px;
            font-size: 16px;
            outline: none;
            background: white;
        }

        .search-box input:focus {
            border-color: #7c4dff;
            box-shadow: 0 0 8px #7c4dff30;
        }

        /* Course Grid */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(250px, 1fr)
            );
            gap: 25px;
        }

        .course-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 25px #00000012;
            transition: 0.3s;
        }

        .course-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 14px 30px #00000020;
        }

        .course-banner {
            padding: 30px 20px;
            text-align: center;
            color: white;
        }

        .course-banner .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .course-banner h3 {
            font-size: 23px;
        }

        .html-banner {
            background: linear-gradient(135deg, #ff7043, #ff9800);
        }

        .css-banner {
            background: linear-gradient(135deg, #2196f3, #3949ab);
        }

        .js-banner {
            background: linear-gradient(135deg, #fbc02d, #ff9800);
        }

        .python-banner {
            background: linear-gradient(135deg, #00897b, #26a69a);
        }

        .java-banner {
            background: linear-gradient(135deg, #e53935, #ad1457);
        }

        .database-banner {
            background: linear-gradient(135deg, #7c4dff, #512da8);
        }

        .course-content {
            padding: 24px;
        }

        .level {
            display: inline-block;
            background: #ede7f6;
            color: #5e35b1;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .course-content p {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 13px;
            margin-bottom: 8px;
            color: #475569;
        }

        .progress-bar {
            height: 10px;
            background: #e5e7eb;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress-fill {
            height: 100%;
            border-radius: 20px;
        }

        .html-progress {
            width: 35%;
            background: linear-gradient(90deg, #ff7043, #ff9800);
        }

        .css-progress {
            width: 20%;
            background: linear-gradient(90deg, #2196f3, #3949ab);
        }

        .js-progress {
            width: 10%;
            background: linear-gradient(90deg, #fbc02d, #ff9800);
        }

        .python-progress {
            width: 45%;
            background: linear-gradient(90deg, #00897b, #26a69a);
        }

        .java-progress {
            width: 15%;
            background: linear-gradient(90deg, #e53935, #ad1457);
        }

        .database-progress {
            width: 25%;
            background: linear-gradient(90deg, #7c4dff, #512da8);
        }

        .course-btn {
            display: block;
            text-align: center;
            background: linear-gradient(90deg, #673ab7, #3f51b5);
            color: white;
            text-decoration: none;
            padding: 12px;
            border-radius: 9px;
            font-weight: bold;
            transition: 0.3s;
        }

        .course-btn:hover {
            background: linear-gradient(90deg, #ff6f00, #ff4081);
        }

        .empty-message {
            display: none;
            background: white;
            color: #64748b;
            text-align: center;
            padding: 25px;
            margin-top: 20px;
            border-radius: 12px;
        }

        /* Footer */
        footer {
            margin-top: 50px;
            background: #20134b;
            color: white;
            text-align: center;
            padding: 25px;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 18px;
            }

            .navbar a {
                margin-left: 8px;
            }

            .hero {
                padding: 40px 6%;
            }

            .hero h1 {
                font-size: 29px;
            }

            .container {
                width: 94%;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar">
        <h2>🎓 LearnSmart AI</h2>

        <div>
            <a href="index.php" class="home-btn">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <h1>📚 Explore Your Courses</h1>

        <p>
            Learn new skills, practice coding and build
            your future one lesson at a time!
        </p>
    </section>

    <!-- Courses -->
    <main class="container">

        <h2 class="section-heading">My Learning Courses 🎯</h2>

        <p class="section-description">
            Discover programming courses and continue your learning journey.
        </p>

        <div class="search-box">
            <input
                type="text"
                id="courseSearch"
                placeholder="🔍 Search courses..."
                aria-label="Search courses"
            >
        </div>

        <div class="course-grid" id="courseGrid">

            <article class="course-card">
                <div class="course-banner html-banner">
                    <div class="icon">🌐</div>
                    <h3>HTML</h3>
                </div>

                <div class="course-content">
                    <span class="level">Beginner</span>
                    <p>Learn webpage structure, tags, links, images and forms.</p>

                    <div class="progress-label">
                        <span>Sample progress</span>
                        <span>35%</span>
                    </div>

                    <div class="progress-bar">
                        <div class="progress-fill html-progress"></div>
                    </div>

                    <a href="assignments.php" class="course-btn">
                        Start Learning →
                    </a>
                </div>
            </article>

            <article class="course-card">
                <div class="course-banner css-banner">
                    <div class="icon">🎨</div>
                    <h3>CSS</h3>
                </div>

                <div class="course-content">
                    <span class="level">Beginner</span>
                    <p>Learn colors, layouts, responsive design and animations.</p>

                    <div class="progress-label">
                        <span>Sample progress</span>
                        <span>20%</span>
                    </div>

                    <div class="progress-bar">
                        <div class="progress-fill css-progress"></div>
                    </div>

                    <a href="assignments.php" class="course-btn">
                        Start Learning →
                    </a>
                </div>
            </article>

            <article class="course-card">
                <div class="course-banner js-banner">
                    <div class="icon">⚡</div>
                    <h3>JavaScript</h3>
                </div>

                <div class="course-content">
                    <span class="level">Beginner</span>
                    <p>Practice variables, functions, events and interactive webpages.</p>

                    <div class="progress-label">
                        <span>Sample progress</span>
                        <span>10%</span>
                    </div>

                    <div class="progress-bar">
                        <div class="progress-fill js-progress"></div>
                    </div>

                    <a href="assignments.php" class="course-btn">
                        Start Learning →
                    </a>
                </div>
            </article>

            <article class="course-card">
                <div class="course-banner python-banner">
                    <div class="icon">🐍</div>
                    <h3>Python</h3>
                </div>

                <div class="course-content">
                    <span class="level">Beginner</span>
                    <p>Understand Python syntax, loops, conditions and functions.</p>

                    <div class="progress-label">
                        <span>Sample progress</span>
                        <span>45%</span>
                    </div>

                    <div class="progress-bar">
                        <div class="progress-fill python-progress"></div>
                    </div>

                    <a href="assignments.php" class="course-btn">
                        Start Learning →
                    </a>
                </div>
            </article>

            <article class="course-card">
                <div class="course-banner java-banner">
                    <div class="icon">☕</div>
                    <h3>Java Programming</h3>
                </div>

                <div class="course-content">
                    <span class="level">Beginner</span>
                    <p>Explore classes, objects, loops and object-oriented programming.</p>

                    <div class="progress-label">
                        <span>Sample progress</span>
                        <span>15%</span>
                    </div>

                    <div class="progress-bar">
                        <div class="progress-fill java-progress"></div>
                    </div>

                    <a href="assignments.php" class="course-btn">
                        Start Learning →
                    </a>
                </div>
            </article>

            <article class="course-card">
                <div class="course-banner database-banner">
                    <div class="icon">🗄️</div>
                    <h3>Database & SQL</h3>
                </div>

                <div class="course-content">
                    <span class="level">Beginner</span>
                    <p>Learn tables, SQL queries, filtering and database basics.</p>

                    <div class="progress-label">
                        <span>Sample progress</span>
                        <span>25%</span>
                    </div>

                    <div class="progress-bar">
                        <div class="progress-fill database-progress"></div>
                    </div>

                    <a href="assignments.php" class="course-btn">
                        Start Learning →
                    </a>
                </div>
            </article>

        </div>

        <div class="empty-message" id="emptyMessage">
            No courses found. Try another search.
        </div>

    </main>

    <footer>
        <p>© <?php echo date("Y"); ?> LearnSmart AI</p>
        <p>Keep Learning, Keep Growing! 🚀</p>
    </footer>

    <script>
        const searchInput = document.getElementById("courseSearch");
        const courseCards = document.querySelectorAll(".course-card");
        const emptyMessage = document.getElementById("emptyMessage");

        searchInput.addEventListener("input", function () {
            const searchText = this.value.toLowerCase().trim();
            let visibleCount = 0;

            courseCards.forEach(function (card) {
                const matches = card.textContent
                    .toLowerCase()
                    .includes(searchText);

                card.style.display = matches ? "" : "none";

                if (matches) {
                    visibleCount++;
                }
            });

            emptyMessage.style.display =
                visibleCount === 0 ? "block" : "none";
        });
    </script>

</body>
</html>