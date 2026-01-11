<?php
$errors = [];
$data = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'dob' => '',
    'gender' => 'Nam',
    'address' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($data as $k => $v) {
        $data[$k] = trim($_POST[$k] ?? '');
    }

    if ($data['name'] === '') $errors[] = "Họ tên bắt buộc";
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        $errors[] = "Email không hợp lệ";
    if (!preg_match('/^[0-9]{9,11}$/', $data['phone']))
        $errors[] = "SĐT phải là số (9–11 ký tự)";
    if ($data['dob'] === '') $errors[] = "Ngày sinh bắt buộc";

    if (!$errors) {
        header("Location: member_result.php?" . http_build_query($data));
        exit;
    }
}
?>

<form method="post">
Họ tên: <input name="name" value="<?=htmlspecialchars($data['name'])?>"><br>
Email: <input name="email" value="<?=htmlspecialchars($data['email'])?>"><br>
SĐT: <input name="phone" value="<?=htmlspecialchars($data['phone'])?>"><br>
Ngày sinh: <input type="date" name="dob" value="<?=htmlspecialchars($data['dob'])?>"><br>

Giới tính:
<input type="radio" name="gender" value="Nam" <?=$data['gender']=='Nam'?'checked':''?>>Nam
<input type="radio" name="gender" value="Nữ" <?=$data['gender']=='Nữ'?'checked':''?>>Nữ
<input type="radio" name="gender" value="Khác" <?=$data['gender']=='Khác'?'checked':''?>>Khác
<br>

Địa chỉ:<br>
<textarea name="address"><?=htmlspecialchars($data['address'])?></textarea><br>

<button>Submit</button>
<button type="reset">Reset</button>
</form>

<?php
if ($errors) {
    echo "<ul style='color:red'>";
    foreach ($errors as $e) echo "<li>$e</li>";
    echo "</ul>";
}
?>
