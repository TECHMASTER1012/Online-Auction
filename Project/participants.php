<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if product_id is provided
if (!isset($_GET['product_id'])) {
    echo "<script>alert('Invalid product selection!'); window.location.href='proje.php';</script>";
    exit();
}

$product_id = $_GET['product_id'];

// Fetch product details
$product_sql = "SELECT product_id, product_name, description, available_quantity, base_fare, image_path, bidding_date, bidding_time 
                FROM products 
                WHERE product_id = ?";
$product_stmt = $conn->prepare($product_sql);
$product_stmt->bind_param("i", $product_id);
$product_stmt->execute();
$product_result = $product_stmt->get_result();

if ($product_result->num_rows == 0) {
    echo "<script>alert('Product not found!'); window.location.href='proje.php';</script>";
    exit();
}

$product = $product_result->fetch_assoc();

// Fetch bid participants
$bid_sql = "SELECT product_id, item_name, bidding_price, quantity, bidder_name, location, bid_time, email
            FROM bids 
            WHERE product_id = ?
            ORDER BY bidding_price DESC";
$bid_stmt = $conn->prepare($bid_sql);
$bid_stmt->bind_param("i", $product_id);
$bid_stmt->execute();
$bid_result = $bid_stmt->get_result();

function sendEmail($to, $subject, $message, $from) {
    $headers = "From: " . $from;
    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully to $to.";
    } else {
        echo "Failed to send email to $to.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['winner_username']) && isset($_POST['product_id'])) {
    $winner_username = $_POST['winner_username'];
    $product_id = $_POST['product_id'];

    // Fetch the email of the winner
    $winner_sql = "SELECT email FROM bids WHERE bidder_name = ? AND product_id = ? LIMIT 1";
    $winner_stmt = $conn->prepare($winner_sql);
    $winner_stmt->bind_param("si", $winner_username, $product_id);
    $winner_stmt->execute();
    $winner_result = $winner_stmt->get_result();

    if ($winner_result->num_rows > 0) {
        $winner = $winner_result->fetch_assoc();
        $email = $winner['email'];

        $subject = "BidBlitz - Congratulations! You won the bid.";
        $message = "Dear $winner_username,\n\nCongratulations! You have won the bid for the product: " . $product['product_name'] . ".\nPlease contact the seller for further details.";
        $from = "noreply@bidblitz.com";

        sendEmail($email, $subject, $message, $from);
        echo "Success";
    } else {
        echo "Email not found.";
    }
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participants - <?php echo htmlspecialchars($product['product_name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(227, 201, 167);
            background-image: url("bidblitz.png");
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            opacity: 0.9;
            height: auto;
        }
        .container {
            padding: 20px;
            width: auto;
            max-height: 95vh;
            overflow-y: auto;
            background: linear-gradient(135deg, #D4AF37,rgb(3, 35, 66));
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        h2 {
            margin-bottom: 10px;
        }
        .product-details img {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            color: black;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: rgb(1, 19, 38);
            color: white;
        }
        .sell-btn {
            background: green;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .sell-btn:hover {
            background: darkgreen;
        }
        .btn {
            background: rgb(1, 19, 38);
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn:hover {
            background: rgb(0, 2, 1);
        }
        .back-btn {
            background: rgb(255, 69, 58);
        }
        .back-btn:hover {
            background: rgb(200, 50, 40);
        }
    </style>
    <script>
        function calculateTotal() {
            const rows = document.querySelectorAll(".bid-row");
            rows.forEach(row => {
                let priceText = row.querySelector(".bidding-price").innerText.replace(/[₹,]/g, '').trim(); // Remove ₹ and commas
                let quantityText = row.querySelector(".quantity").innerText.trim();

                let price = parseFloat(priceText);
                let quantity = parseInt(quantityText);

                if (!isNaN(price) && !isNaN(quantity)) {
                    let totalAmount = price * quantity;
                    row.querySelector(".total-amount").innerText = "₹" + totalAmount.toLocaleString('en-IN', { minimumFractionDigits: 2 });
                } else {
                    row.querySelector(".total-amount").innerText = "₹0.00";
                }
            });
        }
        function sellProduct(bidderName, productId) {
            if (confirm("Are you sure you want to sell this product to " + bidderName + "?")) {
                fetch("send_notification.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "winner_username=" + encodeURIComponent(bidderName) + "&product_id=" + encodeURIComponent(productId)
                })
                .then(response => response.text())
                .then(data => {
                    alert("Winner has been notified!");
                    window.location.href = "sell.php?product_id=" + productId + "&bidder_name=" + bidderName;
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Failed to send notification.");
                });
            }
        }

        window.onload = calculateTotal;
    </script>
</head>
<body>

<div class="container">
    <h2>Participants for <?php echo htmlspecialchars($product['product_name']); ?></h2>
    <div class="product-details">
        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="Product Image">
        <p><strong>Description:</strong><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <p><strong>Available Quantity:</strong> <?php echo htmlspecialchars($product['available_quantity']); ?></p>
        <p><strong>Base Fare:</strong> ₹<?php echo number_format($product['base_fare'], 2); ?></p>
        <p><strong>Bidding Date & Time:</strong> <?php echo htmlspecialchars($product['bidding_date']) . ' ' . htmlspecialchars($product['bidding_time']); ?></p>
    </div>

    <h3>Participant Bids</h3>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Item Name</th>
            <th>Bidding Price</th>
            <th>Quantity</th>
            <th>Total Amount</th>
            <th>Bidder Name</th>
            <th>Location</th>
            <th>Bid Time</th>
            <th>Action</th>
        </tr>
        <?php if ($bid_result->num_rows > 0): ?>
            <?php while ($row = $bid_result->fetch_assoc()): ?>
                <tr class="bid-row">
                    <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                    <td class="bidding-price">₹<?php echo number_format($row['bidding_price'], 2); ?></td>
                    <td class="quantity"><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td class="total-amount">₹0.00</td>
                    <td><?php echo htmlspecialchars($row['bidder_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars($row['bid_time']); ?></td>
                    <td><button class="sell-btn" onclick="sellProduct('<?php echo htmlspecialchars($row['bidder_name']); ?>', <?php echo $row['product_id']; ?>)">Sell</button></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">No bids yet</td>
            </tr>
        <?php endif; ?>
    </table>
    <button class="btn back-btn" onclick="window.location.href='proje.php';">Back</button>
</div>
</body>
</html>
<?php

