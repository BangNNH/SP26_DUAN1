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
                return "Tài khoản hoặc mật khẩu không hợp lệ";
            }

            $isValidPassword = false;

            // Nếu mật khẩu đã được hash, dùng password_verify
            if (password_verify($mat_khau, $user['mat_khau'])) {
                $isValidPassword = true;
            } elseif ($user['mat_khau'] === $mat_khau) {
                // Nếu mật khẩu chưa được hash (lưu plain text), thì cho phép đăng nhập và chuyển sang hash
                // Cập nhật mật khẩu mới đã hash
                $newHash = password_hash($mat_khau, PASSWORD_BCRYPT);
                $update = $this->conn->prepare("UPDATE tai_khoans SET mat_khau = :mat_khau WHERE id = :id");
                $update->execute([':mat_khau' => $newHash, ':id' => $user['id']]);
                $isValidPassword = true;
            }

            if ($isValidPassword) {
                // Kiểm tra phân quyền tài khoản (chuc_vu_id=2) và không bị khóa (trang_thai=1)
                if ($user['chuc_vu_id'] != 2) {
                    return "Tài khoản không có quyền đăng nhập";
                }
                if ($user['trang_thai'] != 1) {
                    return "Tài khoản bị cấm";
                }
                return [
                    'id' => $user['id'],
                    'email' => $user['email']
                ];
            }

            return "Bạn nhập sai thông tin mật khẩu hoặc tài khoản";
        } catch (Exception $e) {
            error_log("Lỗi checkLogin: " . $e->getMessage());
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
            error_log("Lỗi getTaiKhoanFromEmail: " . $e->getMessage());
            return false;
        }
    }

    public function checkEmailExists($email)
    {
        try {
            $sql = "SELECT COUNT(*) FROM tai_khoans WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            return $stmt->fetchColumn() > 0;
        } catch (Exception $e) {
            error_log("Lỗi checkEmailExists: " . $e->getMessage());
            return false;
        }
    }

    public function register($email, $hashedPassword)
    {
        try {
            $sql = "INSERT INTO tai_khoans (ho_ten, anh_dai_dien, ngay_sinh, email, so_dien_thoai, gioi_tinh, dia_chi, mat_khau, chuc_vu_id, trang_thai) 
                    VALUES (:ho_ten, :anh_dai_dien, :ngay_sinh, :email, :so_dien_thoai, :gioi_tinh, :dia_chi, :mat_khau, 2, 1)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'ho_ten' => $email, // Lấy tạm email làm họ tên mặc định ban đầu
                'anh_dai_dien' => '',
                'ngay_sinh' => '2000-01-01', // Ngày sinh mặc định
                'email' => $email,
                'so_dien_thoai' => '',
                'gioi_tinh' => 1,
                'dia_chi' => '',
                'mat_khau' => $hashedPassword
            ]);
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            error_log("Lỗi register: " . $e->getMessage());
            return false;
        }
    }
    public function getUserById($id)
    {
        try {
            $sql = "SELECT * FROM tai_khoans WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Lỗi getUserById: " . $e->getMessage());
            return false;
        }
    }
    public function updateProfile($id, $name, $phone, $address, $avatar, $newPassword = null)
    {
        try {
            $sql = "UPDATE tai_khoans SET ho_ten = :ho_ten, so_dien_thoai = :so_dien_thoai, 
                dia_chi = :dia_chi, anh_dai_dien = :anh_dai_dien";

            $params = [
                'ho_ten' => $name,
                'so_dien_thoai' => $phone,
                'dia_chi' => $address,
                'anh_dai_dien' => $avatar,
                'id' => $id
            ];

            if ($newPassword) {
                $sql .= ", mat_khau = :mat_khau";
                $params['mat_khau'] = $newPassword;
            }

            $sql .= " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (Exception $e) { /* ... */
        }
    }
    public function updatePassword($id, $newHashedPassword)
    {
        try {
            $sql = "UPDATE tai_khoans SET mat_khau = :mat_khau WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['mat_khau' => $newHashedPassword, 'id' => $id]);
        } catch (Exception $e) {
            error_log("Lỗi updatePassword: " . $e->getMessage());
            return false;
        }
    }

    public function updatePasswordByEmail($email, $newHashedPassword)
    {
        try {
            $sql = "UPDATE tai_khoans SET mat_khau = :mat_khau WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['mat_khau' => $newHashedPassword, 'email' => $email]);
        } catch (Exception $e) {
            error_log("Lỗi updatePasswordByEmail: " . $e->getMessage());
            return false;
        }
    }

    public function updatePasswordByPhone($phone, $newHashedPassword)
    {
        try {
            $sql = "UPDATE tai_khoans SET mat_khau = :mat_khau WHERE so_dien_thoai = :so_dien_thoai";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['mat_khau' => $newHashedPassword, 'so_dien_thoai' => $phone]);
        } catch (Exception $e) {
            error_log("Lỗi updatePasswordByPhone: " . $e->getMessage());
            return false;
        }
    }

    public function getTaiKhoanFromPhone($phone)
    {
        try {
            $sql = "SELECT * FROM tai_khoans WHERE so_dien_thoai = :so_dien_thoai";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['so_dien_thoai' => $phone]);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Lỗi getTaiKhoanFromPhone: " . $e->getMessage());
            return false;
        }
    }
    
    public  function getAllUsers()
    {
        try {
            $sql = "SELECT * FROM tai_khoans";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Lỗi getAllUsers: " . $e->getMessage());
            return false;
        }
    }   
}
