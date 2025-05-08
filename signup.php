<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    try {
        $stmt->execute([$username, $password]);
        echo "<script>alert('Signup successful! You can now log in.'); window.location.href = 'login.php';</script>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry
            echo "<script>alert('Username already exists. Please choose another one.');</script>";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { width: 300px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px 20px; width: 100%; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Sign Up</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Sign Up</button>
    </form>
</body>
</html>
