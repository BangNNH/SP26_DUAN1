<?php

class AdminTaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy toàn bộ danh mục
    public function getAllTaiKhoan($chuc_vu_id)
    {
        try {
            $sql = "SELECT * FROM tai_khoans WHERE chuc_vu_id = :chuc_vu_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['chuc_vu_id' => $chuc_vu_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }


    public function insertDanhMuc($ten_danh_muc, $mo_ta)
    {
        try {
            $sql = "INSERT INTO danh_mucs(ten_danh_muc,mo_ta) 
                        VALUES (:ten_danh_muc, :mo_ta)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ten_danh_muc' => $ten_danh_muc,
                ':mo_ta' => $mo_ta
            ]);
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id)
    {
        try {
            $sql = "INSERT INTO tai_khoans(ho_ten, anh_dai_dien, ngay_sinh, email, so_dien_thoai, gioi_tinh, dia_chi, mat_khau, chuc_vu_id, trang_thai)
                        VALUES (:ho_ten, :anh_dai_dien, :ngay_sinh, :email, :so_dien_thoai, :gioi_tinh, :dia_chi, :mat_khau, :chuc_vu_id, :trang_thai)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':anh_dai_dien' => '',
                ':ngay_sinh' => '2000-01-01',
                ':email' => $email,
                ':so_dien_thoai' => '',
                ':gioi_tinh' => 1,
                ':dia_chi' => '',
                ':mat_khau' => $password,
                ':chuc_vu_id' => $chuc_vu_id,
                ':trang_thai' => 1
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function getDetailTaiKhoan($id)
    {
        try {
            $sql = "SELECT * FROM tai_khoans where id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function updateTaiKhoan($id, $ho_ten, $email, $so_dien_thoai, $trang_thai)
    {
        try {
            // var_dump($id);die;
            $sql = 'UPDATE tai_khoans
                SET
                    ho_ten = :ho_ten,
                    email = :email,
                    so_dien_thoai = :so_dien_thoai,
                    trang_thai = :trang_thai
                WHERE id = :id';

            $stmt = $this->conn->prepare($sql);

            // var_dump($stmt);die;

            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':so_dien_thoai' => $so_dien_thoai,
                ':trang_thai' => $trang_thai,
                ':id' => $id
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi " . $e->getMessage();
        }
    }

    public function resetPassword($id, $mat_khau)
    {
        try {
            // var_dump($id);die;

            $sql = 'UPDATE tai_khoans
                SET
                    mat_khau = :mat_khau
                WHERE id = :id';

            $stmt = $this->conn->prepare($sql);

            // var_dump($stmt);die;

            $stmt->execute([
                ':mat_khau' => $mat_khau,
                ':id' => $id
            ]);

            return true;
        } catch (Exception $e) {
            echo "lỗi " . $e->getMessage();
        }
    }

    public function updateKhachHang($id, $ho_ten, $email, $so_dien_thoai,$ngay_sinh, $gioi_tinh, $dia_chi, $trang_thai)
    {
        try {
            // var_dump($id);die;
            $sql = 'UPDATE tai_khoans
                SET
                    ho_ten = :ho_ten,
                    email = :email,
                    so_dien_thoai = :so_dien_thoai,
                    ngay_sinh = :ngay_sinh,
                    gioi_tinh = :gioi_tinh,
                    dia_chi = :dia_chi,
                    trang_thai = :trang_thai
                WHERE id = :id';

            $stmt = $this->conn->prepare($sql);

            // var_dump($stmt);die;

            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':so_dien_thoai' => $so_dien_thoai,
                ':ngay_sinh' => $ngay_sinh,
                ':gioi_tinh' => $gioi_tinh,
                ':dia_chi' => $dia_chi,
                ':trang_thai' => $trang_thai,
                ':id' => $id
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi " . $e->getMessage();
        }
    }

    public function checkLogin($email, $mat_khau){
        try {
            $sql = "SELECT * FROM tai_khoans WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt-> execute(['email'=>$email]);
            $user = $stmt->fetch();

            if (!$user) {
                return "Email không tồn tại";
            }

            // Nếu mật khẩu đã được hash, dùng password_verify
            if (password_verify($mat_khau, $user['mat_khau'])) {
                // Chỉ cho phép tài khoản quản trị (chuc_vu_id=1) và không bị khóa (trang_thai=1)
                if ($user['chuc_vu_id'] != 1) {
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

                if ($user['chuc_vu_id'] != 1) {
                    return "Tài khoản không có quyền đăng nhập";
                }
                if ($user['trang_thai'] != 1) {
                    return "Tài khoản bị cấm";
                }
                return $user['email'];
            }

            return "Bạn nhập sai thông tin mật khẩu hoặc tài khoản";
        } catch (\Exception $e){
           echo "lỗi" . $e->getMessage();
            return false;
        }
    }
    public function getTaiKhoanformEmail($email)
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
