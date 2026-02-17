<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch the logged-in user's name from the prac table
$user_query = "SELECT name FROM prac WHERE username = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $username);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    echo "<script>alert('User details not found. Please log in again.'); window.location.href='login.php';</script>";
    exit();
}

$bidder_name = htmlspecialchars($user['name']); // Use this for bidder_name

$product_id = $_GET['product_id'] ?? '';

$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $product_id); // Change to "s" since product_id is VARCHAR(50)
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<script>alert('Product not found!'); window.location.href='buy.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bidding_price = $_POST['bidding_price'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];
    $email = $_POST['email'];

    if ($bidding_price <= 0 || $quantity <= 0 || empty($location) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid input. Please fill all fields correctly.');</script>";
    } else {
        $insert_query = "INSERT INTO bids (product_id, item_name, bidding_price, quantity, bidder_name, bidder_username, location, email) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssdissss", $product['product_id'], $product['product_name'], $bidding_price, $quantity, $bidder_name, $username, $location, $email);

        if ($stmt->execute()) {
            echo "<script>alert('Bid placed successfully!'); window.location.href='buy.php';</script>";
        } else {
            echo "<script>alert('Error placing bid: " . $stmt->error . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place a Bid</title>
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
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
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
            font-size: 16px;
        }
        button {
            width: 100%;
            background: #021b0d;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover {
            background: #033d18;
        }
        .btn-link {
            display: block;
            text-decoration: none;
            color: white;
            padding: 10px;
            font-size: 16px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Bid on <?php echo htmlspecialchars($product['product_name']); ?></h2>
    <form method="post">
        <label><b>Bidding Price (₹):</b></label>
        <input type="number" name="bidding_price" step="0.01" required>
        
        <label><b>Quantity (kg/litres):</b></label>
        <input type="number" name="quantity" required>

        <label><b>Your Name:</b></label>
        <input type="text" name="bidder_name" value="<?php echo $bidder_name; ?>" readonly>

        <label><b>Email:</b></label>
        <input type="email" name="email" required>

        <label><b>Location:</b></label>
        <input type="text" name="location" required>

        <button type="submit">Place Bid</button>
    </form>
    
    <button>
        <a href="buy.php" class="btn-link">Cancel</a>
    </button>
</div>

</body>
</html>
