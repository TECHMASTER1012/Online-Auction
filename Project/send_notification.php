<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $buyer_username = $_POST['winner_username'];
    $product_id = $_POST['product_id'];
    $seller_username = $_SESSION['username'];

    $message = "🎉 Congratulations! You have won the bid for Product ID $product_id. Please proceed with payment.";

    $sql = "INSERT INTO notifications (user_username, message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $buyer_username, $message);

    if ($stmt->execute()) {
        echo "Notification sent!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
