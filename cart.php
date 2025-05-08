<?php
include 'db.php'; // Include the database connection
session_start();

// Handle adding domains to the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $domain_name = $_POST['domain_name'];
    $domain_extension = $_POST['domain_extension'];
    $domain_price = $_POST['domain_price'];

    try {
        // Insert the selected domain into the cart table
        $stmt = $conn->prepare("INSERT INTO cart (domain_id) VALUES (
            (SELECT id FROM domains WHERE name = ? AND extension = ? LIMIT 1)
        )");
        
        // Check if the domain already exists in the domains table; if not, insert it
        $domainCheck = $conn->prepare("SELECT id FROM domains WHERE name = ? AND extension = ? LIMIT 1");
        $domainCheck->execute([$domain_name, $domain_extension]);
        $domain = $domainCheck->fetch(PDO::FETCH_ASSOC);

        if (!$domain) {
            $addDomain = $conn->prepare("INSERT INTO domains (name, extension, price) VALUES (?, ?, ?)");
            $addDomain->execute([$domain_name, $domain_extension, $domain_price]);
        }

        // Add the domain to the cart
        $stmt->execute([$domain_name, $domain_extension]);
        echo "<script>alert('Domain added to cart successfully!'); window.location.href = 'cart.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Fetch all domains in the cart
try {
    $cartItems = $conn->query("
        SELECT d.name, d.extension, d.price
        FROM cart c
        JOIN domains d ON c.domain_id = d.id
    ")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $cartItems = [];
    echo "<script>alert('Error fetching cart items: " . $e->getMessage() . "');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td {
            border-bottom: 1px solid #ddd;
        }
        .empty {
            text-align: center;
            font-size: 1.2em;
            color: #777;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            background-color: #28a745;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #218838;
        }
        .alert {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <?php if (count($cartItems) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Domain</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo $item['name'] . $item['extension']; ?></td>
                    <td><?php echo $item['price']; ?> PKR</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="text-align: right;">
            <a href="checkout.php" class="button">Proceed to Checkout</a>
        </div>
        <?php else: ?>
        <p class="empty">Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
