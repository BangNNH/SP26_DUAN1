<?php


class GioHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getGioHangFromUser($id)
    {
        try {
            $sql = "SELECT * FROM gio_hangs where tai_khoan_id = :tai_khoan_id";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':tai_khoan_id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getDetailGioHang($id)
    {
        try {
            $sql = "SELECT chi_tiet_gio_hangs.*, san_phams.ten_san_pham, san_phams.hinh_anh, san_phams.gia_san_pham, san_phams.gia_khuyen_mai
                FROM chi_tiet_gio_hangs
                INNER JOIN san_phams ON chi_tiet_gio_hangs.san_pham_id = san_phams.id
                WHERE chi_tiet_gio_hangs.gio_hang_id = :gio_hang_id";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':gio_hang_id' => $id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function addGioHang($id)
    {
        try {
            $sql = "INSERT INTO gio_hangs (tai_khoan_id) VALUES (:id)";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function updateSoLuong($gio_hang_id, $san_pham_id, $so_luong)
    {
        try {
            $sql = "UPDATE chi_tiet_gio_hangs 
                    SET so_luong = :so_luong 
                    WHERE gio_hang_id = :gio_hang_id AND san_pham_id = :san_pham_id";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':gio_hang_id' => $gio_hang_id,
                ':san_pham_id' => $san_pham_id,
                ':so_luong' => $so_luong
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }


    public function addDetailGioHang($gio_hang_id, $san_pham_id, $so_luong)
    {
        try {
            $sql = "INSERT INTO chi_tiet_gio_hangs (gio_hang_id, san_pham_id, so_luong) 
                    VALUES (:gio_hang_id, :san_pham_id, :so_luong)";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':gio_hang_id' => $gio_hang_id,
                ':san_pham_id' => $san_pham_id,
                ':so_luong' => $so_luong
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function clearDetailGioHang($gioHangId)
    {
        try {
            $sql = "DELETE FROM chi_tiet_gio_hangs WHERE gio_hang_id = :gio_hang_id";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':gio_hang_id' => $gioHangId,
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function clearGioHang($taiKhoanId)
    {
        try {
            $sql = "DELETE FROM gio_hangs WHERE tai_khoan_id = :tai_khoan_id";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':tai_khoan_id' => $taiKhoanId,
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    // update so luong
    public function increaseQuantity($tai_khoan_id, $san_pham_id)
    {
        $sql = "UPDATE chi_tiet_gio_hangs ct
            JOIN gio_hangs gh ON ct.gio_hang_id = gh.id
            SET ct.so_luong = ct.so_luong + 1
            WHERE gh.tai_khoan_id = :tai_khoan_id
            AND ct.san_pham_id = :san_pham_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'tai_khoan_id' => $tai_khoan_id,
            'san_pham_id' => $san_pham_id
        ]);
    }

    public function decreaseQuantity($userId, $productId, $so_luong_hien_tai)
    {
        if ($so_luong_hien_tai <= 1) {
            $sql = "DELETE ct FROM chi_tiet_gio_hangs ct
                JOIN gio_hangs gh ON ct.gio_hang_id = gh.id
                WHERE gh.tai_khoan_id = :userId
                AND ct.san_pham_id = :productId";
        } else {
            $sql = "UPDATE chi_tiet_gio_hangs ct
                JOIN gio_hangs gh ON ct.gio_hang_id = gh.id
                SET ct.so_luong = ct.so_luong - 1
                WHERE gh.tai_khoan_id = :userId
                AND ct.san_pham_id = :productId";
        }

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'userId' => $userId,
            'productId' => $productId
        ]);
    }

    // delete item
    public function deleteItem($tai_khoan_id, $san_pham_id)
    {
        $sql = "DELETE ct FROM chi_tiet_gio_hangs ct
            JOIN gio_hangs gh ON ct.gio_hang_id = gh.id
            WHERE gh.tai_khoan_id = :tai_khoan_id
            AND ct.san_pham_id = :san_pham_id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'tai_khoan_id' => $tai_khoan_id,
            'san_pham_id' => $san_pham_id
        ]);
    }
}
