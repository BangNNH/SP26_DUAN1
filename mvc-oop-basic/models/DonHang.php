<?php


class DonHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function addDonHang(
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
    ) {

        try {
            $sql = "INSERT INTO don_hangs (tai_khoan_id,ten_nguoi_nhan,email_nguoi_nhan,sdt_nguoi_nhan,dia_chi_nguoi_nhan,ghi_chu,tong_tien,phuong_thuc_thanh_toan_id,ngay_dat,trang_thai_id, ma_don_hang) 
                    VALUES (:tai_khoan_id, :ten_nguoi_nhan, :email_nguoi_nhan, :sdt_nguoi_nhan, :dia_chi_nguoi_nhan, :ghi_chu, :tong_tien, :phuong_thuc_thanh_toan_id, :ngay_dat, :trang_thai_id, :ma_don_hang)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                "tai_khoan_id" => $tai_khoan_id,
                "ten_nguoi_nhan" => $ten_nguoi_nhan,
                "email_nguoi_nhan" => $email_nguoi_nhan,
                "sdt_nguoi_nhan" => $sdt_nguoi_nhan,
                "dia_chi_nguoi_nhan" => $dia_chi_nguoi_nhan,
                "ghi_chu" => $ghi_chu,
                "tong_tien" => $tong_tien,
                "phuong_thuc_thanh_toan_id" => $phuong_thuc_thanh_toan_id,
                "ngay_dat" => $ngay_dat,
                "trang_thai_id" => $trang_thai_id,
                "ma_don_hang" => $ma_don_hang,
            ]);

            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function addChiTietDonHang($donHangId, $sanPhamId, $donGia, $soLuong, $thanhTien, $tenSanPham = null)
    {
        try {
            // Nếu chưa có cột ten_san_pham, bạn cần chạy alter table trên DB:
            // ALTER TABLE chi_tiet_don_hangs ADD COLUMN ten_san_pham VARCHAR(255) NULL;

            if ($tenSanPham === null) {
                $sqlProduct = "SELECT ten_san_pham FROM san_phams WHERE id = :id LIMIT 1";
                $stmtProduct = $this->conn->prepare($sqlProduct);
                $stmtProduct->execute([':id' => $sanPhamId]);
                $product = $stmtProduct->fetch(PDO::FETCH_ASSOC);
                if ($product && !empty($product['ten_san_pham'])) {
                    $tenSanPham = $product['ten_san_pham'];
                } else {
                    $tenSanPham = ''; // Hoặc có thể đặt giá trị mặc định khác
                }
            }

            $sql = "INSERT INTO chi_tiet_don_hangs(don_hang_id, san_pham_id, don_gia, so_luong, thanh_tien, ten_san_pham)
            VALUES (:don_hang_id, :san_pham_id, :don_gia, :so_luong, :thanh_tien, :ten_san_pham)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':don_hang_id' => $donHangId,
                ':san_pham_id' => $sanPhamId,
                ':don_gia' => $donGia,
                ':so_luong' => $soLuong,
                ':thanh_tien' => $thanhTien,
                ':ten_san_pham' => $tenSanPham,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getDonHangFromUser($taiKhoanId)
    {
        try {
            $sql = "SELECT * FROM don_hangs WHERE tai_khoan_id = :tai_khoan_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':tai_khoan_id' => $taiKhoanId,
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getTrangThaiDonHang()
    {
        try {
            $sql = "SELECT * FROM trang_thai_don_hangs";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getPhuongThucThanhToan()
    {
        try {
            $sql = "SELECT * FROM phuong_thuc_thanh_toans";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getDonHangById($donHangId)
    {
        try {
            $sql = "SELECT * FROM don_hangs WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $donHangId]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getChiTietDonHangByDonHangId($donHangId)
    {
        try {
            $sql = "SELECT 
                    chi_tiet_don_hangs.*,
                COALESCE(chi_tiet_don_hangs.ten_san_pham, san_phams.ten_san_pham, '') AS ten_san_pham,
                    COALESCE(san_phams.hinh_anh, '') AS hinh_anh
            FROM chi_tiet_don_hangs 
            LEFT JOIN san_phams ON chi_tiet_don_hangs.san_pham_id = san_phams.id 
            WHERE chi_tiet_don_hangs.don_hang_id = :don_hang_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':don_hang_id' => $donHangId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function updateTrangThaiDonHang($donHangId, $trangThaiId)
    {
        try {
            $sql = "UPDATE don_hangs SET trang_thai_id = :trang_thai_id WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':trang_thai_id' => $trangThaiId,
                ':id' => $donHangId
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}
