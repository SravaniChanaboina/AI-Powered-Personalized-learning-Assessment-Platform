<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$name = htmlspecialchars($_SESSION['name'] ?? 'Student');
$message = '';
$error = '';

$selected_id = filter_input(INPUT_POST, 'assignment_id', FILTER_VALIDATE_INT);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $selected_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}

$assignment = null;

try {
    // Load all available assignments
    $stmt = $pdo->query(
        "SELECT id, title, description, due_date
         FROM assignments
         ORDER BY id DESC"
    );

    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Load selected assignment details
    if ($selected_id && $selected_id > 0) {
        $stmt = $pdo->prepare(
            "SELECT id, title, description, due_date
             FROM assignments
             WHERE id = ?"
        );

        $stmt->execute([$selected_id]);
        $assignment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$assignment) {
            $error = "Selected assignment was not found.";
        }
    }
} catch (PDOException $e) {
    $assignments = [];
    $error = "Unable to load assignments. Please check your database.";
}

// Process the answer form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_answer'])) {

    $answer = trim($_POST['answer'] ?? '');

    if (!$selected_id || !$assignment) {
        $error = "Please select a valid assignment.";
    } elseif ($answer === '') {
        $error = "Please enter your answer.";
    } else {
        /*
         * Database saving is not configured here because the
         * existing submissions table structure is unknown.
         */
        $message = "Your answer is ready. Database saving still needs to be configured.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Select Assignment | LearnSmart AI</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", Arial, sans-serif;
}

body {
    min-height: 100vh;
    background: linear-gradient(135deg, #eef2ff, #fdf2f8, #ecfeff);
    color: #263238;
}

header {
    padding: 26px 7%;
    color: white;
    background: linear-gradient(110deg, #4f46e5, #9333ea, #ec4899);
    box-shadow: 0 5px 18px rgba(79,70,229,.2);
}

header h1 {
    font-size: 28px;
    margin-bottom: 8px;
}

nav {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 16px 7%;
    background: white;
    box-shadow: 0 3px 12px rgba(0,0,0,.05);
}

nav a {
    text-decoration: none;
    color: #6338c9;
    font-weight: 600;
}

nav a:hover {
    color: #ec4899;
}

.container {
    max-width: 900px;
    margin: 35px auto;
    padding: 0 18px;
}

.card {
    background: white;
    border-radius: 22px;
    padding: 30px;
    box-shadow: 0 12px 35px rgba(67,56,202,.12);
    border-top: 6px solid #8b5cf6;
}

.badge {
    display: inline-block;
    background: #ede9fe;
    color: #6d28d9;
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 18px;
}

h2 {
    color: #4c1d95;
    margin-bottom: 12px;
}

.intro {
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 24px;
}

label {
    display: block;
    font-weight: 600;
    margin: 20px 0 9px;
    color: #374151;
}

select, textarea {
    width: 100%;
    padding: 14px;
    border: 1px solid #d8d5e8;
    border-radius: 11px;
    background: #fafaff;
    font-size: 15px;
}

select:focus, textarea:focus {
    outline: 2px solid #a78bfa;
    border-color: #8b5cf6;
}

textarea {
    min-height: 180px;
    resize: vertical;
    line-height: 1.6;
}

.assignment-details {
    margin-top: 24px;
    padding: 23px;
    border-radius: 16px;
    background: linear-gradient(135deg, #ede9fe, #fce7f3);
    border-left: 5px solid #8b5cf6;
}

.assignment-details h3 {
    color: #6d28d9;
    font-size: 22px;
    margin-bottom: 12px;
}

.assignment-details p {
    color: #475569;
    line-height: 1.7;
    margin-top: 8px;
}

.due-date {
    display: inline-block;
    margin-top: 14px;
    padding: 8px 12px;
    background: white;
    border-radius: 8px;
    color: #9333ea;
    font-weight: 600;
}

button, .back-btn {
    display: inline-block;
    padding: 13px 21px;
    border: none;
    border-radius: 10px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
}

button {
    color: white;
    background: linear-gradient(90deg, #7c3aed, #ec4899);
}

button:hover {
    opacity: .88;
    transform: translateY(-2px);
}

.back-btn {
    color: #334155;
    background: #f1f5f9;
}

.button-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 24px;
}

.notice {
    padding: 14px;
    border-radius: 10px;
    margin: 15px 0;
    line-height: 1.6;
}

.success {
    color: #166534;
    background: #dcfce7;
}

.error {
    color: #991b1b;
    background: #fee2e2;
}

.help {
    margin-top: 8px;
    color: #64748b;
    font-size: 13px;
    line-height: 1.6;
}

.tip {
    margin-top: 25px;
    padding: 18px;
    background: #fff7ed;
    border-left: 5px solid #fb923c;
    border-radius: 12px;
    line-height: 1.7;
}

footer {
    text-align: center;
    padding: 25px;
    color: #64748b;
}

@media(max-width:600px) {
    .card {
        padding: 21px;
    }

    header h1 {
        font-size: 23px;
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
    <p>Select an assignment and submit your answer</p>
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
<div class="card">

    <span class="badge">🎯 STUDENT WORKSPACE</span>

    <h2>Hello, <?php echo $name; ?>! 👋</h2>

    <p class="intro">
        Select an assignment from the dropdown to view its title,
        description and due date. Then write your answer.
    </p>

    <?php if ($message !== ''): ?>
        <div class="notice success">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="notice error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($assignments)): ?>

        <form method="GET" action="submit_assignment.php">

            <label for="assignment_id">📚 Select Assignment</label>

            <select id="assignment_id"
                    name="id"
                    onchange="this.form.submit()"
                    required>

                <option value="">-- Choose an assignment --</option>

                <?php foreach ($assignments as $item): ?>
                    <option
                        value="<?php echo (int)$item['id']; ?>"
                        <?php
                        echo ($selected_id == $item['id'])
                            ? 'selected'
                            : '';
                        ?>>
                        <?php echo htmlspecialchars($item['title']); ?>
                    </option>
                <?php endforeach; ?>

            </select>

            <p class="help">
                Choose an assignment to see its details below.
            </p>
        </form>

        <?php if ($assignment): ?>

            <div class="assignment-details">

                <h3>
                    📘 <?php echo htmlspecialchars($assignment['title']); ?>
                </h3>

                <p>
                    <?php
                    echo nl2br(
                        htmlspecialchars(
                            $assignment['description'] ?? 'No description available.'
                        )
                    );
                    ?>
                </p>

                <?php if (!empty($assignment['due_date'])): ?>
                    <div class="due-date">
                        📅 Due Date:
                        <?php echo htmlspecialchars($assignment['due_date']); ?>
                    </div>
                <?php endif; ?>

            </div>

            <form method="POST"
                  action="submit_assignment.php"
                  style="margin-top:20px;">

                <input type="hidden"
                       name="assignment_id"
                       value="<?php echo (int)$assignment['id']; ?>">

                <label for="answer">✍️ Write Your Answer *</label>

                <textarea
                    id="answer"
                    name="answer"
                    placeholder="Write your answer here..."
                    required><?php
                        echo htmlspecialchars($_POST['answer'] ?? '');
                    ?></textarea>

                <p class="help">
                    Review your answer before submitting.
                </p>

                <div class="button-row">
                    <button type="submit" name="submit_answer">
                        📤 Submit Assignment
                    </button>

                    <a href="assignments.php" class="back-btn">
                        ← Back to Assignments
                    </a>
                </div>

            </form>

        <?php endif; ?>

    <?php else: ?>

        <div class="notice error">
            No assignments are available right now. Please ask your admin
            to add assignments.
        </div>

        <a href="dashboard.php" class="back-btn">← Dashboard</a>

    <?php endif; ?>

    <div class="tip">
        <strong>💡 Learning Tip</strong>
        <p>Choose one assignment, read the instructions carefully,
        and practise your answer before submitting.</p>
    </div>

</div>
</div>

<footer>
    © 2026 LearnSmart AI | Keep Learning, Keep Growing 🌟
</footer>

</body>
</html>