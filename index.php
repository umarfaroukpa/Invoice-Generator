<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Generator</title>
</head>
<body>
    <form action="process.php" method="POST">
    <input type="text" name="customer" placeholder="Customer Name" required><br>

    <input type="text" name="item" placeholder="Item Name" required><br>

    <input type="number" name="quantity" placeholder="Quantity" required><br>

    <input type="number" name="price" placeholder="Price" required><br>

    <button type="submit">Generate Invoice</button>
</form>
</body>
</html>