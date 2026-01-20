<?php
class BorrowerRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $sql = "SELECT * FROM borrowers ORDER BY created_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM borrowers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data) {
        $sql = "INSERT INTO borrowers(full_name, phone)
                VALUES (:n, :p)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'n' => $data['name'],
            'p' => $data['phone']
        ]);
    }

    public function update(array $data) {
        $sql = "UPDATE borrowers
                SET full_name=:n, phone=:p
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function delete(int $id) {
        $stmt = $this->pdo->prepare("DELETE FROM borrowers WHERE id=?");
        $stmt->execute([$id]);
    }
}
