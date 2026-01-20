<?php
require_once "../app/models/BorrowerRepository.php";

class BorrowersController extends Controller {

    public function index() {
        $repo = new BorrowerRepository($this->pdo);
        $borrowers = $repo->all();
        $this->view("borrowers/index", compact('borrowers'));
    }

    public function create() {
        $this->view("borrowers/create");
    }

    public function store() {
        $name = trim($_POST['full_name']);
        $phone = trim($_POST['phone']);

        if ($name === '') {
            $_SESSION['msg'] = "Tên người mượn không được rỗng";
            $this->redirect("index.php?c=borrowers&a=create");
        }

        $repo = new BorrowerRepository($this->pdo);
        $repo->create([
            'name' => $name,
            'phone' => $phone
        ]);

        $_SESSION['msg'] = "Thêm người mượn thành công";
        $this->redirect("index.php?c=borrowers");
    }

    public function edit() {
        $id = (int)$_GET['id'];
        $repo = new BorrowerRepository($this->pdo);
        $borrower = $repo->find($id);
        $this->view("borrowers/edit", compact('borrower'));
    }

    public function update() {
        $repo = new BorrowerRepository($this->pdo);
        $repo->update([
            'id' => (int)$_POST['id'],
            'n'  => $_POST['full_name'],
            'p'  => $_POST['phone']
        ]);

        $_SESSION['msg'] = "Cập nhật thành công";
        $this->redirect("index.php?c=borrowers");
    }

    public function delete() {
        $repo = new BorrowerRepository($this->pdo);
        $repo->delete((int)$_POST['id']);
        $this->redirect("index.php?c=borrowers");
    }
}
