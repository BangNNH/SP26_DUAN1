<?php


class BinhLuan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function insertComment($san_pham_id, $tai_khoan_id, $noi_dung, $ngay_dang, $trang_thai)
    {
        $sql = "INSERT INTO binh_luans 
                (san_pham_id, tai_khoan_id, noi_dung, ngay_dang, trang_thai)
                VALUES 
                (:san_pham_id, :tai_khoan_id, :noi_dung, :ngay_dang, :trang_thai)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':san_pham_id' => $san_pham_id,
            ':tai_khoan_id' => $tai_khoan_id,
            ':noi_dung' => $noi_dung,
            ':ngay_dang' => $ngay_dang,
            ':trang_thai' => $trang_thai
        ]);
    }

    public function getBinhLuanFromSanPham($id)
    {
        try {
            $sql = "SELECT binh_luans.*, tai_khoans.ho_ten, tai_khoans.anh_dai_dien
                FROM binh_luans
                INNER JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
                WHERE binh_luans.san_pham_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}
