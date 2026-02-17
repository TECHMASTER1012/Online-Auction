<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if (!isset($_GET['product_id'])) {
    echo "<script>alert('No product selected!'); window.location.href='buy.php';</script>";
    exit();
}

$product_id = intval($_GET['product_id']);

$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<script>alert('Product not found!'); window.location.href='buy.php';</script>";
    exit();
}

$bidding_end_time = strtotime($product['bidding_end_date'] . ' ' . $product['off_time']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(227, 201, 167);
            background-image: url('bidblitz.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 170;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0.95;
        }
        .container {
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            background: linear-gradient(135deg, #D4AF37,rgb(3, 35, 66));
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 800px;
            text-align: center;
        }
        h2 { margin-bottom: 15px; }
        p { font-size: 16px; margin: 10px 0; color: black;}
        .product-details, .rules {
            text-align: left;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #fff;
            background: rgba(30, 48, 2, 0.9);
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn:hover { background: rgb(0, 2, 1); }
        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            text-align: center;
        }
        #popup input { width: 80%; padding: 8px; margin: 10px 0; }
        #countdown { font-size: 20px; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
    <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="Product Image" width="55%" height=400px style="border-radius: 10px; margin-bottom: 15px;">
    
    <div class="product-details">
        <h3>Product Description:</h3>
        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <h3>Base Fare: ₹<?php echo number_format($product['base_fare'], 2); ?></h3>
        <h3>Available Quantity: <?php echo htmlspecialchars($product['available_quantity']); ?></h3>
        <h3>Bidding Date & Time: <?php echo htmlspecialchars($product['bidding_date']) . ' ' . htmlspecialchars($product['bidding_time']); ?></h3>
        <h3>Bidding Ends At: <?php echo htmlspecialchars($product['bidding_end_date']) . ' ' . htmlspecialchars($product['off_time']); ?></h3>

        <div style="text-align: center; margin-top: 20px;">
    <button type="button" class="btn" onclick="window.location.href='buy.php';">Back</button>
    <button id="bidNowButton" class="btn" onclick="checkBiddingStatus()">I'm Interested</button>
</div>

    <div id="countdown" style="text-align: center;"></div>

    <div id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); border-radius: 10px;">
        <h3>Confirm Your Interest</h3>
        <p>Click below to proceed to the bidding page.</p>
        <button class="btn" onclick="redirectToBid()">Proceed to Bid</button>
        <button class="btn" onclick="hidePopup()">Cancel</button>
    </div>
</div>

<script>
    let auctionStartTime = new Date("<?php echo htmlspecialchars($product['bidding_date'] . ' ' . $product['bidding_time']); ?>").getTime();
let auctionEndTime = new Date("<?php echo date('Y-m-d H:i:s', $bidding_end_time); ?>").getTime(); // Ensure proper formatting of the end time

function checkBiddingStatus() {
    let now = new Date().getTime();

    if (now < auctionStartTime) {
        alert("Bidding hasn't started yet. Try again later!");
    } else if (now > auctionEndTime) {
        alert("Bidding has ended. Try another time!");
    } else {
        showPopup();
    }
}

function showPopup() {
    document.getElementById("popup").style.display = "block";
}

function hidePopup() {
    document.getElementById("popup").style.display = "none";
}

function redirectToBid() {
    window.location.href = "placebid.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>";
}

// Countdown Timer Logic
let countdown = setInterval(function() {
    let now = new Date().getTime();
    let timeLeft = auctionEndTime - now;

    if (timeLeft > 0) {
        let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        document.getElementById("countdown").innerHTML = 
            `Bidding ends in: ${days}d ${hours}h ${minutes}m ${seconds}s`;
    } else {
        clearInterval(countdown);
        document.getElementById("countdown").innerHTML = "Bidding has ended.";
        document.getElementById("bidNowButton").disabled = true;
        document.getElementById("bidNowButton").style.backgroundColor = "grey";
        document.getElementById("bidNowButton").style.cursor = "not-allowed";
    }
}, 1000);

document.getElementById('bidNowButton').addEventListener('click', checkBiddingStatus);

</script>


</body>
</html>
