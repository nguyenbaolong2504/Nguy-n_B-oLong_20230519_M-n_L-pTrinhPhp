<?php
require_once "../app/models/BorrowRepository.php";
require_once "../app/models/BookRepository.php";
require_once "../app/models/BorrowerRepository.php";

class BorrowsController extends Controller {

    // Danh sách phiếu mượn
    public function index() {
        $repo = new BorrowRepository($this->pdo);
        $borrows = $repo->all();

        $this->view("borrows/index", compact('borrows'));
    }

    // Form tạo phiếu mượn
    public function create() {
        $borrowerRepo = new BorrowerRepository($this->pdo);
        $bookRepo     = new BookRepository($this->pdo);

        $borrowers = $borrowerRepo->all();
        $books     = $bookRepo->allForBorrow();

        $this->view("borrows/create", compact('books', 'borrowers'));
    }

    // Lưu phiếu mượn (TRANSACTION)
    public function store() {
    $repo = new BorrowRepository($this->pdo);

    $borrowerId = (int)$_POST['borrower_id'];
    $items      = $_POST['items'] ?? [];

    $date = date('Y-m-d');   // ✅ ngày hiện tại
    $note = null;            // hoặc $_POST['note'] nếu có

    $result = $repo->create($borrowerId, $date, $note, $items);

    if ($result !== true) {
        $_SESSION['error'] = $result;
        $this->redirect("index.php?c=borrows&a=create");
    }

    $_SESSION['msg'] = "Tạo phiếu mượn thành công";
    $this->redirect("index.php?c=borrows");
}


    // Xem chi tiết phiếu mượn
    public function show() {
        $id = (int)$_GET['id'];

        $repo = new BorrowRepository($this->pdo);
        $data = $repo->find($id);

        $this->view("borrows/show", $data);
    }
}
