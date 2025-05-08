<?php 
include 'db.php'; 
$query = $_GET['query'];

// Define available domain extensions
$extensions = ['.com', '.org', '.net', '.io'];

// Prepare mock data for domain prices (optional if not in the database)
$base_price = 500; // Base price for a domain

// Create search results dynamically
$results = [];
foreach ($extensions as $ext) {
    $results[] = [
        'name' => $query,
        'extension' => $ext,
        'price' => $base_price + rand(100, 500) // Add a random price to simulate variation
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Results</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        button { padding: 5px 10px; }
    </style>
</head>
<body>
    <h1>Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>
    <table>
        <tr>
            <th>Domain</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><?php echo $row['name'] . $row['extension']; ?></td>
            <td><?php echo $row['price']; ?> PKR</td>
            <td>
                <form action="cart.php" method="POST">
                    <input type="hidden" name="domain_name" value="<?php echo $row['name']; ?>">
                    <input type="hidden" name="domain_extension" value="<?php echo $row['extension']; ?>">
                    <input type="hidden" name="domain_price" value="<?php echo $row['price']; ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Search Again</a>
</body>
</html>
