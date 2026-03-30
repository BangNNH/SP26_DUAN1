<?php

class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoan;
    public $modelBinhLuan;


    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelBinhLuan = new BinhLuan();
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
        $listAutomatic =  $this->modelSanPham->getSanPhamByCategory(1);
        $listQuartz =  $this->modelSanPham->getSanPhamByCategory(2);
        $listEco =  $this->modelSanPham->getSanPhamByCategory(3);
        $listSport =  $this->modelSanPham->getSanPhamByCategory(4);
        $listSmart =  $this->modelSanPham->getSanPhamByCategory(5);
        require_once './views/home.php';
    }


    public function chiTietSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listBinhLuan = $this->modelBinhLuan->getBinhLuanFromSanPham($id);
        $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id'], $id);
        if ($sanPham) {
            require_once './views/detailSanPham.php';
        } else {
            header("Location: " . BASE_URL);
            exit();
        }
    }

    public function postComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $san_pham_id = $_POST['san_pham_id'];
            $tai_khoan_id = $_SESSION['user_client']['id'];
            $noi_dung = $_POST['noi_dung'];
            $ngay_dang = date('Y-m-d H:i:s');
            $trang_thai = 1;

            // debug($tai_khoan_id);
            if ($noi_dung === '') {
                $_SESSION['error_comment'] = "Nội dung bình luận không được để trống";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }

            $this->modelBinhLuan->insertComment(
                $san_pham_id,
                $tai_khoan_id,
                $noi_dung,
                $ngay_dang,
                $trang_thai
            );
            $_SESSION['comment_success'] = "Gửi bình luận sản phẩm thành công";
            header("Location: ?act=chi-tiet-san-pham&id_san_pham=" . $san_pham_id);
            exit;
        }
    }

    public function formLogin()
    {
        if (isset($_SESSION['error']) && $_SESSION['error'] === 'Yêu cầu không hợp lệ') {
            unset($_SESSION['error']);
        }
        require_once __DIR__ . '/../views/auth/formLogin.php';
        deleteSessionError();
    }

    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // lấy email và pass gửi lên từ form
            $email = $_POST['email'] ?? '';
            $password = trim($_POST['password'] ?? '');

            // Xử lí kiểm tra thông tin đăng nhập
            $user = $this->modelTaiKhoan->checkLogin($email, $password);
            // Nếu trả về email (dạng string hợp lệ) là đăng nhập thành công
            if (is_array($user)) {
                // Lưu email vào session để dùng hiển thị
                $_SESSION['user_client'] = [
                    'id' => $user['id'],
                    'email' => $user['email']
                ];
                $_SESSION['login_success'] = "Đăng nhập thành công";
                header("Location: " . BASE_URL);
                exit();
            } else {
                // Lỗi thì lưu lỗi vào session và xoá session user nếu có
                unset($_SESSION['user_client']);
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

    public function registerLogin()
    {
        require_once __DIR__ . '/../views/auth/registerLogin.php';
        deleteSessionError();
    }

    public function postRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL);
            exit();
        }
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $password_confirmation = trim($_POST['password_confirmation'] ?? '');

        $_SESSION['old_email'] = $email;

        $errors = [];

        // Validation
        if (empty($email)) {
            $errors['email'] = "Email không được để trống";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ";
        } elseif ($this->modelTaiKhoan->checkEmailExists($email)) {
            $errors['email'] = "Email đã tồn tại";
        }

        if (strlen($password) < 6) {
            $errors['password'] = "Mật khẩu phải >= 6 ký tự";
        }

        if ($password !== $password_confirmation) {
            $errors['password_confirmation'] = "Mật khẩu nhập lại không khớp";
        }

        if (!empty($errors)) {
            foreach ($errors as $field => $message) {
                $_SESSION['error_' . $field] = $message;
            }
            header("Location: " . BASE_URL . '?act=signup');
            exit();
        }

        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userId = $this->modelTaiKhoan->register($email, $hashedPassword);

            if (!$userId) {
                throw new Exception("Không thể lưu tài khoản");
            }

            unset($_SESSION['old_email'], $_SESSION['csrf_token']);
            $_SESSION['success'] = "Bạn đã đăng ký thành công, vui lòng đăng nhập";

            header("Location: " . BASE_URL . '?act=login');
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi hệ thống, vui lòng thử lại";
            header("Location: " . BASE_URL . '?act=signup');
            exit();
        }
    }
    public function account()
    {
        if (!isset($_SESSION['user_client'])) {
            header("Location: " . BASE_URL . '?act=login');
            exit();
        }

        $userId = $_SESSION['user_client']['id'];
        $user = $this->modelTaiKhoan->getUserById($userId);

        if (!$user) {
            // Nếu không tìm thấy người dùng, xóa session và chuyển hướng về trang đăng nhập
            unset($_SESSION['user_client']);
            $_SESSION['error'] = "Tài khoản không tồn tại hoặc đã bị xóa.";
            header("Location: " . BASE_URL . '?act=login');
            exit();
        }
        require_once __DIR__ . '/../views/auth/acount.php';
    }
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_client'])) {
            header("Location: " . BASE_URL);
            exit();
        }

        $userId = $_SESSION['user_client']['id'];
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $oldPassword = trim($_POST['old_password'] ?? '');
        $newPassword = trim($_POST['new_password'] ?? '');

        $errors = [];
        $passwordToUpdate = null; // Biến này sẽ chứa mật khẩu mới đã được băm nếu có thay đổi

        // Lấy thông tin người dùng hiện tại để xác minh mật khẩu cũ (nếu người dùng muốn đổi mật khẩu)
        $currentUser = $this->modelTaiKhoan->getUserById($userId);
        if (!$currentUser) {
            $_SESSION['error'] = "Không tìm thấy thông tin người dùng.";
            header("Location: " . BASE_URL . '?act=tai-khoan');
            exit();
        }

        // Xử lý thay đổi mật khẩu
        if (!empty($oldPassword) || !empty($newPassword)) {
            // Xác thực mật khẩu hiện tại
            if (empty($oldPassword)) {
                $errors['old_password'] = "Vui lòng nhập mật khẩu hiện tại.";
            } elseif (!password_verify($oldPassword, $currentUser['mat_khau'])) {
                $errors['old_password'] = "Mật khẩu hiện tại không đúng.";
            }

            // Xác thực mật khẩu mới
            if (empty($newPassword)) {
                $errors['new_password'] = "Vui lòng nhập mật khẩu mới.";
            } elseif (strlen($newPassword) < 6) {
                $errors['new_password'] = "Mật khẩu mới phải có ít nhất 6 ký tự.";
            }

            // Nếu không có lỗi liên quan đến mật khẩu, băm mật khẩu mới
            if (empty($errors)) {
                $passwordToUpdate = password_hash($newPassword, PASSWORD_BCRYPT);
            }
        }

        // Nếu có bất kỳ lỗi nào, lưu vào session và chuyển hướng
        if (!empty($errors)) {
            $_SESSION['error'] = implode("<br>", $errors); // Gộp các lỗi để hiển thị
            header("Location: " . BASE_URL . '?act=tai-khoan');
            exit();
        }

        try {
            // Xử lý upload ảnh đại diện
            $avatarPath = $currentUser['anh_dai_dien'] ?? '';
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = './uploads/avatars/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $uploaded = uploadFile($_FILES['avatar'], $uploadDir);
                if ($uploaded) {
                    // Xóa ảnh cũ nếu khác rỗng
                    if (!empty($currentUser['anh_dai_dien']) && file_exists(PATH_ROOT . $currentUser['anh_dai_dien'])) {
                        deleteFile($currentUser['anh_dai_dien']);
                    }
                    $avatarPath = $uploaded;
                } else {
                    $_SESSION['error'] = "Không thể upload ảnh đại diện.";
                    header("Location: " . BASE_URL . '?act=tai-khoan');
                    exit();
                }
            }

            $result = $this->modelTaiKhoan->updateProfile($userId, $name, $phone, $address, $avatarPath, $passwordToUpdate);

            if ($result === true) {
                $_SESSION['success'] = "Cập nhật thông tin thành công";
            } else {
                $_SESSION['error'] = "Lỗi cập nhật thông tin.";
            }
        } catch (Exception $e) {
            error_log("Lỗi cập nhật thông tin: " . $e->getMessage());
            $_SESSION['error'] = "Lỗi cập nhật thông tin: " . $e->getMessage(); // Hiển thị lỗi cụ thể hơn để debug
        }

        header("Location: " . BASE_URL . '?act=tai-khoan');
        exit();
    }
    public function forgotPassword()
    {
        require_once __DIR__ . '/../views/auth/forgotPassword.php';
        deleteSessionError();
    }

    public function sendOtpForgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL);
            exit();
        }

        $contact_info = trim($_POST['contact_info'] ?? '');
        $_SESSION['old_contact'] = $contact_info;

        $errors = [];

        // Validation
        if (empty($contact_info)) {
            $errors['contact_info'] = "Email hoặc số điện thoại không được để trống";
        } elseif (filter_var($contact_info, FILTER_VALIDATE_EMAIL)) {
            // Nếu là email
            if (!$this->modelTaiKhoan->checkEmailExists($contact_info)) {
                $errors['contact_info'] = "Email không tồn tại trong hệ thống";
            }
        } else {
            // Nếu là số điện thoại
            $user = $this->modelTaiKhoan->getTaiKhoanFromPhone($contact_info);
            if (!$user) {
                $errors['contact_info'] = "Số điện thoại không tồn tại trong hệ thống";
            }
        }

        if (!empty($errors)) {
            foreach ($errors as $field => $message) {
                $_SESSION['error_' . $field] = $message;
            }
            header("Location: " . BASE_URL . '?act=forgot-password');
            exit();
        }

        try {
            // Tạo OTP 6 ký tự
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Lưu OTP vào session với thời gian hết hạn (5 phút)
            $_SESSION['otp_code'] = $otp;
            $_SESSION['otp_contact'] = $contact_info;
            $_SESSION['otp_time'] = time() + 300; // 5 phút

            // Trong thực tế, bạn sẽ gửi OTP qua email/SMS ở đây
            // Tạm thời lưu OTP để test
            // TODO: Gửi OTP qua email hoặc SMS
            // sendEmailOTP($contact_info, $otp); hoặc sendSMS($contact_info, $otp);

            $_SESSION['success'] = "Mã xác thực đã được gửi. OTP (test): " . $otp;
            header("Location: " . BASE_URL . '?act=reset-password');
            exit();
        } catch (Exception $e) {
            error_log("Lỗi gửi OTP: " . $e->getMessage());
            $_SESSION['error'] = "Lỗi hệ thống, vui lòng thử lại";
            header("Location: " . BASE_URL . '?act=forgot-password');
            exit();
        }
    }

    public function resetPassword()
    {
        // Kiểm tra xem OTP đã được tạo chưa
        if (!isset($_SESSION['otp_code'])) {
            header("Location: " . BASE_URL . '?act=forgot-password');
            exit();
        }

        require_once __DIR__ . '/../views/auth/resetPassword.php';
        deleteSessionError();
    }

    public function verifyAndResetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL);
            exit();
        }

        // Kiểm tra OTP có tồn tại trong session không
        if (!isset($_SESSION['otp_code']) || !isset($_SESSION['otp_contact'])) {
            $_SESSION['error'] = "Phiên làm việc đã hết hạn. Vui lòng thử lại từ đầu.";
            header("Location: " . BASE_URL . '?act=forgot-password');
            exit();
        }

        // Kiểm tra OTP có hết hạn không
        if (time() > $_SESSION['otp_time']) {
            unset($_SESSION['otp_code'], $_SESSION['otp_contact'], $_SESSION['otp_time']);
            $_SESSION['error'] = "Mã xác thực đã hết hạn. Vui lòng thử lại.";
            header("Location: " . BASE_URL . '?act=forgot-password');
            exit();
        }

        $otp_input = trim($_POST['otp_code'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $password_confirmation = trim($_POST['password_confirmation'] ?? '');

        $errors = [];

        // Validation
        if (empty($otp_input)) {
            $errors['otp_code'] = "Mã xác thực không được để trống";
        } elseif ($otp_input !== $_SESSION['otp_code']) {
            $errors['otp_code'] = "Mã xác thực không chính xác";
        }

        if (empty($password)) {
            $errors['password'] = "Mật khẩu mới không được để trống";
        } elseif (strlen($password) < 6) {
            $errors['password'] = "Mật khẩu phải >= 6 ký tự";
        }

        if ($password !== $password_confirmation) {
            $errors['password_confirmation'] = "Mật khẩu nhập lại không khớp";
        }

        if (!empty($errors)) {
            foreach ($errors as $field => $message) {
                $_SESSION['error_' . $field] = $message;
            }
            header("Location: " . BASE_URL . '?act=reset-password');
            exit();
        }

        try {
            $contact_info = $_SESSION['otp_contact'];
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Cập nhật mật khẩu theo email hoặc số điện thoại
            $result = false;
            if (filter_var($contact_info, FILTER_VALIDATE_EMAIL)) {
                $result = $this->modelTaiKhoan->updatePasswordByEmail($contact_info, $hashedPassword);
            } else {
                $result = $this->modelTaiKhoan->updatePasswordByPhone($contact_info, $hashedPassword);
            }

            if ($result) {
                // Xóa OTP từ session
                unset($_SESSION['otp_code'], $_SESSION['otp_contact'], $_SESSION['otp_time'], $_SESSION['old_contact']);
                $_SESSION['success'] = "Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.";
                header("Location: " . BASE_URL . '?act=login');
                exit();
            } else {
                throw new Exception("Không thể cập nhật mật khẩu");
            }
        } catch (Exception $e) {
            error_log("Lỗi verifyAndResetPassword: " . $e->getMessage());
            $_SESSION['error'] = "Lỗi hệ thống, vui lòng thử lại";
            header("Location: " . BASE_URL . '?act=reset-password');
            exit();
        }
    }
}
