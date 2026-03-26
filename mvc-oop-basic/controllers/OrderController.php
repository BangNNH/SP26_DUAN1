<?php

class OrderController
{
    public $modelTaiKhoan;
    public $modelGioHang;
    public $modelDonHang;


    public function __construct()
    {
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
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
                $_SESSION['order_success'] = 'Đặt hàng thành công';
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
