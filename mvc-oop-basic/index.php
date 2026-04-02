<?php
// session_start();

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';
require_once './controllers/CartController.php';
require_once './controllers/OrderController.php';
require_once './controllers/ProductController.php';
require_once './controllers/PaymentController.php';

// Require toàn bộ file Models
require_once './models/SanPham.php';
require_once './models/TaiKhoan.php';
require_once './models/GioHang.php';
require_once './models/DonHang.php';
require_once './models/BinhLuan.php';
require_once './models/PaymentModel.php';

// Route
$act = $_GET['act'] ?? '/';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match
match ($act) {
    '/' => (new HomeController)->home(),
    'chi-tiet-san-pham' => (new HomeController())->chiTietSanPham(),
    'comment-submit' => (new HomeController())->postComment(),
    'them-gio-hang' => (new CartController())->addGioHang(),
    'gio-hang' => (new CartController())->gioHang(),
    'cap-nhat-gio-hang' => (new CartController())->updateCartItem(),
    'xoa-item-gio-hang' => (new CartController())->deleteCartItem(),
    'thanh-toan' => (new OrderController())->thanhToan(),
    'xu-ly-thanh-toan' => (new OrderController())->postThanhToan(),
    'lich-su-mua-hang' => (new OrderController())->lichSuMuaHang(),
    'chi-tiet-mua-hang' => (new OrderController())->chiTietMuaHang(),
    'huy-don-hang' => (new OrderController())->huyDonHang(),
    'san-pham' => (new ProductController())->index(),
    'ajax-cart-session' => (new CartController())->ajaxCartSession(),
    // 'ajax-full-cart-session' => (new CartController())->ajaxGetFullCartSession(),

    // Auth
    'login' => (new HomeController())->formLogin(),
    'check-login' => (new HomeController())->postLogin(),
    'logout' => (new HomeController())->logout(),
    'signup' => (new HomeController())->registerLogin(),
    'check-register' => (new HomeController())->postRegister(),
    'tai-khoan' => (new HomeController())->account(), // Đảm bảo dòng này tồn tại
    'update-profile' => (new HomeController())->updateProfile(),
    'forgot-password' => (new HomeController())->forgotPassword(),
    'send-otp-forgot-password' => (new HomeController())->sendOtpForgotPassword(),
    'reset-password' => (new HomeController())->resetPassword(),

    // Payment
    'momo-payment' => (new PaymentController())->momo_payment(),
    'payment-callback' => (new PaymentController())->callback(),
};
