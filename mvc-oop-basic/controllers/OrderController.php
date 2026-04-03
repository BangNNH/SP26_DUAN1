<?php

class OrderController
{
    public $modelTaiKhoan;
    public $modelGioHang;
    public $modelDonHang;
    public $modelSanPham;


    public function __construct()
    {
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
        $this->modelSanPham = new SanPham();
    }

    /**
     * Kiểm tra tồn kho cho các sản phẩm trong giỏ
     * @param array $chiTietGioHang - Danh sách sản phẩm cần kiểm tra
     * @return array ['status' => true/false, 'errors' => ['lỗi1', 'lỗi2', ...]]
     */
    private function validateStockForCheckout($chiTietGioHang)
    {
        $errors = [];

        if (empty($chiTietGioHang)) {
            $errors[] = 'Giỏ hàng của bạn trống';
            return ['status' => false, 'errors' => $errors];
        }

        // Kiểm tra từng sản phẩm
        foreach ($chiTietGioHang as $item) {
            $san_pham_id = $item['san_pham_id'] ?? $item['id'];
            $so_luong = $item['so_luong'];

            $checkResult = $this->modelSanPham->checkStock($san_pham_id, $so_luong);

            if (!$checkResult['status']) {
                $errors[] = $checkResult['message'];
            }
        }

        if (!empty($errors)) {
            return ['status' => false, 'errors' => $errors];
        }

        return ['status' => true, 'errors' => []];
    }



    public function thanhToan()
    {
        $direct_san_pham_id = $_POST['san_pham_id'] ?? $_GET['san_pham_id'] ?? null;
        $direct_so_luong = isset($_POST['so_luong']) ? (int)$_POST['so_luong'] : 1;

        // Nếu user đã đăng nhập, luôn lấy thông tin user để fill form
        $user = null;
        if (isset($_SESSION['user_client'])) {
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
        }

        if ($direct_san_pham_id) {
            // Mua ngay từ chi tiết sản phẩm, ngay cả khi chưa đăng nhập
            $product = getProductById($direct_san_pham_id);
            $chiTietGioHang = [];
            if ($product) {
                $chiTietGioHang[] = [
                    'san_pham_id' => $product['id'],
                    'id' => $product['id'],
                    'ten_san_pham' => $product['ten_san_pham'],
                    'gia_san_pham' => $product['gia_san_pham'],
                    'gia_khuyen_mai' => $product['gia_khuyen_mai'],
                    'hinh_anh' => $product['hinh_anh'],
                    'so_luong' => max(1, $direct_so_luong),
                ];
            } else {
                // ========================================================
                // THÔNG BÁO SẢN PHẨM KHÔNG TỒN TẠI (BỊ ADMIN XOÁ)
                // ========================================================
                $_SESSION['errors'] = ['Sản phẩm không tồn tại hoặc đã bị xoá bởi quản trị viên.'];
                $_SESSION['flash'] = true;
                header('Location: ' . BASE_URL . '?act=gio-hang&status=product-deleted');
                exit();
            }
        } elseif (isset($_SESSION['user_client'])) {
            // LUỒNG USER LOGIN (DB)
            $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);

            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($user['id']);
                $gioHang = ['id' => $gioHangId];
            }

            $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            
            // ========================================================
            // KIỂM TRA SẢN PHẨM CÓ TỒN TẠI KHÔNG (TRỮ CASE BỊ ADMIN XOÁ)
            // ========================================================
            $sanPhamXoa = [];
            $chiTietGioHangValid = [];
            
            foreach ($chiTietGioHang as $item) {
                $sanPham = $this->modelSanPham->getDetailSanPham($item['san_pham_id']);
                if ($sanPham) {
                    $chiTietGioHangValid[] = $item;
                } else {
                    $sanPhamXoa[] = $item['ten_san_pham'];
                    // Xoá chi tiết sản phẩm khỏi giỏ hàng
                    $this->modelGioHang->deleteItem($user['id'], $item['san_pham_id']);
                }
            }
            
            $chiTietGioHang = $chiTietGioHangValid;
            
            // Nếu có sản phẩm bị xoá, thông báo cho khách hàng
            if (!empty($sanPhamXoa)) {
                $_SESSION['errors'] = ['Sản phẩm ' . implode(', ', $sanPhamXoa) . ' không tồn tại hoặc đã bị xoá bởi quản trị viên.'];
                $_SESSION['flash'] = true;
            }
        } else {
            // LUỒNG KHÁCH (SESSION)
            $chiTietGioHang = getCartFromSession();
            
            // ========================================================
            // KIỂM TRA SẢN PHẨM CÓ TỒN TẠI KHÔNG (SESSION CASE)
            // ========================================================
            $sanPhamXoa = [];
            $chiTietGioHangValid = [];
            
            foreach ($chiTietGioHang as $item) {
                $sanPham = $this->modelSanPham->getDetailSanPham($item['san_pham_id']);
                if ($sanPham) {
                    $chiTietGioHangValid[] = $item;
                } else {
                    $sanPhamXoa[] = $item['ten_san_pham'];
                }
            }
            
            $chiTietGioHang = $chiTietGioHangValid;
            
            // Nếu có sản phẩm bị xoá, thông báo cho khách hàng
            if (!empty($sanPhamXoa)) {
                $_SESSION['errors'] = ['Sản phẩm ' . implode(', ', $sanPhamXoa) . ' không tồn tại hoặc đã bị xoá bởi quản trị viên.'];
                $_SESSION['flash'] = true;
                // Cập nhật session cart
                $_SESSION['cart'] = [];
                foreach ($chiTietGioHang as $item) {
                    $_SESSION['cart'][$item['san_pham_id']] = $item;
                }
            }
        }

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

            $direct_san_pham_id = $_POST['direct_san_pham_id'] ?? $_POST['san_pham_id'] ?? null;
            $direct_so_luong = isset($_POST['direct_so_luong']) ? (int)$_POST['direct_so_luong'] : (int)($_POST['so_luong'] ?? 1);
            $isDirectPurchase = !empty($direct_san_pham_id);

            $ngay_dat = date('Y-m-d H:i:s');
            $trang_thai_id = 1;
            $ma_don_hang = 'DH' . rand(1000, 9999);

            // PHÂN LUỒNG LẤY THÔNG TIN SẢN PHẨM
            if ($direct_san_pham_id) {
                $chiTietGioHang = [];
                $product = getProductById($direct_san_pham_id);
                if ($product) {
                    $chiTietGioHang[] = [
                        'san_pham_id' => $product['id'],
                        'id' => $product['id'],
                        'ten_san_pham' => $product['ten_san_pham'],
                        'gia_san_pham' => $product['gia_san_pham'],
                        'gia_khuyen_mai' => $product['gia_khuyen_mai'],
                        'hinh_anh' => $product['hinh_anh'],
                        'so_luong' => max(1, $direct_so_luong),
                    ];
                }

                if (isset($_SESSION['user_client'])) {
                    $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
                    $tai_khoan_id = $user['id'];
                } else {
                    $tai_khoan_id = null;
                }
            } elseif (isset($_SESSION['user_client'])) {
                // USER LOGIN
                $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
                $tai_khoan_id = $user['id'];

                $gioHang = $this->modelGioHang->getGioHangFromUser($tai_khoan_id);
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            } else {
                // GUEST
                $tai_khoan_id = null;
                $chiTietGioHang = getCartFromSession();
            }

            // ========================================================
            // KIỂM TRA TỒN KHO TRƯỚC KHI TẠO ĐƠN HÀNG
            // ========================================================
            $stockValidation = $this->validateStockForCheckout($chiTietGioHang);

            if (!$stockValidation['status']) {
                // Có lỗi tồn kho - redirect về trang thanh toán với thông báo lỗi
                $_SESSION['errors'] = $stockValidation['errors'];
                $_SESSION['flash'] = true;
                header('Location: ' . BASE_URL . '?act=thanh-toan&status=stock-error');
                exit();
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

                    $san_pham_id = $item['san_pham_id'] ?? $item['id'];
                    $so_luong = $item['so_luong'];

                    $this->modelDonHang->addChiTietDonHang(
                        $donHang,
                        $san_pham_id, // fix cho session
                        $donGia,
                        $so_luong,
                        $donGia * $so_luong
                    );

                    // ========================================================
                    // GIẢM SỐ LƯỢNG SẢN PHẨM TRONG KHO SAU KHI ĐẶT HÀNG THÀNH CÔNG
                    // ========================================================
                    $this->modelSanPham->decreaseStock($san_pham_id, $so_luong);
                }

                // CLEAR CART
                if (!$isDirectPurchase) {
                    if (isset($_SESSION['user_client'])) {
                        // DB
                        $this->modelGioHang->clearDetailGioHang($gioHang['id']);
                        $this->modelGioHang->clearGioHang($tai_khoan_id);
                    } else {
                        // SESSION
                        unset($_SESSION['cart']);
                    }
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
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
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
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
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
