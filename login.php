<?php
session_start();
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $message = "Please enter your email and password.";
    } else {
        $stmt = $pdo->prepare(
            "SELECT id, name, email, password, role
             FROM users
             WHERE email = ?"
        );

        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_role"] = $user["role"];

            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Invalid email or password.";
        }
    }
}
?><!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - LearnSmart AI</title>
    <link rel="stylesheet" href="css/style.css"><style>
    .login-box {
        max-width: 420px;
        margin: 60px auto;
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px #00000015;
    }

    .login-box h1 {
        text-align: center;
        margin-bottom: 25px;
    }

    .login-box label {
        display: block;
        margin: 15px 0 7px;
    }

    .login-box input {
        width: 100%;
        padding: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
    }

    .login-box button {
        width: 100%;
        padding: 12px;
        margin-top: 22px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .error {
        padding: 12px;
        margin-bottom: 15px;
        background: #fee2e2;
        color: #991b1b;
    }

    .register-link {
        margin-top: 20px;
        text-align: center;
    }
</style>

</head>
<body><header>
    <h2>LearnSmart AI</h2>
    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
    </nav>
</header><div class="login-box">
    <h1>Student Login</h1><?php if ($message !== ""): ?>
    <div class="error">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<form method="POST" action="login.php">
    <label for="email">Email Address</label>
    <input
        type="email"
        id="email"
        name="email"
        autocomplete="email"
        required
    >

    <label for="password">Password</label>
    <input
        type="password"
        id="password"
        name="password"
        autocomplete="current-password"
        required
    >

    <button type="submit">Login</button>
</form>

<p class="register-link">
    Don't have an account?
    <a href="register.php">Register here</a>
</p>

</div></body>
</html>