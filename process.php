<?php
session_start();

require_once 'vendor/autoload.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//  Get Form Data
$data = [
    'supplier_name'    => $_POST['supplier_name'] ?? 'Not Provided',
    'supplier_address' => $_POST['supplier_address'] ?? '',
    'supplier_phone'   => $_POST['supplier_phone'] ?? '',
    
    'customer_name'    => $_POST['customer_name'] ?? 'Not Provided',
    'customer_address' => $_POST['customer_address'] ?? '',
    'customer_phone'   => $_POST['customer_phone'] ?? '',
    
    'invoice_number'   => $_POST['invoice_number'] ?? 'INV-' . rand(1000, 9999),
    'date_issued'      => $_POST['date_issued'] ?? date('Y-m-d'),
    'due_date'         => $_POST['due_date'] ?? date('Y-m-d', strtotime('+30 days')),
    
    'items'            => [],
    'grand_total'      => 0
];

// Process Items
$subtotal = 0;
for($i = 0; $i < count($_POST['item_name'] ?? []); $i++) {
    $qty   = (float)($_POST['quantity'][$i] ?? 0);
    $price = (float)($_POST['price'][$i] ?? 0);
    $line_total = $qty * $price;
    
    $data['items'][] = [
        'name'       => $_POST['item_name'][$i] ?? '',
        'quantity'   => $qty,
        'price'      => $price,
        'line_total' => $line_total
    ];
    $subtotal += $line_total;
}

$data['grand_total'] = $subtotal;

// Save data to session
$_SESSION['invoice_data'] = $data;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= htmlspecialchars($data['invoice_number']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .invoice { max-width: 900px; margin: 0 auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2c3e50; }
        .header-info { display: flex; justify-content: space-between; margin: 30px 0; }
        table { width: 100%; border-collapse: collapse; margin: 25px 0; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; }
        th { background-color: #f0f0f0; }
        .total { text-align: right; font-size: 1.5em; margin-top: 30px; font-weight: bold; }
        .btn { 
            padding: 14px 30px; 
            margin: 10px; 
            border: none; 
            border-radius: 6px; 
            font-size: 1.1em; 
            cursor: pointer; 
        }
        .btn-print { background: #b59e7d; color: white; }
        .btn-pdf   { background: #708090; color: white; }
        .btn-print:hover { background: #aaa396; }
        .btn-pdf:hover { background: #aaa396; }
    </style>
</head>
<body>

<div class="invoice">
    <h1>INVOICE</h1>

    <div class="header-info">
        <div>
            <strong>Supplier:</strong><br>
            <?= htmlspecialchars($data['supplier_name']) ?><br>
            <?= nl2br(htmlspecialchars($data['supplier_address'])) ?><br>
            <?= htmlspecialchars($data['supplier_phone']) ?>
        </div>
        
        <div style="text-align: right;">
            <strong>Invoice Number:</strong> <?= htmlspecialchars($data['invoice_number']) ?><br>
            <strong>Date Issued:</strong> <?= date('d M, Y', strtotime($data['date_issued'])) ?><br>
            <strong>Due Date:</strong> <?= date('d M, Y', strtotime($data['due_date'])) ?>
        </div>
    </div>

    <div>
        <strong>Bill To:</strong><br>
        <?= htmlspecialchars($data['customer_name']) ?><br>
        <?= nl2br(htmlspecialchars($data['customer_address'])) ?>
    </div>

    <table>
        <tr>
            <th>Item Description</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Amount</th>
        </tr>
        <?php foreach($data['items'] as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>₦<?= number_format($item['price'], 2) ?></td>
            <td>₦<?= number_format($item['line_total'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="total">
        Grand Total: ₦<?= number_format($data['grand_total'], 2) ?>
    </div>

    <!-- Buttons -->
    <div style="text-align: center; margin-top: 50px;">
        <button class="btn btn-print" onclick="window.print()">🖨️ Print Invoice</button>
        <button class="btn btn-pdf" onclick="window.location.href='generate-pdf.php'">📄 Download PDF</button>
    </div>
</div>

</body>
</html>