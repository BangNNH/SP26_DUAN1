<?php
class SanPham
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Hàm lấy toàn bộ danh sách sản phẩm
    public function getAllSanPham()
    {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            ';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            // Nếu có lỗi, trả về mảng rỗng để tránh warnings trong view
            error_log("SanPham::getAllSanPham error: " . $e->getMessage());
            return [];
        }
    }
}