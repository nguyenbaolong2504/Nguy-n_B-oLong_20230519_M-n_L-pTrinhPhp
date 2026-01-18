<?php
require_once __DIR__ . '/../core/Database.php';

class StudentModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all() {
        return $this->db->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function exists($field, $value, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM students WHERE $field=?";
        $params = [$value];
        if ($excludeId) {
            $sql .= " AND id!=?";
            $params[] = $excludeId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function create($data) {
        $sql = "INSERT INTO students(code, full_name, email, dob)
                VALUES (:code,:full_name,:email,:dob)";
        return $this->db->prepare($sql)->execute($data);
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $sql = "UPDATE students SET
                code=:code, full_name=:full_name,
                email=:email, dob=:dob
                WHERE id=:id";
        return $this->db->prepare($sql)->execute($data);
    }

    public function delete($id) {
        return $this->db->prepare("DELETE FROM students WHERE id=?")->execute([$id]);
    }
}
