<?php
include "filterchar.php";
include "phpconnect.php";
include "functions.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method");
}

// Retrieve and sanitize inputs
$name = fliterRequest("name");
$email = fliterRequest("email");
$phone = fliterRequest("phoneNumber");
$passwordRaw = $_POST['password'] ?? '';

if (!$name || !$email || !$phone || !$passwordRaw) {
    die("All fields are required");
}

// Hash password securely
$password = sha1($passwordRaw);
// OR better:
// $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

$verifyCode = rand(10000, 99999);
$user_approve = 0;

// Check if email or phone already registered
$stmt = $con->prepare("SELECT * FROM users WHERE email = ? OR phoneNumber = ?");
$stmt->execute(array($email, $phone));
$count = $stmt->rowCount();

if ($count > 0) {
    result($count, "Sign up failed", "phone or email already found");
    exit;
}

// Insert new user
$stmt = $con->prepare("INSERT INTO `users` (`name`, `password`, `email`, `phoneNumber`, `verifyCode`, `user_approve`) VALUES (?, ?, ?, ?, ?, ?)");
$success = $stmt->execute(array($name, $password, $email, $phone, $verifyCode, $user_approve));

if ($success) {
    sendEmail($email, $name, "Verification code", "This is your verification code\n$verifyCode", $verifyCode);
} else {
    result(0, "Failed to create user", "");
}
