<?php
session_start();
require_once "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if ($name === "" || $email === "" ||
        $password === "" || $confirmPassword === "") {
        $message = "Please fill in all fields.";
        $messageType = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $messageType = "error";
    } elseif (strlen($password) < 8) {
        $message = "Password must contain at least 8 characters.";
        $messageType = "error";
    } elseif ($password !== $confirmPassword) {
        $message = "Passwords do not match.";
        $messageType = "error";
    } else {
        try {
            $check = $pdo->prepare(
                "SELECT id FROM users WHERE email = ?"
            );
            $check->execute([$email]);

            if ($check->fetch()) {
                $message = "This email is already registered.";
                $messageType = "error";
            } else {
                $hashedPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $stmt = $pdo->prepare(
                    "INSERT INTO users (name, email, password, role)
                     VALUES (?, ?, ?, 'student')"
                );

                $stmt->execute([
                    $name,
                    $email,
                    $hashedPassword
                ]);

                $message = "Registration successful! You can now log in.";
                $messageType = "success";
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $message = "Registration failed. Please try again.";
            $messageType = "error";
        }
    }
}
?><!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Student Registration | LearnSmart AI</title>

<link rel="stylesheet" href="css/style.css">

<style>
    .register-container {
        max-width: 450px;
        margin: 50px auto;
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px #00000015;
    }

    .register-container h1 {
        text-align: center;
        margin-bottom: 10px;
    }

    .register-container .subtitle {
        text-align: center;
        margin-bottom: 25px;
        color: #64748b;
    }

    .register-container label {
        display: block;
        margin: 15px 0 7px;
        font-weight: bold;
    }

    .register-container input {
        width: 100%;
        padding: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
    }

    .register-container button {
        width: 100%;
        margin-top: 22px;
        padding: 13px;
        border: none;
        border-radius: 6px;
        background: #2563eb;
        color: white;
        font-size: 16px;
        cursor: pointer;
    }

    .message {
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 6px;
    }

    .success {
        background: #dcfce7;
        color: #166534;
    }

    .error {
        background: #fee2e2;
        color: #991b1b;
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
    }
</style>

</head><body><header>
    <h2>LearnSmart AI</h2><nav>
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
</nav>

</header><div class="register-container"><h1>Create Account</h1>

<p class="subtitle">
    Join LearnSmart AI and start learning!
</p>

<?php if ($message !== ""): ?>
    <div class="message <?= htmlspecialchars($messageType) ?>">
        <?= htmlspecialchars($message) ?>

        <?php if ($messageType === "success"): ?>
            <br>
            <a href="login.php">Go to Login</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<form method="POST" action="register.php">

    <label for="name">Full Name</label>
    <input
        type="text"
        id="name"
        name="name"
        maxlength="100"
        autocomplete="name"
        required
    >

    <label for="email">Email Address</label>
    <input
        type="email"
        id="email"
        name="email"
        maxlength="150"
        autocomplete="email"
        required
    >

    <label for="password">Password</label>
    <input
        type="password"
        id="password"
        name="password"
        minlength="8"
        autocomplete="new-password"
        required
    >

    <label for="confirm_password">Confirm Password</label>
    <input
        type="password"
        id="confirm_password"
        name="confirm_password"
        minlength="8"
        autocomplete="new-password"
        required
    >

    <button type="submit">Register Now</button>

</form>

<p class="login-link">
    Already have an account?
    <a href="login.php">Login here</a>
</p>

</div></body>
</html>