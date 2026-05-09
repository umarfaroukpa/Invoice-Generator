<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Generator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main>
    <div class="logo">
        <img src="invoice.png" alt="Invoice Logo" class="invoice-logo">
    </div>

    <header>
        <h1>INVOICE GENERATOR</h1>
    </header>

    <form action="process.php" method="POST" class="invoice-form">

        <!-- Supplier & Customer Side by Side -->
        <div class="two-column">
            
            <!-- Supplier -->
            <div class="box">
                <h3>From (Supplier)</h3>
                <input type="text" name="supplier_name" placeholder="Supplier / Company Name" required>
                <input type="text" name="supplier_address" placeholder="Address" required>
                <input type="text" name="supplier_phone" placeholder="Phone Number" required>
                <input type="email" name="supplier_email" placeholder="Email Address">
            </div>

            <!-- Customer -->
            <div class="box">
                <h3>Bill To (Customer)</h3>
                <input type="text" name="customer_name" placeholder="Customer / Company Name" required>
                <input type="text" name="customer_address" placeholder="Address" required>
                <input type="text" name="customer_phone" placeholder="Phone Number" required>
                <input type="email" name="customer_email" placeholder="Email Address">
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="form-row">
            <div>
                <label>Invoice Number</label>
                <input type="text" name="invoice_number" value="INV-<?= date('Ymd') ?>-<?= rand(100, 999) ?>" required>
            </div>
            <div>
                <label>Date Issued</label>
                <input type="date" name="date_issued" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div>
                <label>Payment Due Date</label>
                <input type="date" name="due_date" value="<?= date('Y-m-d', strtotime('+30 days')) ?>" required>
            </div>
        </div>

        <!-- Items Section -->
        <h3>Invoice Items</h3>
        <div class="items">
            <div class="form-row item-row">
                <input type="text" name="item_name[]" placeholder="Item Description" required>
                <input type="number" name="quantity[]" placeholder="Qty" min="1" required>
                <input type="number" name="price[]" placeholder="Unit Price" step="0.01" required>
            </div>
        </div>

        <button type="button" id="add-item">+ Add Another Item</button>
        <br><br>

        <button type="submit" class="generate-btn">Generate Invoice</button>
    </form>
</main>

<script>
// Add more item rows dynamically
document.getElementById('add-item').addEventListener('click', function() {
    const itemsDiv = document.querySelector('.items');
    const newRow = document.createElement('div');
    newRow.className = 'form-row item-row';
    newRow.innerHTML = `
        <input type="text" name="item_name[]" placeholder="Item Description" required>
        <input type="number" name="quantity[]" placeholder="Qty" min="1" required>
        <input type="number" name="price[]" placeholder="Unit Price" step="0.01" required>
    `;
    itemsDiv.appendChild(newRow);
});
</script>

</body>
</html>