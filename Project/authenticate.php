
<?php
session_start();
include 'db.php'; 

function cleanInput($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = cleanInput($_POST['username']);
    $password = trim($_POST['password']);

    
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=Please fill in all fields");
        exit();
    }

    
    $sql = "SELECT username, password FROM prac WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_username, $db_password);
        $stmt->fetch();

        
        if (password_verify($password, $db_password)) {
            $_SESSION['username'] = $db_username;
            echo "<script>alert('Login Successful!'); window.location.href='proje.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid username or password!'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Invalid username or password!'); window.location.href='login.php';</script>";
        exit();
    }

    $stmt->close();
}
$conn->close();
?>
