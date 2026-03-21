    <?php
    class AdminSanPham
    {
        public $conn;

        public function __construct()
        {
            $this->conn = connectDB();
        }

        // Lấy toàn bộ danh mục
        public function getAllSanPham()
        {
            try {
                $sql = "SELECT san_phams.*, danh_mucs.ten_danh_muc
                FROM san_phams
                INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id ORDER BY san_phams.id DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }

        // Lấy một sản phẩm theo id
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

        // Thêm sản phẩm mới
        public function insertSanPham($data)
        {
            // debug($data);
            try {
                $sql = "INSERT INTO san_phams (
            ten_san_pham,
            gia_san_pham,
            gia_khuyen_mai,
            so_luong,
            ngay_nhap,
            danh_muc_id,
            trang_thai,
            mo_ta,
            hinh_anh,
            code,
            is_new,
            is_hot,
            gioi_tinh,
            loai_may,
            xuat_xu,
            kich_thuoc,
            chat_lieu_day,
            chong_nuoc
        ) VALUES (
            :ten_san_pham,
            :gia_san_pham,
            :gia_khuyen_mai,
            :so_luong,
            :ngay_nhap,
            :danh_muc_id,
            :trang_thai,
            :mo_ta,
            :hinh_anh,
            :code,
            :is_new,
            :is_hot,
            :gioi_tinh,
            :loai_may,
            :xuat_xu,
            :kich_thuoc,
            :chat_lieu_day,
            :chong_nuoc
        )";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':ten_san_pham'   => $data['ten_san_pham'],
                    ':gia_san_pham'   => $data['gia_san_pham'],
                    ':gia_khuyen_mai' => $data['gia_khuyen_mai'],
                    ':so_luong'       => $data['so_luong'],
                    ':ngay_nhap'      => $data['ngay_nhap'],
                    ':danh_muc_id'    => $data['danh_muc_id'],
                    ':trang_thai'     => $data['trang_thai'],
                    ':mo_ta'          => $data['mo_ta'],
                    ':hinh_anh'       => $data['hinh_anh'],
                    ':code'           => $data['code'],
                    ':is_new'         => $data['is_new'],
                    ':is_hot'         => $data['is_hot'],
                    ':gioi_tinh'      => $data['gioi_tinh'],
                    ':loai_may'       => $data['loai_may'],
                    ':xuat_xu'        => $data['xuat_xu'],
                    ':kich_thuoc'     => $data['kich_thuoc'],
                    ':chat_lieu_day'  => $data['chat_lieu_day'],
                    ':chong_nuoc'     => $data['chong_nuoc'],
                ]);

                return $this->conn->lastInsertId();
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }

        // Thêm ảnh vào album
        public function insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh)
        {
            try {
                $sql = "INSERT INTO hinh_anh_san_phams(san_pham_id, link_hinh_anh) 
                        VALUES (:san_pham_id, :link_hinh_anh)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':san_pham_id' => $san_pham_id,
                    ':link_hinh_anh' => $link_hinh_anh,
                ]);
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }

        public function updateSanPham(
            $san_pham_id,
            $ten_san_pham,
            $gia_san_pham,
            $gia_khuyen_mai,
            $so_luong,
            $ngay_nhap,
            $danh_muc_id,
            $trang_thai,
            $mo_ta,
            $hinh_anh,
            $code,
            $is_new,
            $is_hot,
            $gioi_tinh,
            $loai_may,
            $xuat_xu,
            $kich_thuoc,
            $chat_lieu_day,
            $chong_nuoc
        ) {
            try {
                $sql = "UPDATE san_phams SET ten_san_pham=:ten_san_pham, gia_san_pham=:gia_san_pham,
                                            gia_khuyen_mai=:gia_khuyen_mai, so_luong=:so_luong, ngay_nhap=:ngay_nhap,
                                            danh_muc_id=:danh_muc_id, trang_thai=:trang_thai, mo_ta=:mo_ta, hinh_anh=:hinh_anh,
                                            code=:code, is_new=:is_new, is_hot=:is_hot, gioi_tinh=:gioi_tinh, loai_may=:loai_may,
                                            xuat_xu=:xuat_xu, kich_thuoc=:kich_thuoc, chat_lieu_day=:chat_lieu_day, chong_nuoc=:chong_nuoc
                                            WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':id' => $san_pham_id,
                    ':ten_san_pham' => $ten_san_pham,
                    ':gia_san_pham' => $gia_san_pham,
                    ':gia_khuyen_mai' => $gia_khuyen_mai,
                    ':so_luong' => $so_luong,
                    ':ngay_nhap' => $ngay_nhap,
                    ':danh_muc_id' => $danh_muc_id,
                    ':trang_thai' => $trang_thai,
                    ':mo_ta' => $mo_ta,
                    ':hinh_anh' => $hinh_anh,
                    ':code' => $code,
                    ':is_new' => $is_new,
                    ':is_hot' => $is_hot,
                    ':gioi_tinh' => $gioi_tinh,
                    ':loai_may' => $loai_may,
                    ':xuat_xu' => $xuat_xu,
                    ':kich_thuoc' => $kich_thuoc,
                    ':chat_lieu_day' => $chat_lieu_day,
                    ':chong_nuoc' => $chong_nuoc,
                ]);
                return true;
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }

        // Lấy một album ảnh sản phẩm theo id
        public function getDetailAnhSanPham($id)
        {
            try {
                $sql = "SELECT * FROM hinh_anh_san_phams where id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':id' => $id]);
                return $stmt->fetch();
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }

        // update album ảnh của sản phẩm
        public function updateAnhSanPham($id, $new_file)
        {
            try {
                $sql = "UPDATE hinh_anh_san_phams SET link_hinh_anh=:new_file WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':id' => $id,
                    ':new_file' => $new_file,
                ]);
                //Lấy id sản phẩm vừa thêm
                return true;
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }

        // // xóa ảnh trong album
        public function destroyAnhSanPham($id)
        {
            try {
                $sql = "DELETE FROM hinh_anh_san_phams where id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(['id' => $id]);
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }

        // xóa danh mục theo ID
        public function destroySanPham($id)
        {
            try {
                $sql = "DELETE FROM san_phams where id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(['id' => $id]);
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }


        // Bình luận

        public function getBinhLuanFromKhachHang($id)
        {
            try {
                $sql = "SELECT binh_luans.*, san_phams.ten_san_pham
                FROM binh_luans
                INNER JOIN san_phams ON binh_luans.san_pham_id = san_phams.id
                WHERE binh_luans.tai_khoan_id = :id";
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
                $sql = "SELECT binh_luans.*, tai_khoans.ho_ten
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


        public function getDetailBinhLuan($id)
        {
            try {
                $sql = "SELECT * FROM binh_luans where id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':id' => $id]);
                return $stmt->fetch();
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }

        public function updateTrangThaiBinhLuan($id, $trang_thai)
        {
            try {
                $sql = "UPDATE binh_luans SET trang_thai=:trang_thai WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':trang_thai' => $trang_thai,
                    ':id' => $id
                ]);
                //Lấy id sản phẩm vừa thêm
                return true;
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
        }
    }
