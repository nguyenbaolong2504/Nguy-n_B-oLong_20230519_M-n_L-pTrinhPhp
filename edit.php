<h2>✏️ Edit Borrower</h2>

<form method="post" action="index.php?c=borrowers&a=update">
    <input type="hidden" name="id" value="<?=$borrower['id']?>">

    <label>Full name:</label><br>
    <input name="full_name" value="<?=htmlspecialchars($borrower['full_name'])?>" required><br><br>

    <label>Phone:</label><br>
    <input name="phone" value="<?=htmlspecialchars($borrower['phone'])?>"><br><br>

    <button>Update</button>
</form>

<a href="index.php?c=borrowers">← Back</a>
