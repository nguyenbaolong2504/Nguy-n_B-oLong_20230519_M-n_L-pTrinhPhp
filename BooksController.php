<?php
require_once "../app/models/BookRepository.php";

class BooksController extends Controller {

    public function index() {
        $kw = trim($_GET['kw'] ?? '');

        $allowedSort = ['title','price','qty','created_at'];
        $sort = in_array($_GET['sort'] ?? '', $allowedSort)
                ? $_GET['sort'] : 'created_at';
        $dir = ($_GET['dir'] ?? '') === 'asc' ? 'ASC' : 'DESC';

        $repo = new BookRepository($this->pdo);
        $books = $repo->all($kw, $sort, $dir);

        $this->view("books/index", compact('books'));
    }

    public function create() {
        $this->view("books/create");
    }

    public function store() {
        $repo = new BookRepository($this->pdo);

        $repo->create([
            't' => $_POST['title'],
            'a' => $_POST['author'],
            'p' => (float)$_POST['price'],
            'q' => (int)$_POST['qty']
        ]);

        $_SESSION['msg'] = "Thêm sách thành công";
        $this->redirect("index.php?c=books");
    }

    public function edit() {
        $id = (int)$_GET['id'];
        $repo = new BookRepository($this->pdo);
        $book = $repo->find($id);
        $this->view("books/edit", compact('book'));
    }

    public function update() {
        $repo = new BookRepository($this->pdo);

        $repo->update([
            'id' => (int)$_POST['id'],
            't'  => $_POST['title'],
            'a'  => $_POST['author'],
            'p'  => (float)$_POST['price'],
            'q'  => (int)$_POST['qty']
        ]);

        $_SESSION['msg'] = "Cập nhật thành công";
        $this->redirect("index.php?c=books");
    }

    public function delete() {
        $repo = new BookRepository($this->pdo);
        $repo->delete((int)$_POST['id']);
        $this->redirect("index.php?c=books");
    }
}
