<button?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: proje.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-image: url("bidblitz.png");
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-size: cover;
            background-position: center;
            opacity: 0.75;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background: #021b0d;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #033d18;
        }
        .back-button {
            /* display: inline-block; */
            background: #ff4136;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .back-button:hover {
            background: #e62e2e;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="authenticate.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <back-button><a href="firstpage.php" class="back-button">Back</a></back-button>
        <p>Don't have an account? <a href="signup.html">Sign Up</a></p>
        <p class="error">
            <?php if (isset($_GET['error'])) echo htmlspecialchars($_GET['error']); ?>
        </p>
    </div>
</body>
</html>
