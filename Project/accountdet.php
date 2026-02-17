<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['username'];

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    $delete_sql = "DELETE FROM products WHERE product_id = ? AND username = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("is", $delete_id, $username);
    
    if ($delete_stmt->execute()) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='accountdet.php';</script>";
    } else {
        echo "<script>alert('Error deleting product.'); window.location.href='accountdet.php';</script>";
    }

    $delete_stmt->close();
}

// Fetch user details
$sql = "SELECT username, name, dob, age, mobile, alt_mobile, email, alt_email, aadhar, occupation, designation, income, bank_name, branch_name, branch_code, ifsc, account_number, perm_address, perm_pin, perm_city, perm_state FROM prac WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<script>alert('No account details found!'); window.location.href='proje.php';</script>";
    exit();
}
$stmt->close();

// Fetch products
$product_sql = "SELECT product_id, product_name, description, bidding_date, bidding_time FROM products WHERE username = ?";
$product_stmt = $conn->prepare($product_sql);
$product_stmt->bind_param("s", $username);
$product_stmt->execute();
$product_result = $product_stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account & Products</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-image: url("bidblitz.png");
            display: flex;
            justify-content: center;
            align-items: center;
            height: 130vh;
            background-size: cover;
            background-position: center;
            opacity: 0.85;
            text-align: center;
        }
        .container {
            padding: 20px;
            width: auto;
            max-height: 120vh;
            overflow-y: auto;
            background: linear-gradient(135deg, #D4AF37, rgb(3, 35, 66));
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        h2 {
            margin-bottom: 15px;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }
        th {
            background-color: rgba(255, 255, 255, 0.2);
        }
        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #fff;
            background: rgb(1, 13, 26);
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        a:hover {
            background: rgb(0, 2, 1);
        }
        .delete-button {
            color: white;
            background-color: red;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .delete-button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Account Details</h2>
    <div class="user-info">
        <strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?><br>
        <strong>Username:</strong> <?php echo htmlspecialchars($row['username']); ?>
    </div>

    <table>
        <?php foreach ($row as $key => $value) { 
            if ($key !== "username" && $key !== "name") { ?>
            <tr>
                <th><?php echo ucfirst(str_replace("_", " ", $key)); ?></th>
                <td><?php echo htmlspecialchars($value); ?></td>
            </tr>
        <?php } } ?>
    </table>

    <h2>Your Listed Products</h2>
    <?php if ($product_result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Bidding Date</th>
                <th>Bidding Time</th>
                <th>Action</th>
            </tr>
            <?php while ($product = $product_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td><?php echo htmlspecialchars($product['bidding_date']); ?></td>
                    <td><?php echo htmlspecialchars($product['bidding_time']); ?></td>
                    <td>
                        <a href="accountdet.php?delete_id=<?php echo htmlspecialchars($product['product_id']); ?>" 
                           onclick="return confirm('Are you sure you want to delete this product?');" 
                           class="delete-button">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No products added yet.</p>
    <?php } ?>

    <a href="proje.php">Back to Dashboard</a>
</div>
</body>
</html>
