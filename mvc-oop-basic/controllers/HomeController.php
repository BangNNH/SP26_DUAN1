<?php

class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoan;


    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
    }

    public function home()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        function calcDiscountPercent($originalPrice, $salePrice)
        {
            if ($originalPrice <= 0 || $salePrice >= $originalPrice) {
                return 0;
            }

            return round((($originalPrice - $salePrice) / $originalPrice) * 100);
        }

        $listSanPhamBanChay = $this->modelSanPham->getSanPhamBanChay();
        $listSanPhamMoi = $this->modelSanPham->getSanPhamMoi();
        $listAutomatic =  $this->modelSanPham->getSanPhamByLoai('Automatic');
        $listQuartz =  $this->modelSanPham->getSanPhamByLoai('Quartz');
        $listEco =  $this->modelSanPham->getSanPhamByLoai('Eco-Drive');
        $listSport =  $this->modelSanPham->getSanPhamByLoai('Sport');
        $listSmart =  $this->modelSanPham->getSanPhamByLoai('Smartwatch');
        require_once './views/home.php';
    }


    public function chiTietSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);
        $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id'], $id);
        if ($sanPham) {
            require_once './views/detailSanPham.php';
        } else {
            header("Location: " . BASE_URL);
            exit();
        }
    }

    public function formLogin()
    {
        require_once __DIR__ . '/../views/auth/formLogin.php';
        deleteSessionError();
    }

    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // lấy email và pass gửi lên từ form
            $email = $_POST['email'];
            $password = trim($_POST['password']);;

            // Xử lí kiểm tra thông tin đăng nhập
            $user = $this->modelTaiKhoan->checkLogin($email, $password);

            // Nếu trả về email (dạng string hợp lệ) là đăng nhập thành công
            if (is_string($user) && filter_var($user, FILTER_VALIDATE_EMAIL)) {
                // Lưu email vào session để dùng hiển thị
                $_SESSION['user_client'] = $user;
                $_SESSION['login_success'] = "Đăng nhập thành công";
                header("Location: " . BASE_URL);
                exit();
            } else {
                // Lỗi thì lưu lỗi vào session và xoá session user nếu có
                unset($_SESSION['user_admin']);
                $_SESSION['error'] = $user;
                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL . '?act=login');
                exit();
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['user_client']);
        header("Location: " . BASE_URL . '?act=/');
        exit();
    }
}
