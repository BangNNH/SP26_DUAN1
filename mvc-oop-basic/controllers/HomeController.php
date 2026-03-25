<?php

class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoan;
    public $modelGioHang;
    public $modelDonHang;


    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
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

    public function addGioHang()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $san_pham_id = $_POST['san_pham_id'] ?? 0;
            $so_luong = $_POST['so_luong'] ?? 1;

            if (isset($_SESSION['user_client'])) {
                // LUỒNG DB khi user đã login
                $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);

                $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);

                if (!$gioHang) {
                    $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                    $gioHang = ['id' => $gioHangId];
                }

                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

                $checkSanPham = false;

                foreach ($chiTietGioHang as $detail) {
                    if ($detail['san_pham_id'] == $san_pham_id) {
                        $newSoLuong = $detail['so_luong'] + $so_luong;
                        $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
                        $checkSanPham = true;
                        break;
                    }
                }

                if (!$checkSanPham) {
                    $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);
                }
                header("Location: " . BASE_URL . '?act=gio-hang');
                exit();
            } else {
                // LUỒNG SESSION khi user chưa login
                $_SESSION['openCart'] = true;
                $this->addToCartSession($san_pham_id, $so_luong);
                header("Location: " . ($_SERVER['HTTP_REFERER'] ?? BASE_URL));
                exit();
            }
        }
    }

    function addToCartSession($san_pham_id, $so_luong)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$san_pham_id])) {
            $_SESSION['cart'][$san_pham_id]['so_luong'] += $so_luong;
        } else {
            $_SESSION['cart'][$san_pham_id] = [
                'so_luong' => $so_luong
            ];
        }
    }


    public function gioHang()
    {
        if (isset($_SESSION['user_client'])) {
            // LUỒNG DB
            unset($_SESSION['cart']);
            $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);

            $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);

            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                $gioHang = ['id' => $gioHangId];
            }

            $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        } else {
            // LUỒNG SESSION 
            // $_SESSION['openCart'] = true;
            $chiTietGioHang = getCartFromSession();
        }

        require_once './views/gioHang.php';
    }

    public function thanhToan()
    {
        if (isset($_SESSION['user_client'])) {
            // LUỒNG USER LOGIN (DB)
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);

            $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);

            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($user['id']);
                $gioHang = ['id' => $gioHangId];
            }

            $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        } else {
            // LUỒNG KHÁCH (SESSION)
            $chiTietGioHang = getCartFromSession();
        }

        // 👉 dùng chung view
        require_once './views/thanhToan.php';
    }

    public function postThanhToan()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // Lấy dữ liệu form
            $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'];
            $email_nguoi_nhan = $_POST['email_nguoi_nhan'];
            $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'];
            $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'];
            $ghi_chu = $_POST['ghi_chu'];
            $tong_tien = $_POST['tong_tien'];
            $phuong_thuc_thanh_toan_id = $_POST['phuong_thuc_thanh_toan_id'];

            $ngay_dat = date('Y-m-d H:i:s');
            $trang_thai_id = 1;
            $ma_don_hang = 'DH' . rand(1000, 9999);

            // PHÂN LUỒNG
            if (isset($_SESSION['user_client'])) {
                // USER LOGIN
                $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
                $tai_khoan_id = $user['id'];

                $gioHang = $this->modelGioHang->getGioHangFromUser($tai_khoan_id);
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            } else {
                // GUEST
                $tai_khoan_id = null;

                $chiTietGioHang = getCartFromSession(); // lấy từ session
            }

            // Thêm đơn hàng
            $donHang = $this->modelDonHang->addDonHang(
                $tai_khoan_id,
                $ten_nguoi_nhan,
                $email_nguoi_nhan,
                $sdt_nguoi_nhan,
                $dia_chi_nguoi_nhan,
                $ghi_chu,
                $tong_tien,
                $phuong_thuc_thanh_toan_id,
                $ngay_dat,
                $trang_thai_id,
                $ma_don_hang
            );

            // Thêm chi tiết đơn hàng
            if ($donHang) {

                foreach ($chiTietGioHang as $item) {

                    $donGia = ($item['gia_khuyen_mai'] > 0)
                        ? $item['gia_khuyen_mai']
                        : $item['gia_san_pham'];

                    $this->modelDonHang->addChiTietDonHang(
                        $donHang,
                        $item['san_pham_id'] ?? $item['id'], // fix cho session
                        $donGia,
                        $item['so_luong'],
                        $donGia * $item['so_luong']
                    );
                }

                // CLEAR CART
                if (isset($_SESSION['user_client'])) {
                    // DB
                    $this->modelGioHang->clearDetailGioHang($gioHang['id']);
                    $this->modelGioHang->clearGioHang($tai_khoan_id);
                } else {
                    // SESSION
                    unset($_SESSION['cart']);
                }

                // REDIRECT
                header("Location: " . BASE_URL . '?act=/');
                exit;
            } else {
                echo "Lỗi đặt hàng";
                die;
            }
        }
    }

    public function lichSuMuaHang()
    {
        if (isset(($_SESSION['user_client']))) {
            // Lấy ra thông tin tài khoản đăng Nhập
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $taiKhoanId = $user['id'];

            //Lấy ra danh sách trạng thái đơn hàng
            $arTrangThaiDonHang = $this->modelDonHang->getTrangThaiDonHang();
            $trangThaiDonHang = array_column($arTrangThaiDonHang, 'ten_trang_thai', 'id');

            //Lấy ra danh sách phương thức thanh toán
            $arPhuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
            $phuongThucThanhToan = array_column($arPhuongThucThanhToan, 'ten_phuong_thuc', 'id');

            // Lấy ra danh sách tất cả đơn hàng của tài khoản
            $donHangs = $this->modelDonHang->getDonHangFromUser($taiKhoanId);
            require_once "./views/lichSuMuaHang.php";
        } else {
            var_dump("Vui lòng đăng nhập");
            die;
        }
    }

    public function chiTietMuaHang()
    {
        if (isset(($_SESSION['user_client']))) {
            // Lấy ra thông tin tài khoản đăng Nhập
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $tai_khoan_Id = $user['id'];

            //lấy id đơn hàng truyền từ BASE_URL
            $donHangId = $_GET['id'];

            //Lấy ra danh sách trạng thái đơn hàng
            $arTrangThaiDonHang = $this->modelDonHang->getTrangThaiDonHang();
            $trangThaiDonHang = array_column($arTrangThaiDonHang, 'ten_trang_thai', 'id');

            //Lấy ra danh sách phương thức thanh toán
            $arPhuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
            $phuongThucThanhToan = array_column($arPhuongThucThanhToan, 'ten_phuong_thuc', 'id');

            //lấy ra thông tin đơn hàng theo id
            $donHang = $this->modelDonHang->getDonHangById($donHangId);

            //lấy thông tin sản phẩm của đơn hàng trong bản chi tiết đơn hàng
            $chiTietDonHang = $this->modelDonHang->getChiTietDonHangByDonHangId($donHangId);

            // echo "<pre>";
            // print_r($donHang);
            // print_r($chiTietDonHang);

            if ($donHang['tai_khoan_id'] != $tai_khoan_Id) {
                echo "Bạn không có quyền xem đơn hàng này";
                exit;
            }

            require_once "./views/chiTietMuaHang.php";
        } else {
            var_dump("Vui lòng đăng nhập");
            die;
        }
    }
    public function huyDonHang()
    {
        if (isset(($_SESSION['user_client']))) {
            // Lấy ra thông tin tài khoản đăng Nhập
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $tai_khoan_Id = $user['id'];

            //lấy id đơn hàng truyền từ BASE_URL
            $donHangId = $_GET['id'];

            //Kiểm tra đơn hàng
            $donHang = $this->modelDonHang->getDonHangById($donHangId);

            if ($donHang['tai_khoan_id'] != $tai_khoan_Id) {
                echo "Bạn không có quyền hủy đơn hàng này";
                exit;
            }

            if ($donHang['trang_thai_id'] != 1) {
                echo "Chỉ đơn hàng chưa xác nhận mới có thể hủy";
                exit;
            }

            //hủy đơn hàng
            $this->modelDonHang->updateTrangThaiDonHang($donHangId, 11);
            header("Location: " . BASE_URL . '?act=lich-su-mua-hang');
            exit;
        } else {
            var_dump("Vui lòng đăng nhập");
            die;
        }
    }
}
