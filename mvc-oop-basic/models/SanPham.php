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

    public function getSanPhamBanChay()
    {
        try {
            $sql = "select * from san_phams where is_hot = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
        }
    }

    public function getSanPhamMoi()
    {
        try {
            $sql = "select * from san_phams where is_new = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
        }
    }

    public function getSanPhamByCategory($cateId)
    {
        try {
            $sql = "SELECT * FROM san_phams WHERE danh_muc_id = :cateId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':cateId', $cateId);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
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

    /**
     * Tìm kiếm sản phẩm theo từ khóa, giá, và loại
     */
    public function searchProducts($keyword = '', $minPrice = 0, $maxPrice = 999999999, $type = '')
    {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
                FROM san_phams
                INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                WHERE 1=1';

            $params = [];

            // Tìm kiếm theo từ khóa
            if (!empty($keyword)) {
                $sql .= " AND (san_phams.ten_san_pham LIKE :keyword OR san_phams.mo_ta LIKE :keyword)";
                $params[':keyword'] = '%' . $keyword . '%';
            }

            // Lọc theo khoảng giá
            if ($minPrice > 0 || $maxPrice < 999999999) {
                $sql .= " AND san_phams.gia_khuyen_mai BETWEEN :minPrice AND :maxPrice";
                $params[':minPrice'] = $minPrice;
                $params[':maxPrice'] = $maxPrice;
            }

            // Lọc theo loại sản phẩm
            if (!empty($type)) {
                $sql .= " AND san_phams.loai_may = :type";
                $params[':type'] = $type;
            }

            // Sắp xếp: các sản phẩm mới nhất trước
            $sql .= " ORDER BY san_phams.ngay_nhap DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("SanPham::searchProducts error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy danh sách các loại sản phẩm duy nhất
     */
    public function getProductTypes()
    {
        try {
            $sql = "SELECT DISTINCT loai_may FROM san_phams WHERE loai_may IS NOT NULL AND loai_may != '' ORDER BY loai_may";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("SanPham::getProductTypes error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Kiểm tra tồn kho cho sản phẩm
     * @param int $id - ID sản phẩm
     * @param int $soLuong - Số lượng cần kiểm tra
     * @return array ['status' => true/false, 'message' => 'thông báo', 'product' => chi tiết sản phẩm]
     */
    public function checkStock($id, $soLuong)
    {
        try {
            // Kiểm tra sản phẩm có tồn tại không
            $sanPham = $this->getDetailSanPham($id);
            
            if (!$sanPham) {
                return [
                    'status' => false,
                    'message' => 'Sản phẩm không tồn tại',
                    'product' => null
                ];
            }

            // Kiểm tra số lượng trong kho
            if ($sanPham['so_luong'] < $soLuong) {
                return [
                    'status' => false,
                    'message' => 'Sản phẩm ' . $sanPham['ten_san_pham'] . ' chỉ còn ' . $sanPham['so_luong'] . ' sản phẩm, không đủ số lượng bạn yêu cầu',
                    'product' => $sanPham
                ];
            }

            // Kiểm tra trạng thái của sản phẩm
            if ($sanPham['trang_thai'] != 1) {
                return [
                    'status' => false,
                    'message' => 'Sản phẩm ' . $sanPham['ten_san_pham'] . ' hiện không còn bán',
                    'product' => $sanPham
                ];
            }

            return [
                'status' => true,
                'message' => 'Kiểm tra tồn kho thành công',
                'product' => $sanPham
            ];
        } catch (Exception $e) {
            error_log("SanPham::checkStock error: " . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Lỗi kiểm tra tồn kho',
                'product' => null
            ];
        }
    }

    /**
     * Giảm số lượng sản phẩm trong kho
     * @param int $id - ID sản phẩm
     * @param int $soLuong - Số lượng cần giảm
     * @return bool - True nếu thành công, False nếu thất bại
     */
    public function decreaseStock($id, $soLuong)
    {
        try {
            // Lấy số lượng hiện tại
            $sanPham = $this->getDetailSanPham($id);
            
            if (!$sanPham) {
                error_log("SanPham::decreaseStock - Sản phẩm ID: $id không tồn tại");
                return false;
            }

            // Kiểm tra số lượng có đủ không
            if ($sanPham['so_luong'] < $soLuong) {
                error_log("SanPham::decreaseStock - Sản phẩm ID: $id không đủ số lượng để giảm");
                return false;
            }

            // Giảm số lượng (có thể về 0)
            $newQuantity = max(0, $sanPham['so_luong'] - $soLuong);
            
            $sql = "UPDATE san_phams SET so_luong = :so_luong";
            $params = [':so_luong' => $newQuantity, ':id' => $id];

            // Nếu số lượng về 0, tự động đổi trạng thái thành dừng bán (trang_thai = 0)
            if ($newQuantity <= 0) {
                $sql .= ", trang_thai = 0";
                error_log("SanPham::decreaseStock - Sản phẩm ID: $id hết hàng, tự động đổi trạng thái sang dừng bán");
            }

            $sql .= " WHERE id = :id";
            
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute($params);

            if ($result) {
                error_log("SanPham::decreaseStock - Giảm thành công sản phẩm ID: $id, giảm: $soLuong, còn lại: $newQuantity");
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("SanPham::decreaseStock error: " . $e->getMessage());
            return false;
        }
    }
}
