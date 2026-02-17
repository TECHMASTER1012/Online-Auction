<?php
session_start();

$conn = new mysqli("localhost", "root", "", "anidb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function cleanInput($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $name = cleanInput($_POST['name']);
    $dob = cleanInput($_POST['dob']);
    $username = cleanInput($_POST['username']);
    $age = cleanInput($_POST['age']);
    $mobile = cleanInput($_POST['mobile']);
    $alt_mobile = cleanInput($_POST['alt_mobile']);
    $email = cleanInput($_POST['email']);
    $alt_email = cleanInput($_POST['alt_email']);
    $aadhar = cleanInput($_POST['aadhar']);
    $password = $_POST['password']; 
    $confirm_password = $_POST['confirm_password'];
    $occupation = cleanInput($_POST['occupation']);
    $designation = cleanInput($_POST['designation']);
    $income = cleanInput($_POST['income']);
    $bank_name = cleanInput($_POST['bank_name']);
    $branch_name = cleanInput($_POST['branch_name']);
    $branch_code = cleanInput($_POST['branch_code']);
    $ifsc = cleanInput($_POST['ifsc']);
    $account_number = cleanInput($_POST['account_number']);
    $perm_address = cleanInput($_POST['perm_address']);
    $perm_pin = cleanInput($_POST['perm_pin']);
    $perm_city = cleanInput($_POST['perm_city']);
    $perm_state = cleanInput($_POST['perm_state']);

    
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO prac (name, dob, username, age, mobile, alt_mobile, email, alt_email, aadhar, password, occupation, designation, income, bank_name, branch_name, branch_code, ifsc, account_number, perm_address, perm_pin, perm_city, perm_state) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissssssssssssssssss", $name, $dob, $username, $age, $mobile, $alt_mobile, $email, $alt_email, $aadhar, $hashed_password, $occupation, $designation, $income, $bank_name, $branch_name, $branch_code, $ifsc, $account_number, $perm_address, $perm_pin, $perm_city, $perm_state);

    if ($stmt->execute()) {
        echo "<script>alert('Registration Successful!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
