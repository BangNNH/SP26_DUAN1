<?php
class AdminBaoCaoThongKe
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }
    // thống kê theo ngày
    public function getDoanhThuHomNayVaHomQua()
    {
        $sql = "
        SELECT 
            DATE(ngay_dat) as ngay,
            SUM(CASE WHEN trang_thai_id = 9 THEN tong_tien ELSE 0 END) as doanh_thu
        FROM don_hangs
        WHERE DATE(ngay_dat) IN (CURDATE(), CURDATE() - INTERVAL 1 DAY)
        GROUP BY DATE(ngay_dat);
    ";

        return $this->conn->query($sql)->fetchAll();
    }

    public function getDoanhThu2Tuan()
    {
        $sql = "
        SELECT 
            YEARWEEK(ngay_dat, 1) as tuan,
            SUM(CASE WHEN trang_thai_id = 9 THEN tong_tien ELSE 0 END) as doanh_thu
        FROM don_hangs
        WHERE YEARWEEK(ngay_dat, 1) IN (
            YEARWEEK(CURDATE(), 1),
            YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)
        )
        GROUP BY tuan
        ORDER BY tuan ASC
    ";

        return $this->conn->query($sql)->fetchAll();
    }

    public function getDonMoiHomNayVaHomQua()
    {
        $sql = "
        SELECT 
            DATE(ngay_dat) as ngay,
            COUNT(*) as tong_don_moi
        FROM don_hangs
        WHERE trang_thai_id = 1
        AND DATE(ngay_dat) IN (CURDATE(), CURDATE() - INTERVAL 1 DAY)
        GROUP BY DATE(ngay_dat)
    ";

        return $this->conn->query($sql)->fetchAll();
    }
    public function getTheoNgay()
    {
        $sql = "SELECT 
            DAY(ngay_dat) as label,
            SUM(CASE WHEN trang_thai_id = 9 THEN tong_tien ELSE 0 END) as value
        FROM don_hangs
        WHERE MONTH(ngay_dat) = MONTH(CURDATE())
        AND YEAR(ngay_dat) = YEAR(CURDATE())
        GROUP BY DAY(ngay_dat)
        ORDER BY label ASC;";
        return $this->conn->query($sql)->fetchAll();
    }

    public function getTheoTuan()
    {
        $sql = "SELECT 
            WEEKDAY(ngay_dat) as label, -- 0 = T2
            SUM(CASE WHEN trang_thai_id = 9 THEN tong_tien ELSE 0 END) as value
        FROM don_hangs
        WHERE YEARWEEK(ngay_dat, 1) = YEARWEEK(CURDATE(), 1)
        GROUP BY WEEKDAY(ngay_dat)
        ORDER BY label ASC;";
        return $this->conn->query($sql)->fetchAll();
    }

    public function getTheoThang()
    {
        $sql = "SELECT 
            MONTH(ngay_dat) as label,
            SUM(CASE WHEN trang_thai_id = 9 THEN tong_tien ELSE 0 END) as value
        FROM don_hangs
        WHERE YEAR(ngay_dat) = YEAR(CURDATE())
        GROUP BY MONTH(ngay_dat)
        ORDER BY label ASC;";
        return $this->conn->query($sql)->fetchAll();
    }
    public function getTyLeDonHang()
    {
        $sql = "
        SELECT 
            COUNT(*) as tong_don,
            SUM(CASE WHEN trang_thai_id = 9 THEN 1 ELSE 0 END) as fulfilled,
            SUM(CASE WHEN trang_thai_id = 1 THEN 1 ELSE 0 END) as processing,
            SUM(CASE WHEN trang_thai_id IN (10, 11) THEN 1 ELSE 0 END) as canceled
        FROM don_hangs
    ";

        return $this->conn->query($sql)->fetch();
    }
    public function getTopSanPham()
    {
        $sql = "
        SELECT 
            sp.id,
            sp.ten_san_pham,
            dm.ten_danh_muc,
            SUM(ct.so_luong) as total_quantity,
            SUM(ct.thanh_tien) as total_revenue
        FROM chi_tiet_don_hangs ct
        JOIN san_phams sp ON ct.san_pham_id = sp.id
        JOIN danh_mucs dm ON sp.danh_muc_id = dm.id
        JOIN don_hangs dh ON ct.don_hang_id = dh.id
        WHERE dh.trang_thai_id = 9
        GROUP BY sp.id, sp.ten_san_pham, dm.ten_danh_muc
        ORDER BY total_quantity DESC
        LIMIT 3
    ";

        return $this->conn->query($sql)->fetchAll();
    }

    // dữ liệu biểu đồ doanh thu theo thời gian
    public function getDoanhThuTuan()
    {
        $sql = "
        SELECT 
            DATE(ngay_dat) as ngay,
            SUM(CASE WHEN trang_thai_id = 9 THEN tong_tien ELSE 0 END) as doanh_thu
        FROM don_hangs
        WHERE ngay_dat >= CURDATE() - INTERVAL 6 DAY
        GROUP BY DATE(ngay_dat)
        ORDER BY ngay ASC
    ";

        return $this->conn->query($sql)->fetchAll();
    }
    public function getDoanhThu12Thang()
    {
        $sql = "
        SELECT 
            MONTH(ngay_dat) as thang,
            SUM(CASE WHEN trang_thai_id = 9 THEN tong_tien ELSE 0 END) as doanh_thu
        FROM don_hangs
        WHERE YEAR(ngay_dat) = YEAR(CURDATE())
        GROUP BY MONTH(ngay_dat)
        ORDER BY thang ASC
    ";

        return $this->conn->query($sql)->fetchAll();
    }
    public function getTaiKhoanMoiHomNayVaHomQua()
    {
        $sql = "
        SELECT 
            DATE(ngay_dang_ky) as ngay,
            COUNT(*) as tong_tai_khoan_moi
        FROM tai_khoans
        WHERE DATE(ngay_dang_ky) IN (CURDATE(), CURDATE() - INTERVAL 1 DAY)
        GROUP BY DATE(ngay_dang_ky)
    ";

        return $this->conn->query($sql)->fetchAll();
    }
    //===================Thống kê sau khi lọc===================
    public function getThongKeTheoKhoangThoiGian($from, $to)
    {
        $sql = "
        SELECT 
            SUM(CASE WHEN trang_thai_id = 9 THEN tong_tien ELSE 0 END) as doanh_thu,
            COUNT(CASE WHEN trang_thai_id = 1 THEN 1 END) as don_moi
        FROM don_hangs
        WHERE DATE(ngay_dat) BETWEEN :from AND :to
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':from' => $from, ':to' => $to]);
        return $stmt->fetch();
    }

    public function getTaiKhoanMoiTheoKhoang($from, $to)
    {
        $sql = "
        SELECT COUNT(*) as tai_khoan
        FROM tai_khoans
        WHERE DATE(ngay_dang_ky) BETWEEN :from AND :to
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':from' => $from, ':to' => $to]);
        return $stmt->fetch();
    }

    public function getTopSanPhamTheoKhoang($from, $to)
    {
        $sql = "
        SELECT 
            sp.ten_san_pham,
            SUM(ct.so_luong) as total_quantity,
            SUM(ct.thanh_tien) as total_revenue
        FROM chi_tiet_don_hangs ct
        JOIN san_phams sp ON ct.san_pham_id = sp.id
        JOIN don_hangs dh ON ct.don_hang_id = dh.id
        WHERE dh.trang_thai_id = 9
        AND DATE(dh.ngay_dat) BETWEEN :from AND :to
        GROUP BY sp.id, sp.ten_san_pham
        ORDER BY total_quantity DESC
        LIMIT 5
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':from' => $from, ':to' => $to]);
        return $stmt->fetchAll();
    }

    public function getTopUsersTheoKhoang($from, $to)
    {
        $sql = "
        SELECT 
            tk.ho_ten,
            COUNT(dh.id) as total_orders,
            SUM(dh.tong_tien) as total_spent
        FROM don_hangs dh
        JOIN tai_khoans tk ON dh.tai_khoan_id = tk.id
        WHERE dh.trang_thai_id = 9
        AND DATE(dh.ngay_dat) BETWEEN :from AND :to
        GROUP BY tk.id, tk.ho_ten
        ORDER BY total_spent DESC
        LIMIT 5
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':from' => $from, ':to' => $to]);
        return $stmt->fetchAll();
    }
    public function getTopUsers()
    {
        $sql = "
        SELECT 
            tk.ho_ten,
            tk.anh_dai_dien,
            COUNT(dh.id) as total_orders,
            SUM(dh.tong_tien) as total_spent
        FROM don_hangs dh
        JOIN tai_khoans tk ON dh.tai_khoan_id = tk.id
        WHERE dh.trang_thai_id = 9
        GROUP BY tk.id, tk.ho_ten, tk.anh_dai_dien
        ORDER BY total_spent DESC
        LIMIT 5
    ";

        return $this->conn->query($sql)->fetchAll();
    }
}