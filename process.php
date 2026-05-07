<?php
$customer = $_POST['customer'];
$item = $_POST['item'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

$total = $quantity * $price;
?>

<h2>Invoice</h2>
<p>Customer: <?php echo $customer; ?></p>
<p>Item: <?php echo $item; ?></p>
<p>Quantity: <?php echo $quantity; ?></p>
<p>Price: <?php echo $price; ?></p>

<h3>Total: <?php echo $total; ?></h3>