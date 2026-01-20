<h2>Tạo phiếu mượn</h2>

<?php if(!empty($_SESSION['error'])): ?>
<p style="color:red">
    <?= htmlspecialchars($_SESSION['error']) ?>
</p>
<?php unset($_SESSION['error']); endif; ?>

<form method="post" action="index.php?c=borrows&a=store">

<label>Người mượn:</label>
<select name="borrower_id" required>
<?php foreach($borrowers as $b): ?>
    <option value="<?= $b['id'] ?>">
        <?= htmlspecialchars($b['full_name']) ?>
    </option>
<?php endforeach ?>
</select>

<br><br>

<label>Ngày mượn:</label>
<input type="date" name="borrow_date" required>

<br><br>

<label>Ghi chú:</label>
<input type="text" name="note">

<hr>

<h4>Sách mượn</h4>
<?php foreach($books as $bk): ?>
    <?= htmlspecialchars($bk['title']) ?> (Còn <?= $bk['qty'] ?>)
    <input type="number"
           name="items[<?= $bk['id'] ?>]"
           min="0"
           max="<?= $bk['qty'] ?>"
           value="0">
    <br>
<?php endforeach ?>

<br>
<button type="submit">Tạo phiếu</button>
</form>
