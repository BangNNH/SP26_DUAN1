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
     public function getDetailSanPham($id)
        {
            try {
                $sql = "SELECT san_phams.*, danh_mucs.ten_danh_muc
                FROM san_phams
                INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                WHERE san_phams.id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':id' => $id]);
                return $stmt->fetch();
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }

        // Lấy danh sách ảnh trong album
        public function getListAnhSanPham($id)
        {
            try {
                $sql = "SELECT * FROM hinh_anh_san_phams where san_pham_id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':id' => $id]);
                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }
        public function getBinhLuanFromSanPham($id)
        {
        try {
            $sql = "SELECT binh_luans.*, tai_khoans.ho_ten, tai_khoans.anh_dai_dien
                FROM binh_luans
                INNER JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
                WHERE binh_luans.san_pham_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getListSanPhamDanhMuc($danh_muc_id, $current_product_id = null)
        {
            try {
                $sql = "SELECT san_phams.*, danh_mucs.ten_danh_muc
                FROM san_phams
                INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                WHERE san_phams.danh_muc_id = :danh_muc_id";
                if ($current_product_id) {
                    $sql .= " AND san_phams.id != :current_product_id";
                }
                $sql .= " LIMIT 8";

                $stmt = $this->conn->prepare($sql);
                $params = [':danh_muc_id' => $danh_muc_id];
                if ($current_product_id) {
                    $params[':current_product_id'] = $current_product_id;
                }
                $stmt->execute($params);
                return $stmt->fetchAll();
            } catch (Exception $e) {
                error_log("SanPham::getListSanPhamDanhMuc error: " . $e->getMessage());
                return [];
            }
        }
}