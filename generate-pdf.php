<?php
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();

if (!isset($_SESSION['invoice_data'])) {
    die("No invoice data found!");
}

$data = $_SESSION['invoice_data'];

// Build HTML for PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice ' . htmlspecialchars($data['invoice_number']) . '</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 30px 40px; 
            line-height: 1.5; 
        }
        h1 { text-align: center; color: #2c3e50; }
        .info { display: flex; justify-content: space-between; margin: 30px 0; }
        table { width: 100%; border-collapse: collapse; margin: 25px 0; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
        .total { text-align: right; font-size: 1.4em; margin-top: 40px; font-weight: bold; }

        html, body {
        height: auto;
        margin: 0;
        padding: 0;
    }
    </style>
</head>
<body>
    <h1>INVOICE</h1>
    
    <div class="info">
        <div>
            <strong>Supplier:</strong><br>
            ' . htmlspecialchars($data['supplier_name']) . '<br>
            ' . nl2br(htmlspecialchars($data['supplier_address'])) . '
        </div>
        <div style="text-align:right;">
            <strong>Invoice No:</strong> ' . htmlspecialchars($data['invoice_number']) . '<br>
            <strong>Date:</strong> ' . date("d M, Y", strtotime($data['date_issued'])) . '<br>
            <strong>Due Date:</strong> ' . date("d M, Y", strtotime($data['due_date'])) . '
        </div>
    </div>

    <div>
        <strong>Bill To:</strong><br>
        ' . htmlspecialchars($data['customer_name']) . '<br>
        ' . nl2br(htmlspecialchars($data['customer_address'])) . '
    </div>

    <table>
        <tr>
            <th>Item Description</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Amount</th>
        </tr>';

foreach($data['items'] as $item) {
    $html .= '
        <tr>
            <td>' . htmlspecialchars($item['name']) . '</td>
            <td style="text-align:center;">' . $item['quantity'] . '</td>
            <td style="text-align:right;">NGN ' . number_format($item['price'], 2) . '</td>
            <td style="text-align:right;">NGN ' . number_format($item['line_total'], 2) . '</td>
        </tr>';
}

$html .= '
    </table>
    <div class="total">
        Grand Total: NGN ' . number_format($data['grand_total'], 2) . '
    </div>
</body>
</html>';

// Generate PDF
$options = new Options();
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("Invoice_" . $data['invoice_number'] . ".pdf", ["Attachment" => true]);
?>