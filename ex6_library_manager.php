<?php
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

class Book {
    public string $id;
    public string $title;
    public int $qty;

    public function __construct($id, $title, $qty) {
        $this->id = $id;
        $this->title = $title;
        $this->qty = $qty;
    }

    public function getQty(): int {
        return $this->qty;
    }

    public function getStatus(): string {
        return $this->qty > 0 ? 'Available' : 'Out of stock';
    }
}

$books = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = trim($_POST['raw'] ?? '');
    $q = trim($_POST['q'] ?? '');
    $sortDesc = isset($_POST['sort_qty']);

    $records = explode(';', $raw);

    foreach ($records as $rec) {
        $parts = explode('-', trim($rec));
        if (count($parts) !== 3) continue;

        [$id, $title, $qtyStr] = $parts;

        if (!is_numeric($qtyStr)) continue;

        $books[] = new Book($id, $title, (int)$qtyStr);
    }

    if (empty($books)) {
        $error = ' Không có dữ liệu sách hợp lệ.';
    }

    if ($q !== '') {
        $books = array_filter($books, function ($b) use ($q) {
            return stripos($b->title, $q) !== false;
        });
    }

    if ($sortDesc) {
        usort($books, fn($a, $b) => $b->getQty() <=> $a->getQty());
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Book Parser</title>
    <style>
        table { border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background: #f0f0f0; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>

<h2>Parse Book Data</h2>

<form method="post">
    <p>
        <textarea name="raw" rows="4" cols="80"
        placeholder="B001-Intro to PHP-2;B002-Web Programming-5;B003-Database Basics-1"><?= h($_POST['raw'] ?? '') ?></textarea>
    </p>

    <p>
        Tìm theo Title:
        <input type="text" name="q" value="<?= h($_POST['q'] ?? '') ?>">

        <label>
            <input type="checkbox" name="sort_qty" <?= isset($_POST['sort_qty']) ? 'checked' : '' ?>>
            Sort Qty giảm dần
        </label>
    </p>

    <button type="submit">Parse & Show</button>
</form>

<?php if ($error): ?>
    <p class="error"><?= h($error) ?></p>
<?php endif; ?>

<?php if (!empty($books)): ?>
    <h3>Danh sách sách</h3>
    <table>
        <tr>
            <th>STT</th>
            <th>BookID</th>
            <th>Title</th>
            <th>Qty</th>
            <th>Status</th>
        </tr>

        <?php foreach ($books as $i => $b): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= h($b->id) ?></td>
                <td><?= h($b->title) ?></td>
                <td><?= $b->qty ?></td>
                <td><?= $b->getStatus() ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
        $totalTitles = count($books);
        $totalQty = array_sum(array_map(fn($b) => $b->qty, $books));

        $maxBook = null;
        foreach ($books as $b) {
            if ($maxBook === null || $b->qty > $maxBook->qty) {
                $maxBook = $b;
            }
        }

        $outOfStock = count(array_filter($books, fn($b) => $b->qty == 0));
    ?>

    <h3>Thống kê</h3>
    <ul>
        <li>Tổng đầu sách: <?= $totalTitles ?></li>
        <li>Tổng số quyển: <?= $totalQty ?></li>
        <li>Sách có Qty lớn nhất: <?= h($maxBook->title) ?> (<?= $maxBook->qty ?>)</li>
        <li>Số sách Out of stock: <?= $outOfStock ?></li>
    </ul>
<?php endif; ?>

</body>
</html>
