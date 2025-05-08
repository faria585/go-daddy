<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Domain Finder</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f7f7f7; text-align: center; padding: 20px; }
        header { font-size: 24px; font-weight: bold; margin-bottom: 20px; }
        input[type="text"], button { padding: 10px; margin: 10px; }
    </style>
</head>
<body>
    <header>Domain Finder</header>
    <form action="search.php" method="GET">
        <input type="text" name="query" placeholder="Enter a domain name" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>
