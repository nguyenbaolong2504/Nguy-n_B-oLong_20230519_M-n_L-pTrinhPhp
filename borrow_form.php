<form method="post" action="borrow_process.php">
    Tên thành viên:
    <input type="text" name="member_name" required><br>

    Mã sách:
    <input type="text" name="book_id" required><br>

    Ngày mượn:
    <input type="date" name="date" required><br>

    Số ngày mượn:
    <input type="number" name="days" min="1" max="30" required><br>

    <button type="submit">Mượn sách</button>
</form>
