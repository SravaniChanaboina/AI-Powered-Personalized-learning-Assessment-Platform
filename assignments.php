<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

// Fetch assignments
$stmt = $pdo->query(
    "SELECT id, title, description, due_date
     FROM assignments
     ORDER BY id DESC"
);

$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Assignments - LearnSmart AI</title>

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
            color: white;
            padding: 20px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 4px 15px #00000015;
        }

        .navbar h2 {
            font-size: 24px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 16px;
            font-weight: bold;
        }

        .navbar .home-btn {
            background: white;
            color: #4527a0;
            padding: 10px 14px;
            border-radius: 8px;
        }

        /* Hero */
        .hero {
            background: linear-gradient(135deg, #7c4dff, #2196f3);
            color: white;
            padding: 50px 7%;
        }

        .hero h1 {
            font-size: 36px;
            margin-bottom: 14px;
        }

        .hero p {
            line-height: 1.8;
            font-size: 17px;
        }

        /* Main container */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 35px auto;
        }

        .section-title {
            color: #4527a0;
            font-size: 28px;
            margin-bottom: 12px;
        }

        .section-description {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 25px;
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
            background: white;
            outline: none;
        }

        .search-box input:focus {
            border-color: #7c4dff;
            box-shadow: 0 0 8px #7c4dff30;
        }

        /* Assignment grid */
        .assignment-grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(260px, 1fr)
            );
            gap: 24px;
        }

        .assignment-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 25px #00000012;
            border-bottom: 5px solid #7c4dff;
            transition: 0.3s;
        }

        .assignment-card:nth-child(3n + 2) {
            border-bottom-color: #ff9800;
        }

        .assignment-card:nth-child(3n) {
            border-bottom-color: #00b894;
        }

        .assignment-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 30px #00000020;
        }

        .card-banner {
            padding: 23px;
            color: white;
            background: linear-gradient(135deg, #7c4dff, #512da8);
        }

        .assignment-card:nth-child(3n + 2) .card-banner {
            background: linear-gradient(135deg, #ff9800, #f4511e);
        }

        .assignment-card:nth-child(3n) .card-banner {
            background: linear-gradient(135deg, #00b894, #00897b);
        }

        .card-banner .icon {
            font-size: 34px;
            margin-bottom: 10px;
        }

        .card-banner h3 {
            font-size: 21px;
            overflow-wrap: anywhere;
        }

        .card-content {
            padding: 24px;
        }

        .status {
            display: inline-block;
            background: #ede7f6;
            color: #5e35b1;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .card-content p {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 16px;
            overflow-wrap: anywhere;
        }

        .due-date {
            background: #fff3e0;
            color: #e65100;
            padding: 12px;
            border-radius: 9px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .btn {
            display: block;
            text-align: center;
            background: linear-gradient(90deg, #673ab7, #3f51b5);
            color: white;
            padding: 12px;
            border-radius: 9px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background: linear-gradient(90deg, #ff6f00, #ff4081);
        }

        .empty-message {
            background: white;
            text-align: center;
            padding: 35px;
            border-radius: 15px;
            color: #64748b;
        }

        .empty-message h3 {
            color: #4527a0;
            margin-bottom: 10px;
        }

        /* Footer */
        footer {
            margin-top: 50px;
            background: #20134b;
            color: white;
            text-align: center;
            padding: 25px;
            line-height: 1.8;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 18px;
            }

            .navbar a {
                display: inline-block;
                margin: 8px 5px 0 0;
            }

            .hero {
                padding: 38px 6%;
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

    <nav class="navbar">
        <h2>🎓 LearnSmart AI</h2>

        <div>
            <a href="index.php" class="home-btn">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="courses.php">My Courses</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <section class="hero">
        <h1>📝 My Assignments</h1>

        <p>
            Practice your skills, complete your tasks and
            track your learning journey!
        </p>
    </section>

    <main class="container">

        <h2 class="section-title">Your Learning Tasks 🎯</h2>

        <p class="section-description">
            Review your available assignments and continue learning.
        </p>

        <div class="search-box">
            <input
                type="text"
                id="assignmentSearch"
                placeholder="🔍 Search assignments..."
                aria-label="Search assignments"
            >
        </div>

        <div class="assignment-grid" id="assignmentGrid">

            <?php if (count($assignments) > 0): ?>

                <?php foreach ($assignments as $assignment): ?>

                    <article class="assignment-card">

                        <div class="card-banner">
                            <div class="icon">📘</div>

                            <h3>
                                <?php
                                echo htmlspecialchars(
                                    $assignment["title"] ?? "Assignment",
                                    ENT_QUOTES,
                                    "UTF-8"
                                );
                                ?>
                            </h3>
                        </div>

                        <div class="card-content">

                            <span class="status">📌 Available</span>

                            <p>
                                <?php
                                echo nl2br(htmlspecialchars(
                                    $assignment["description"] ?? "No description available.",
                                    ENT_QUOTES,
                                    "UTF-8"
                                ));
                                ?>
                            </p>

                            <div class="due-date">
                                📅 Due date:
                                <?php
                                echo !empty($assignment["due_date"])
                                    ? htmlspecialchars(
                                        $assignment["due_date"],
                                        ENT_QUOTES,
                                        "UTF-8"
                                    )
                                    : "Not specified";
                                ?>
                            </div>

                            <a
                                href="submit_assignment.php?id=<?php
                                echo (int) $assignment["id"];
                                ?>"
                                class="btn"
                            >
                                Open Assignment →
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty-message">
                    <h3>📚 No Assignments Available</h3>

                    <p>
                        Your assignments will appear here when
                        they are added to the platform.
                    </p>
                </div>

            <?php endif; ?>

        </div>

        <div
            class="empty-message"
            id="noSearchResults"
            style="display:none; margin-top:20px;"
        >
            <h3>🔍 No matching assignments</h3>
            <p>Try searching with another keyword.</p>
        </div>

    </main>

    <footer>
        <p>© <?php echo date("Y"); ?> LearnSmart AI</p>
        <p>Keep Learning, Keep Growing! 🚀</p>
    </footer>

    <script>
        const searchInput = document.getElementById("assignmentSearch");
        const cards = document.querySelectorAll(".assignment-card");
        const noResults = document.getElementById("noSearchResults");

        searchInput.addEventListener("input", function () {
            const searchText = this.value.toLowerCase().trim();
            let visibleCount = 0;

            cards.forEach(function (card) {
                const matches = card.textContent
                    .toLowerCase()
                    .includes(searchText);

                card.style.display = matches ? "" : "none";

                if (matches) {
                    visibleCount++;
                }
            });

            noResults.style.display =
                visibleCount === 0 && cards.length > 0
                    ? "block"
                    : "none";
        });
    </script>

</body>
</html>