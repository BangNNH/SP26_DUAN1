<?php


class TaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function checkLogin($email, $mat_khau)
    {
        try {
            $sql = "SELECT * FROM tai_khoans WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if (!$user) {
                return "Email không tồn tại";
            }

            // Nếu mật khẩu đã được hash, dùng password_verify
            if (password_verify($mat_khau, $user['mat_khau'])) {
                // Chỉ cho phép tài khoản quản trị (chuc_vu_id=2) và không bị khóa (trang_thai=1)
                if ($user['chuc_vu_id'] != 2) {
                    return "Tài khoản không có quyền đăng nhập";
                }
                if ($user['trang_thai'] != 1) {
                    return "Tài khoản bị cấm";
                }
                return $user['email'];
            }

            // Nếu mật khẩu chưa được hash (lưu plain text), thì cho phép đăng nhập và chuyển sang hash
            if ($user['mat_khau'] === $mat_khau) {
                // Cập nhật mật khẩu mới đã hash
                $newHash = password_hash($mat_khau, PASSWORD_BCRYPT);
                $update = $this->conn->prepare("UPDATE tai_khoans SET mat_khau = :mat_khau WHERE id = :id");
                $update->execute([':mat_khau' => $newHash, ':id' => $user['id']]);

                if ($user['chuc_vu_id'] != 2) {
                    return "Tài khoản không có quyền đăng nhập";
                }
                if ($user['trang_thai'] != 1) {
                    return "Tài khoản bị cấm";
                }
                return $user['email'];
            }

            return "Bạn nhập sai thông tin mật khẩu hoặc tài khoản";
        } catch (\Exception $e) {
            echo "lỗi" . $e->getMessage();
            return false;
        }
    }

    public function getTaiKhoanFromEmail($email)
    {
        try {
            $sql = "SELECT * FROM tai_khoans where email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}
