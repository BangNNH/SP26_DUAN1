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
            $sql = "INSERT INTO tai_khoans(ho_ten, email, password, chuc_vu_id) 
                        VALUES (:ho_ten, :email, :password, :chuc_vu_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':password' => $password,
                ':chuc_vu_id' => $chuc_vu_id
            ]);
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
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
                    mat_khau = :mat_khau,
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
}
