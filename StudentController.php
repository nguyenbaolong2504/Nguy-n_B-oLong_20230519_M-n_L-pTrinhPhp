<?php
require_once "../app/core/BaseController.php";
require_once "../app/models/StudentModel.php";

class StudentController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new StudentModel();
    }

    public function index() {
        $this->view('students/index');
    }

    public function api() {
        $action = $_REQUEST['action'] ?? '';

        try {
            switch ($action) {

                case 'list':
                    $this->json([
                        'success' => true,
                        'message' => 'Danh sách sinh viên',
                        'data' => $this->model->all()
                    ]);
                    break;

                case 'create':
                    $errors = $this->validate($_POST);

                    if ($this->model->exists('code', $_POST['code']))
                        $errors['code'] = 'Mã SV đã tồn tại';

                    if ($this->model->exists('email', $_POST['email']))
                        $errors['email'] = 'Email đã tồn tại';

                    if (!empty($errors)) {
                        $this->json(['success'=>false,'errors'=>$errors]);
                    }

                    $this->model->create([
                        'code'=>$_POST['code'],
                        'full_name'=>$_POST['full_name'],
                        'email'=>$_POST['email'],
                        'dob'=>$_POST['dob'] ?: null
                    ]);

                    $this->json(['success'=>true,'message'=>'Thêm thành công']);
                    break;

                case 'update':
                    $id = $_POST['id'] ?? 0;

                    if (!$this->model->find($id)) {
                        $this->json(['success'=>false,'message'=>'ID không tồn tại']);
                    }

                    $errors = $this->validate($_POST);

                    if ($this->model->exists('code', $_POST['code'], $id))
                        $errors['code'] = 'Mã SV đã tồn tại';

                    if ($this->model->exists('email', $_POST['email'], $id))
                        $errors['email'] = 'Email đã tồn tại';

                    if (!empty($errors)) {
                        $this->json(['success'=>false,'errors'=>$errors]);
                    }

                    $this->model->update($id, [
                        'code'=>$_POST['code'],
                        'full_name'=>$_POST['full_name'],
                        'email'=>$_POST['email'],
                        'dob'=>$_POST['dob'] ?: null
                    ]);

                    $this->json(['success'=>true,'message'=>'Cập nhật thành công']);
                    break;

                case 'delete':
                    $id = $_POST['id'] ?? 0;

                    if (!$this->model->find($id)) {
                        $this->json(['success'=>false,'message'=>'ID không tồn tại']);
                    }

                    $this->model->delete($id);
                    $this->json(['success'=>true,'message'=>'Xóa thành công']);
                    break;

                default:
                    $this->json(['success'=>false,'message'=>'Action không hợp lệ']);
            }

        } catch (Exception $e) {
            $this->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    private function validate($data) {
        $errors = [];

        if (empty($data['code']))
            $errors['code'] = 'Bắt buộc';

        if (empty($data['full_name']))
            $errors['full_name'] = 'Bắt buộc';

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            $errors['email'] = 'Email không hợp lệ';

        return $errors;
    }
}
