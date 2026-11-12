<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$name = htmlspecialchars($_SESSION['name'] ?? 'Student');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Learning Recommendations | LearnSmart AI</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Arial, sans-serif;
}

body {
    background: linear-gradient(135deg, #eef2ff, #fdf2f8, #ecfeff);
    color: #263238;
    min-height: 100vh;
}

header {
    background: linear-gradient(100deg, #6c3ce9, #a855f7, #ec4899);
    color: white;
    padding: 25px 7%;
    box-shadow: 0 5px 20px rgba(70, 40, 150, 0.2);
}

header h1 {
    font-size: 28px;
    margin-bottom: 8px;
}

header p {
    opacity: 0.95;
}

nav {
    background: white;
    padding: 15px 7%;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.06);
}

nav a {
    text-decoration: none;
    color: #6035c9;
    font-weight: 600;
}

nav a:hover {
    color: #ec4899;
}

.container {
    max-width: 1150px;
    margin: 35px auto;
    padding: 0 20px;
}

.welcome {
    background: linear-gradient(120deg, #2563eb, #7c3aed);
    color: white;
    padding: 30px;
    border-radius: 20px;
    margin-bottom: 30px;
    box-shadow: 0 10px 25px rgba(79, 70, 229, 0.2);
}

.welcome h2 {
    margin-bottom: 10px;
    font-size: 26px;
}

.section-title {
    margin: 30px 0 18px;
    font-size: 24px;
    color: #35216d;
}

.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 22px;
}

.card {
    background: white;
    border-radius: 18px;
    padding: 25px;
    box-shadow: 0 7px 22px rgba(50, 30, 100, 0.09);
    border-top: 5px solid #8b5cf6;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 13px 28px rgba(50, 30, 100, 0.15);
}

.icon {
    font-size: 38px;
    margin-bottom: 15px;
}

.card h3 {
    color: #4527a0;
    margin-bottom: 10px;
}

.card p {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 18px;
}

.tag {
    display: inline-block;
    background: #ede9fe;
    color: #6d28d9;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 15px;
}

.btn {
    display: inline-block;
    text-decoration: none;
    color: white;
    background: linear-gradient(90deg, #7c3aed, #ec4899);
    padding: 11px 18px;
    border-radius: 10px;
    font-weight: 600;
    transition: 0.3s;
}

.btn:hover {
    opacity: 0.85;
    transform: scale(1.03);
}

.info {
    margin-top: 30px;
    padding: 22px;
    background: #fff7ed;
    border-left: 5px solid #f59e0b;
    border-radius: 12px;
    line-height: 1.7;
}

footer {
    text-align: center;
    padding: 25px;
    color: #64748b;
    margin-top: 30px;
}

@media (max-width: 600px) {
    header h1 {
        font-size: 23px;
    }

    .welcome h2 {
        font-size: 21px;
    }

    nav {
        gap: 13px;
    }
}
</style>
</head>

<body>

<header>
    <h1>✨ LearnSmart AI</h1>
    <p>Your personalized learning recommendations</p>
</header>

<nav>
    <a href="index.php">🏠 Home</a>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="courses.php">📚 Courses</a>
    <a href="assignments.php">📝 Assignments</a>
    <a href="recommendations.php">💡 Recommendations</a>
    <a href="logout.php">🚪 Logout</a>
</nav>

<div class="container">

    <section class="welcome">
        <h2>Welcome, <?php echo $name; ?>! 👋</h2>
        <p>Explore these learning suggestions to improve your skills and track your progress.</p>
    </section>

    <h2 class="section-title">💡 Recommended Learning Paths</h2>

    <div class="cards">

        <div class="card">
            <div class="icon">🌐</div>
            <span class="tag">Beginner</span>
            <h3>HTML & CSS</h3>
            <p>Learn how to build beautiful web pages using HTML structure and CSS styling.</p>
            <a href="courses.php" class="btn">Explore Course →</a>
        </div>

        <div class="card">
            <div class="icon">⚡</div>
            <span class="tag">Beginner</span>
            <h3>JavaScript</h3>
            <p>Understand variables, functions, events and interactive web development.</p>
            <a href="courses.php" class="btn">Explore Course →</a>
        </div>

        <div class="card">
            <div class="icon">🐘</div>
            <span class="tag">Web Development</span>
            <h3>PHP & MySQL</h3>
            <p>Practice server-side programming, database connections, login and registration.</p>
            <a href="courses.php" class="btn">Explore Course →</a>
        </div>

        <div class="card">
            <div class="icon">🧠</div>
            <span class="tag">Practice</span>
            <h3>Programming Exercises</h3>
            <p>Strengthen your coding skills by solving beginner-friendly programming problems.</p>
            <a href="assignments.php" class="btn">Practice Now →</a>
        </div>

        <div class="card">
            <div class="icon">🤖</div>
            <span class="tag">Emerging Technology</span>
            <h3>Artificial Intelligence</h3>
            <p>Discover AI basics, machine learning concepts and real-world applications.</p>
            <a href="courses.php" class="btn">Explore Course →</a>
        </div>

        <div class="card">
            <div class="icon">🎯</div>
            <span class="tag">Career Preparation</span>
            <h3>Interview Preparation</h3>
            <p>Review technical questions, practice problem-solving and prepare for interviews.</p>
            <a href="assignments.php" class="btn">Start Practice →</a>
        </div>

    </div>

    <div class="info">
        <h3>🌟 Learning Tip</h3>
        <p>Study one topic at a time, practice regularly, and complete your assignments.
        These are sample recommendations; they are not yet generated from your actual learning history.</p>
    </div>

</div>

<footer>
    © 2026 LearnSmart AI | Personalized Learning Platform
</footer>

</body>
</html>