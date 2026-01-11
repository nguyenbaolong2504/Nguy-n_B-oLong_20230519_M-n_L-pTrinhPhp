<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Truy cập không hợp lệ");
}

$memberName = trim($_POST['member_name'] ?? '');
$bookId     = trim($_POST['book_id'] ?? '');
$date       = $_POST['date'] ?? '';
$days       = (int)($_POST['days'] ?? 0);

if ($memberName === '' || $bookId === '') {
    die("Thiếu thông tin mượn sách");
}

$membersFile = __DIR__ . "/data/members.csv";
$booksFile   = __DIR__ . "/data/books.json";
$borrowsFile = __DIR__ . "/data/borrows.json";

/* ===== ĐỌC DỮ LIỆU ===== */
$members = file_exists($membersFile)
    ? array_map('trim', file($membersFile))
    : [];

$books   = file_exists($booksFile)
    ? json_decode(file_get_contents($booksFile), true)
    : [];

$borrows = file_exists($borrowsFile)
    ? json_decode(file_get_contents($borrowsFile), true)
    : [];

/* ===== KIỂM TRA THÀNH VIÊN ===== */
if (!in_array($memberName, $members)) {
    die("❌ Thành viên không tồn tại");
}

/* ===== XỬ LÝ MƯỢN ===== */
foreach ($books as &$b) {
    if ($b['id'] === $bookId) {

        if ($b['qty'] <= 0) {
            die("❌ Sách đã hết");
        }

        $b['qty']--;

        $borrows[] = [
            'borrow_id'   => uniqid("BR_"),
            'member_name' => $memberName,
            'book_id'     => $bookId,
            'borrow_date' => $date,
            'due_date'    => date('Y-m-d', strtotime("$date +$days days")),
            'status'      => 'Đang mượn'
        ];

        file_put_contents(
            $booksFile,
            json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
        file_put_contents(
            $borrowsFile,
            json_encode($borrows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        echo "<h3>✅ Mượn sách thành công</h3>";
        exit;
    }
}

die("❌ Không tìm thấy sách");
