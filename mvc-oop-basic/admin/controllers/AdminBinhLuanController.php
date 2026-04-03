<?php
class AdminBinhLuan {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy danh sách bình luận kèm bộ lọc
    public function getAllBinhLuan($san_pham_id = null, $tu_ngay = null, $den_ngay = null, $sort = 'id', $order = 'desc') {
    try {
        // Kiểm tra an toàn để tránh SQL Injection
        $allowedSort = ['id', 'ten_san_pham', 'ngay_dang'];
        $sort = in_array($sort, $allowedSort) ? $sort : 'id';
        $order = (strtoupper($order) === 'ASC') ? 'ASC' : 'DESC';

        $sql = "SELECT bl.*, sp.ten_san_pham, tk.ho_ten 
                FROM binh_luans bl
                JOIN san_phams sp ON bl.san_pham_id = sp.id
                JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id
                WHERE 1=1";

        if ($san_pham_id) {
            $sql .= " AND bl.san_pham_id = :san_pham_id";
        }
        if ($tu_ngay) {
            $sql .= " AND DATE(bl.ngay_dang) >= :tu_ngay";
        }
        if ($den_ngay) {
            $sql .= " AND DATE(bl.ngay_dang) <= :den_ngay";
        }

        //Nối câu lệnh sắp xếp vào đây
        $sql .= " ORDER BY $sort $order";

        $stmt = $this->conn->prepare($sql);

        if ($san_pham_id) $stmt->bindParam(':san_pham_id', $san_pham_id);
        if ($tu_ngay) $stmt->bindParam(':tu_ngay', $tu_ngay);
        if ($den_ngay) $stmt->bindParam(':den_ngay', $den_ngay);

        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

    // Lấy danh sách sản phẩm để đổ vào ô lọc (Select box)
    public function getDanhSachSanPham() {
        try {
            $sql = "SELECT id, ten_san_pham FROM san_phams";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Xóa hoặc ẩn bình luận
    public function deleteBinhLuan($id) {
        try {
            $sql = "DELETE FROM binh_luans WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}