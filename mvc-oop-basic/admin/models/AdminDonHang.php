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
    //
    // public function getDetailDonHang($id)
    // {
    //     try {
    //         $sql = "SELECT don_hangs.*, 
    //                 trang_thai_don_hangs.ten_trang_thai, 
    //                 tai_khoans.ho_ten, 
    //                 tai_khoans.email, 
    //                 tai_khoans.so_dien_thoai,
    //                 phuong_thuc_thanh_toans.ten_phuong_thuc
    //             FROM don_hangs
    //             INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
    //             INNER JOIN tai_khoans ON don_hangs.tai_khoan_id = tai_khoans.id
    //             INNER JOIN phuong_thuc_thanh_toans ON don_hangs.phuong_thuc_thanh_toan_id = phuong_thuc_thanh_toans.id
    //             WHERE don_hangs.id = :id";

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([':id' => $id]);

    //         return $stmt->fetch();
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }
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

    // // Thêm sản phẩm mới
    // public function insertSanPham(
    //     $ten_san_pham,
    //     $gia_san_pham,
    //     $gia_khuyen_mai,
    //     $so_luong,
    //     $ngay_nhap,
    //     $danh_muc_id,
    //     $trang_thai,
    //     $mo_ta,
    //     $hinh_anh
    // ) {
    //     try {
    //         $sql = "INSERT INTO san_phams(ten_san_pham, gia_san_pham, gia_khuyen_mai, so_luong, ngay_nhap, danh_muc_id, trang_thai, mo_ta, hinh_anh) 
    //                     VALUES (:ten_san_pham, :gia_san_pham, :gia_khuyen_mai, :so_luong, :ngay_nhap, :danh_muc_id, :trang_thai, :mo_ta, :hinh_anh)";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute([
    //             ':ten_san_pham' => $ten_san_pham,
    //             ':gia_san_pham' => $gia_san_pham,
    //             ':gia_khuyen_mai' => $gia_khuyen_mai,
    //             ':so_luong' => $so_luong,
    //             ':ngay_nhap' => $ngay_nhap,
    //             ':danh_muc_id' => $danh_muc_id,
    //             ':trang_thai' => $trang_thai,
    //             ':mo_ta' => $mo_ta,
    //             ':hinh_anh' => $hinh_anh,
    //         ]);
    //         //Lấy id sản phẩm vừa thêm
    //         return $this->conn->lastInsertId();
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // // Thêm ảnh vào album
    // public function insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh)
    // {
    //     try {
    //         $sql = "INSERT INTO hinh_anh_san_phams(san_pham_id, link_hinh_anh) 
    //                     VALUES (:san_pham_id, :link_hinh_anh)";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute([
    //             ':san_pham_id' => $san_pham_id,
    //             ':link_hinh_anh' => $link_hinh_anh,
    //         ]);
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // public function updateSanPham(
    //     $san_pham_id,
    //     $ten_san_pham,
    //     $gia_san_pham,
    //     $gia_khuyen_mai,
    //     $so_luong,
    //     $ngay_nhap,
    //     $danh_muc_id,
    //     $trang_thai,
    //     $mo_ta,
    //     $new_file
    // ) {
    //     try {
    //         $sql = "UPDATE san_phams SET ten_san_pham=:ten_san_pham, gia_san_pham=:gia_san_pham, 
    //                                         gia_khuyen_mai=:gia_khuyen_mai, so_luong=:so_luong, ngay_nhap=:ngay_nhap, 
    //                                         danh_muc_id=:danh_muc_id, trang_thai=:trang_thai, mo_ta=:mo_ta, hinh_anh=:hinh_anh
    //                                         WHERE id = :id";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute([
    //             ':id' => $san_pham_id,
    //             ':ten_san_pham' => $ten_san_pham,
    //             ':gia_san_pham' => $gia_san_pham,
    //             ':gia_khuyen_mai' => $gia_khuyen_mai,
    //             ':so_luong' => $so_luong,
    //             ':ngay_nhap' => $ngay_nhap,
    //             ':danh_muc_id' => $danh_muc_id,
    //             ':trang_thai' => $trang_thai,
    //             ':mo_ta' => $mo_ta,
    //             ':hinh_anh' => $new_file,
    //         ]);
    //         //Lấy id sản phẩm vừa thêm
    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // // Lấy một album ảnh sản phẩm theo id
    // public function getDetailAnhSanPham($id)
    // {
    //     try {
    //         $sql = "SELECT * FROM hinh_anh_san_phams where id = :id";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute([':id' => $id]);
    //         return $stmt->fetch();
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // // update album ảnh của sản phẩm
    // public function updateAnhSanPham($id, $new_file)
    // {
    //     try {
    //         $sql = "UPDATE hinh_anh_san_phams SET link_hinh_anh=:new_file WHERE id = :id";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute([
    //             ':id' => $id,
    //             ':new_file' => $new_file,
    //         ]);
    //         //Lấy id sản phẩm vừa thêm
    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // // // xóa ảnh trong album
    // public function destroyAnhSanPham($id)
    // {
    //     try {
    //         $sql = "DELETE FROM hinh_anh_san_phams where id = :id";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute(['id' => $id]);
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // // xóa danh mục theo ID
    // public function destroySanPham($id)
    // {
    //     try {
    //         $sql = "DELETE FROM san_phams where id = :id";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute(['id' => $id]);
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

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
