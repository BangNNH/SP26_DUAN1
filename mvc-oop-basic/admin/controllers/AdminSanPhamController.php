<?php
class AdminSanPhamController
{
    public $modelSanPham;
    public $modelDanhMuc;

    public function __construct()
    {
        $this->modelSanPham = new AdminSanPham();
        $this->modelDanhMuc = new AdminDanhMuc();
    }

    public function danhSachSanPham()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/sanpham/listSanPham.php';
    }

    //  hiển thị form thêm sản phẩm
    public function formAddSanPham()
    {
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        require_once './views/sanpham/addSanPham.php';

        // Xóa session sau khi load trang
        deleteSessionError();
    }

    // thêm sản phẩm
    public function postAddSanPham()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // debug($_FILES);
            // ===== 1. Gom data =====
            $data = [
                'ten_san_pham'   => $_POST['ten_san_pham'] ?? '',
                'gia_san_pham'   => $_POST['gia_san_pham'] ?? '',
                'gia_khuyen_mai' => $_POST['gia_khuyen_mai'] ?? '',
                'so_luong'       => $_POST['so_luong'] ?? '',
                'ngay_nhap'      => $_POST['ngay_nhap'] ?? '',
                'danh_muc_id'    => $_POST['danh_muc_id'] ?? '',
                'trang_thai'     => $_POST['trang_thai'] ?? '',
                'mo_ta'          => $_POST['mo_ta'] ?? '',
                'code'           => $_POST['code'] ?? '',
                'is_new'         => $_POST['is_new'] ?? 0,
                'is_hot'         => $_POST['is_hot'] ?? 0,
                'gioi_tinh'      => $_POST['gioi_tinh'] ?? '',
                'loai_may'       => $_POST['loai_may'] ?? '',
                'xuat_xu'        => $_POST['xuat_xu'] ?? '',
                'kich_thuoc'     => $_POST['kich_thuoc'] ?? '',
                'chat_lieu_day'  => $_POST['chat_lieu_day'] ?? '',
                'chong_nuoc'     => $_POST['chong_nuoc'] ?? '',
            ];

            $hinh_anh = $_FILES['hinh_anh'] ?? null;
            $img_array = $_FILES['img_array'] ?? [];

            // ===== 2. Validate =====
            $errors = [];

            if (empty($data['ten_san_pham'])) {
                $errors['ten_san_pham'] = 'Tên sản phẩm không được để trống.';
            }

            if (empty($data['gia_san_pham'])) {
                $errors['gia_san_pham'] = 'Giá sản phẩm không được để trống.';
            }

            if (!empty($data['gia_khuyen_mai']) && $data['gia_khuyen_mai'] > $data['gia_san_pham']) {
                $errors['gia_khuyen_mai'] = 'Giá khuyến mãi phải nhỏ hơn giá gốc.';
            }

            if (empty($data['so_luong'])) {
                $errors['so_luong'] = 'Số lượng không được để trống.';
            }

            if (empty($data['ngay_nhap'])) {
                $errors['ngay_nhap'] = 'Ngày nhập không được để trống.';
            }

            if (empty($data['danh_muc_id'])) {
                $errors['danh_muc_id'] = 'Danh mục không được để trống.';
            }

            if (empty($data['trang_thai'])) {
                $errors['trang_thai'] = 'Trạng thái không được để trống.';
            }

            if ($hinh_anh['error'] !== 0) {
                $errors['hinh_anh'] = 'Vui lòng chọn ảnh sản phẩm.';
            }

            $_SESSION['errors'] = $errors;

            // ===== 3. Nếu lỗi =====
            if (!empty($errors)) {
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-them-san-pham');
                exit();
            }

            // ===== 4. Upload ảnh =====
            $data['hinh_anh'] = uploadFile($hinh_anh, './uploads/');
            // ===== 5. Insert =====

            $san_pham_id = $this->modelSanPham->insertSanPham($data);

            if (!$san_pham_id) {
                $_SESSION['error'] = 'Thêm sản phẩm thất bại. Vui lòng thử lại.';
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-them-san-pham');
                exit();
            }

            // ===== 6. Album ảnh =====
            if (!empty($img_array['name'][0])) {
                foreach ($img_array['name'] as $key => $value) {

                    if ($img_array['error'][$key] == 0) {
                        $file = [
                            'name' => $img_array['name'][$key],
                            'type' => $img_array['type'][$key],
                            'tmp_name' => $img_array['tmp_name'][$key],
                            'error' => $img_array['error'][$key],
                            'size' => $img_array['size'][$key],
                        ];

                        $link_hinh_anh = uploadFile($file, './uploads/');
                        $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh);
                    }
                }
            }

            // ===== 7. Redirect =====
            $_SESSION['success'] = 'Thêm sản phẩm thành công.';
            $_SESSION['flash'] = true;
            header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }

    // //hiển thị form sửa
    public function formEditSanPham()
    {
        // Lấy ra thông tin của sản phẩm cần sửa
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        if ($sanPham) {
            require_once './views/sanpham/editSanPham.php';
            deleteSessionError();
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }

    // //sửa dữ liệu sản phẩm
    public function postEditSanPham()
    {
        //Kiểm tra xem dữ liệu có phải được submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Lấy ra dữ liệu cũ của sản phẩm
            $san_pham_id = $_POST['san_pham_id'] ?? '';
            // truy vấn
            $sanPhamOld = $this->modelSanPham->getDetailSanPham($san_pham_id);
            $old_file = $sanPhamOld['hinh_anh']; //Lấy ảnh cũ để phục vụ cho sửa ảnh

            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $gia_san_pham = $_POST['gia_san_pham'] ?? '';
            $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? '';
            $so_luong = $_POST['so_luong'] ?? '';
            $ngay_nhap = $_POST['ngay_nhap'] ?? '';
            $danh_muc_id = $_POST['danh_muc_id'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';

            $hinh_anh = $_FILES['hinh_anh'] ?? null;


            // validate
            $errors = [];
            if (empty($ten_san_pham)) {
                $errors['ten_san_pham'] = 'Tên sản phẩm không được để trống.';
            }
            if (empty($gia_san_pham)) {
                $errors['gia_san_pham'] = 'Giá sản phẩm không được để trống.';
            }
            if (empty($gia_khuyen_mai)) {
                $errors['gia_khuyen_mai'] = 'Giá khuyến mãi không được để trống.';
            }
            if (empty($so_luong)) {
                $errors['so_luong'] = 'Số lượng không được để trống.';
            }
            if (empty($ngay_nhap)) {
                $errors['ngay_nhap'] = 'Ngày nhập không được để trống.';
            }
            if (empty($danh_muc_id)) {
                $errors['danh_muc_id'] = 'Danh mục không được để trống.';
            }
            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'Trạng thái không được để trống.';
            }

            $_SESSION['errors'] = $errors;

            // logic sửa ảnh
            if (isset($hinh_anh) && $hinh_anh['error'] == UPLOAD_ERR_OK) {
                // upload ảnh mới lên
                $new_file = uploadFile($hinh_anh, './uploads/');
                if (!empty($old_file)) {
                    deleteFile($old_file);
                }
            } else {
                $new_file = $old_file;
            }

            if (empty($errors)) {
                // Nếu không lỗi thì tiến hành update sản phẩm
                $this->modelSanPham->updateSanPham(
                    $san_pham_id,
                    $ten_san_pham,
                    $gia_san_pham,
                    $gia_khuyen_mai,
                    $so_luong,
                    $ngay_nhap,
                    $danh_muc_id,
                    $trang_thai,
                    $mo_ta,
                    $new_file
                );
                header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            } else {
                // Trả về form lỗi
                // Đặt chỉ thị xóa session sau khi hiển thị form
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $san_pham_id);
                exit();
            }
        }
    }

    // update albuma ảnh sản phẩm
    public function postEditAnhSanPham()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $san_pham_id = $_POST['san_pham_id'] ?? '';

            // Lấy danh sách ảnh hiện tại của sản phẩm
            $listAnhSanPhamCurrent = $this->modelSanPham->getListAnhSanPham($san_pham_id);

            // Xử lý các ảnh được gửi từ form
            $img_array = $_FILES['img_array'];
            $img_delete = isset($_POST['img_delete']) ? explode(',', $_POST['img_delete']) : [];
            $current_img_ids = $_POST['current_img_ids'] ?? [];

            // Khai báo mảng để lưu ảnh thêm mới hoặc thay thế ảnh cũ
            $upload_file = [];

            // upload ảnh mới hoặc thay thế ảnh cũ
            foreach ($img_array['name'] as $key => $value) {
                if ($img_array['error'][$key] == UPLOAD_ERR_OK) {
                    $new_file = uploadFileAlbum($img_array, './uploads/', $key);
                    if ($new_file) {
                        $upload_file[] = [
                            'id' => $current_img_ids[$key] ?? null,
                            'file' => $new_file,
                        ];
                    }
                }
            }
            // Lưu ảnh mới vào db và xóa ảnh cũ
            foreach ($upload_file as $file_info) {
                if ($file_info['id']) {
                    $old_file = $this->modelSanPham->getDetailAnhSanPham($file_info)['link_hinh_anh'];

                    // Cập nhật ảnh cũ
                    $this->modelSanPham->updateAnhSanPham($file_info['id'], $file_info['file']);

                    //xóa ảnh cũ
                    deleteFile($old_file);
                } else {
                    // Thêm ảnh mới
                    $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $file_info['file']);
                }
            }
            // debug($upload_file);
            // Xử lý xóa ảnh
            foreach ($listAnhSanPhamCurrent as $anhSP) {
                $anh_id = $anhSP['id'];
                if (in_array($anh_id, $img_delete)) {
                    // xóa ảnh trong db
                    $this->modelSanPham->destroyAnhSanPham($anh_id);

                    // xóa file
                    deleteFile($anhSP['link_hinh_anh']);
                }
            }
            header("Location: " . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $san_pham_id);
            exit();
        }
    }

    //xóa sản phẩm
    public function deleteSanPham()
    {
        // Lấy ra thông tin của sản phẩm cần xóa
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);

        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);


        if ($sanPham) {
            $this->modelSanPham->destroySanPham($id);
            deleteFile(($sanPham['hinh_anh']));
        }

        if ($listAnhSanPham) {
            foreach ($listAnhSanPham as $key => $anhSP) {
                deleteFile($anhSP['link_hinh_anh']);
                $this->modelSanPham->destroyAnhSanPham($anhSP['id']);
            }
        }
        header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
        exit();
    }

    // Xem chi tiết sản phẩm
    public function detailSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);
        if ($sanPham) {
            require_once './views/sanpham/detailSanPham.php';
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }

    public function updateTrangThaiBinhLuan()
    {
        $id_binh_luan = $_POST['id_binh_luan'];
        $name_view = $_POST['name_view'];
        $binhLuan = $this->modelSanPham->getDetailBinhLuan($id_binh_luan);


        if ($binhLuan) {
            $trang_thai_update = "";
            if ($binhLuan['trang_thai'] == 1) {
                $trang_thai_update = 2;
            } else {
                $trang_thai_update = 1;
            }
            $status = $this->modelSanPham->updateTrangThaiBinhLuan($id_binh_luan, $trang_thai_update);
            if ($status) {
                if ($name_view == 'detail_khach') {
                    header("Location: " . BASE_URL_ADMIN . '?act=chi-tiet-khach-hang&id_khach_hang=' . $binhLuan['tai_khoan_id']);
                } else {
                    header("Location: " . BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id_san_pham=' . $binhLuan['san_pham_id']);
                }
            }
        }
    }
}
