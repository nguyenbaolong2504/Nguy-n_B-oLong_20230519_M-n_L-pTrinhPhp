<?php
class BookRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function all($kw, $sort, $dir) {
        $sql = "SELECT * FROM books
                WHERE title LIKE :kw OR author LIKE :kw
                ORDER BY $sort $dir";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['kw' => "%$kw%"]);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($d) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO books(title,author,price,qty)
             VALUES(:t,:a,:p,:q)"
        );
        return $stmt->execute($d);
    }

    public function update($d) {
        $stmt = $this->pdo->prepare(
            "UPDATE books SET title=:t,author=:a,price=:p,qty=:q WHERE id=:id"
        );
        return $stmt->execute($d);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id=?");
        return $stmt->execute([$id]);
    }
    public function allForBorrow() {
    $sql = "SELECT * FROM books WHERE qty > 0 ORDER BY title";
    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

}
