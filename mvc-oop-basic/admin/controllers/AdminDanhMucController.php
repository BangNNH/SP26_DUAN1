<?php
class AdminDanhMucController
{
    public $modelDanhMuc;

    public function __construct()
    {
        $this->modelDanhMuc = new AdminDanhMuc();
    }

    public function danhSachDanhMuc()
    {
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        require_once './views/danhmuc/listDanhMuc.php';
    }

    //  hiển thị form thêm danh mục
    public function formAddDanhMuc()
    {
        require_once './views/danhmuc/addDanhMuc.php';
        // Xóa session sau khi load trang
        deleteSessionError();
    }

    // thêm danh mục
    public function postAddDanhMuc()
    {
        //Kiểm tra xem dữ liệu có phải được submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Lấy ra dữ liệu
            $ten_danh_muc = $_POST['ten_danh_muc'] ?? '';
            $mo_ta = $_POST['mo_ta'];

            // validate
            $errors = [];
            if (empty($ten_danh_muc)) {
                $errors['ten_danh_muc'] = 'Tên danh mục không được để trống.';
            }

            $_SESSION['errors'] = $errors;

            if (empty($errors)) {
                // Nếu không lỗi thì tiến hành thêm danh mục
                $this->modelDanhMuc->insertDanhMuc($ten_danh_muc, $mo_ta);
                $_SESSION['success'] = 'Thêm danh mục thành công.';
                header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
                exit();
            } else {
                // Trả về form lỗi
                // Đặt chỉ thị xóa session sau khi hiển thị form
                $_SESSION['flash'] = true;
                require_once './views/danhmuc/addDanhMuc.php';
            }
        }
    }

    //hiển thị form sửa
    public function formEditDanhMuc()
    {
        // Lấy ra thông tin của danh mục cần sửa
        $id = $_GET['id_danh_muc'];
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        if ($danhMuc) {
            require_once './views/danhmuc/editDanhMuc.php';
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
            exit();
        }
    }

    //sửa dữ liệu danh mục
    public function postEditDanhMuc()
    {
        //Kiểm tra xem dữ liệu có phải được submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Lấy ra dữ liệu
            $id = $_POST['id'];
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];


            // validate
            $errors = [];
            if (empty($ten_danh_muc)) {
                $errors['ten_danh_muc'] = 'Tên danh mục không được để trống.';
            }

            if (empty($errors)) {
                // Nếu không lỗi thì tiến hành sửa danh mục
                $this->modelDanhMuc->updateDanhMuc($id, $ten_danh_muc, $mo_ta);
                $_SESSION['success'] = 'Sửa danh mục thành công.';
                header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
                exit();
            } else {
                // Trả về form lỗi
                $danhMuc = ['id' => $id, 'ten_danh_muc' => $ten_danh_muc, 'mo_ta' => $mo_ta];
                require_once './views/danhmuc/editDanhMuc.php';
            }
        }
    }

    //xóa danh mục
    public function deleteDanhMuc()
    {
        // Lấy ra thông tin của danh mục cần xóa
        $id = $_GET['id_danh_muc'];
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        if ($danhMuc) {
            $this->modelDanhMuc->destroyDanhMuc($id);
        }
        $_SESSION['success'] = 'Xóa danh mục thành công.';
        header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
        exit();
    }
}
