<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./assets/script.js"></script>
    <link href="./assets/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="main">
        <h1>Products Table</h1>
        <form method="POST" action="index.php" id="updateForm">
            <input type="hidden" name="action" value="data-update">
            <button type="submit" class="btn-update">Update / Sync Data</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Number</th>
                    <th style="max-width: 400px;">Name</th>
                    <th>Bottle Size</th>
                    <th style="text-align: right;">Price EUR</th>
                    <th style="text-align: right;">Price GBP</th>
                    <th>Timestamp</th>
                    <th>Order Amount</th>
                    <th style="min-width: 100px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['number']); ?></td>
                            <td style="max-width: 400px;"><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['bottlesize']); ?></td>
                            <td style="text-align: right;"><?= htmlspecialchars($row['price']); ?></td>
                            <td style="text-align: right;"><?= htmlspecialchars($row['priceGBP']); ?></td>
                            <td><?= htmlspecialchars($row['timestamp']); ?></td>
                            <td id="order-<?= $row['number'] ?>"><?= htmlspecialchars($row['orderamount']); ?></td>
                            <td style="min-width: 100px">
                                <button class="add-btn" data-number="<?= $row['number'] ?>">Add</button>
                                <button class="clear-btn" data-number="<?= $row['number'] ?>">Clear</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No data found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
