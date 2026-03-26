<?php
class AdminDonHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy toàn bộ danh mục
    public function getAllDonHang()
    {
        try {
            $sql = "SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai
                FROM don_hangs
                INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    //trạng thái đơn hàng
    public function getAllTrangThaiDonHang()
    {
        try {
            $sql = "SELECT * FROM trang_thai_don_hangs";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getDetailDonHang($id)
    {
        try {
            $sql = "SELECT dh.*,
                       ttdh.ten_trang_thai,
                       pttt.ten_phuong_thuc,
                       tk.ho_ten AS ho_ten_nguoi_dat,
                       tk.email AS email_nguoi_dat,
                       tk.so_dien_thoai AS sđt_nguoi_dat
                FROM don_hangs AS dh
                INNER JOIN trang_thai_don_hangs AS ttdh 
                    ON dh.trang_thai_id = ttdh.id
                INNER JOIN phuong_thuc_thanh_toans AS pttt
                    ON dh.phuong_thuc_thanh_toan_id = pttt.id
                LEFT JOIN tai_khoans AS tk
                    ON dh.tai_khoan_id = tk.id
                WHERE dh.id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Lấy danh sách sản phẩm của đơn hàng
    public function getListSpDonHang($id)
    {
        try {
            $sql = 'SELECT chi_tiet_don_hangs.*, san_phams.ten_san_pham
            FROM chi_tiet_don_hangs
            INNER JOIN san_phams ON chi_tiet_don_hangs.san_pham_id = san_phams.id
            WHERE chi_tiet_don_hangs.don_hang_id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll() ?? [];
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    // sửa đơn hàng
    public function updateDonHang(
        $id,
        $ten_nguoi_nhan,
        $sdt_nguoi_nhan,
        $email_nguoi_nhan,
        $dia_chi_nguoi_nhan,
        $ghi_chu,
        $trang_thai_id
    ) {
        try {
            $sql = "UPDATE don_hangs 
                SET 
                    ten_nguoi_nhan = :ten_nguoi_nhan, 
                    sdt_nguoi_nhan = :sdt_nguoi_nhan, 
                    email_nguoi_nhan = :email_nguoi_nhan, 
                    dia_chi_nguoi_nhan = :dia_chi_nguoi_nhan, 
                    ghi_chu = :ghi_chu, 
                    trang_thai_id = :trang_thai_id 
                WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':ten_nguoi_nhan' => $ten_nguoi_nhan,
                ':sdt_nguoi_nhan' => $sdt_nguoi_nhan,
                ':email_nguoi_nhan' => $email_nguoi_nhan,
                ':dia_chi_nguoi_nhan' => $dia_chi_nguoi_nhan,
                ':ghi_chu' => $ghi_chu,
                ':trang_thai_id' => $trang_thai_id,
                ':id' => $id,
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getDonHangFromKhachHang($id)
    {
        try {
            $sql = "SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai
                FROM don_hangs
                INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
                WHERE don_hangs.tai_khoan_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}
