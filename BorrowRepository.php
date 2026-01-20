<?php
class BorrowRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Danh sách phiếu mượn
    public function all() {
        $sql = "SELECT 
                    b.id,
                    br.full_name,
                    b.borrow_date,
                    b.note
                FROM borrows b
                JOIN borrowers br ON b.borrower_id = br.id
                ORDER BY b.id DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tạo phiếu mượn + chi tiết (TRANSACTION)
   public function create($borrower_id, $date, $note, $items) {
    try {
        $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare(
            "INSERT INTO borrows (borrower_id, borrow_date, note)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([$borrower_id, $date, $note]);

        $borrow_id = $this->pdo->lastInsertId();

        foreach ($items as $book_id => $qty) {
            if ($qty <= 0) continue; // ✅ bỏ sách không mượn

            $q = $this->pdo->prepare("SELECT qty FROM books WHERE id=?");
            $q->execute([$book_id]);
            $stock = $q->fetchColumn();

            if ($stock < $qty) {
                throw new Exception("Sách ID $book_id không đủ số lượng");
            }

            $this->pdo->prepare(
                "INSERT INTO borrow_items (borrow_id, book_id, qty)
                 VALUES (?, ?, ?)"
            )->execute([$borrow_id, $book_id, $qty]);

            $this->pdo->prepare(
                "UPDATE books SET qty = qty - ? WHERE id=?"
            )->execute([$qty, $book_id]);
        }

        $this->pdo->commit();
        return true;

    } catch (Exception $e) {
        $this->pdo->rollBack();
        return $e->getMessage();
    }
}


    // Xem chi tiết phiếu mượn
    public function find($id) {
        $stmt = $this->pdo->prepare(
            "SELECT 
                b.id,
                br.full_name,
                b.borrow_date,
                b.note
             FROM borrows b
             JOIN borrowers br ON b.borrower_id = br.id
             WHERE b.id=?"
        );
        $stmt->execute([$id]);
        $borrow = $stmt->fetch(PDO::FETCH_ASSOC);

        $items = $this->pdo->prepare(
            "SELECT bo.title, bi.qty
             FROM borrow_items bi
             JOIN books bo ON bi.book_id = bo.id
             WHERE bi.borrow_id=?"
        );
        $items->execute([$id]);

        return [
            'borrow' => $borrow,
            'items'  => $items->fetchAll(PDO::FETCH_ASSOC)
        ];
    }
}
