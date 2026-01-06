<?php
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
class Student {
    public string $id;
    public string $name;
    public float $gpa;

    public function __construct($id, $name, $gpa) {
        $this->id = $id;
        $this->name = $name;
        $this->gpa = $gpa;
    }

    public function getGpa(): float {
        return $this->gpa;
    }

    public function getRank(): string {
        if ($this->gpa >= 3.6) return 'Giỏi';
        if ($this->gpa >= 3.0) return 'Khá';
        if ($this->gpa >= 2.0) return 'Trung bình';
        return 'Yếu';
    }
}

$students = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = trim($_POST['raw'] ?? '');
    $threshold = $_POST['threshold'] ?? '';
    $sortDesc = isset($_POST['sort_desc']);

    $records = explode(';', $raw);

    foreach ($records as $rec) {
        $parts = explode('-', trim($rec));
        if (count($parts) !== 3) continue;

        [$id, $name, $gpaStr] = $parts;

        if (!is_numeric($gpaStr)) continue;

        $students[] = new Student($id, $name, (float)$gpaStr);
    }

    if (empty($students)) {
        $error = ' Không có dữ liệu sinh viên hợp lệ.';
    }

    if ($threshold !== '' && is_numeric($threshold)) {
        $students = array_filter($students, function ($s) use ($threshold) {
            return $s->gpa >= (float)$threshold;
        });
    }

    if ($sortDesc) {
        usort($students, fn($a, $b) => $b->getGpa() <=> $a->getGpa());
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Parse Student</title>
    <style>
        table { border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background: #f2f2f2; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>

<h2>Parse & Show Student</h2>

<form method="post">
    <p>
        <textarea name="raw" rows="4" cols="80"
            placeholder="SV001-An-3.2;SV002-Binh-2.6;SV003-Chi-3.5"><?= h($_POST['raw'] ?? '') ?></textarea>
    </p>

    <p>
        GPA ≥ <input type="text" name="threshold" value="<?= h($_POST['threshold'] ?? '') ?>">
        <label>
            <input type="checkbox" name="sort_desc" <?= isset($_POST['sort_desc']) ? 'checked' : '' ?>>
            Sort GPA giảm dần
        </label>
    </p>

    <button type="submit">Parse & Show</button>
</form>

<?php if ($error): ?>
    <p class="error"><?= h($error) ?></p>
<?php endif; ?>

<?php if (!empty($students)): ?>
    <h3>Danh sách sinh viên</h3>
    <table>
        <tr>
            <th>STT</th>
            <th>MSSV</th>
            <th>Tên</th>
            <th>GPA</th>
            <th>Xếp loại</th>
        </tr>

        <?php foreach ($students as $i => $s): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= h($s->id) ?></td>
                <td><?= h($s->name) ?></td>
                <td><?= $s->gpa ?></td>
                <td><?= $s->getRank() ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
        $gpas = array_map(fn($s) => $s->gpa, $students);
        $avg = array_sum($gpas) / count($gpas);
        $max = max($gpas);
        $min = min($gpas);

        $rankCount = [];
        foreach ($students as $s) {
            $rank = $s->getRank();
            $rankCount[$rank] = ($rankCount[$rank] ?? 0) + 1;
        }
    ?>

    <h3>Thống kê</h3>
    <ul>
        <li>GPA trung bình: <?= round($avg, 2) ?></li>
        <li>GPA cao nhất: <?= $max ?></li>
        <li>GPA thấp nhất: <?= $min ?></li>
        <?php foreach ($rankCount as $rank => $cnt): ?>
            <li><?= h($rank) ?>: <?= $cnt ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
