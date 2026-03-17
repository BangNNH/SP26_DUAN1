<?php
class AdminDonHangController
{
    public $modelDonHang;

    public function __construct()
    {
        $this->modelDonHang = new AdminDonHang();
    }

    public function danhSachDonHang()
    {
        $listDonHang = $this->modelDonHang->getAllDonHang();
        require_once './views/donhang/listDonHang.php';
    }

    public function detailDonHang()
    {
        $don_hang_id = $_GET['id_don_hang'];

        // Lấy thông tin đơn hàng ở bảng đơn hàng
        $donHang = $this->modelDonHang->getDetailDonHang($don_hang_id);

        //lấy danh sách sản phẩm của đơn hàng đã Đặt của đơn hàng ở bảng chi_tiết_đơn_hàng
        $sanPhamDonHang = $this->modelDonHang->getListSpDonHang($don_hang_id);

        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();

        require_once './views/donhang/detailDonHang.php';



    }

    // //hiển thị form sửa
    public function formEditDonHang()
    {
        // Lấy ra thông tin của đơn hàng cần sửa
        $id = $_GET['id_don_hang'];
        $donHang = $this->modelDonHang->getDetailDonHang($id);
        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();
        if ($donHang) {
            require_once './views/donhang/editDonHang.php';
            deleteSessionError();
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=don-hang');
            exit();
        }
    }

    // //sửa dữ liệu sản phẩm
    public function postEditDonHang()
    {
        //Kiểm tra xem dữ liệu có phải được submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Lấy ra dữ liệu cũ của sản phẩm
            $don_hang_id = $_POST['don_hang_id'] ?? '';

            $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'] ?? '';
            $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'] ?? '';
            $email_nguoi_nhan = $_POST['email_nguoi_nhan'] ?? '';
            $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'] ?? '';
            $ghi_chu = $_POST['ghi_chu'] ?? '';
            $trang_thai_id = $_POST['trang_thai_id'] ?? '';

            // tạo 1 mảng trống để chứa dữ liệu
            $errors = [];
            if (empty($ten_nguoi_nhan)) {
                $errors['ten_nguoi_nhan'] = 'Tên người nhận không được để trống.';
            }
            if (empty($sdt_nguoi_nhan)) {
                $errors['sdt_nguoi_nhan'] = 'Số điện thoại không được để trống.';
            }
            if (empty($email_nguoi_nhan)) {
                $errors['email_nguoi_nhan'] = 'Email không được để trống.';
            }
            if (empty($dia_chi_nguoi_nhan)) {
                $errors['dia_chi_nguoi_nhan'] = 'Địa chỉ không được để trống.';
            }
            if (empty($trang_thai_id)) {
                $errors['trang_thai_id'] = 'Trạng thái đơn hàng.';
            }

            $_SESSION['errors'] = $errors;

            if (empty($errors)) {
                // Nếu không lỗi thì tiến hành sửa sản phẩm
                $this->modelDonHang->updateDonHang(
                    $don_hang_id,
                    $ten_nguoi_nhan,
                    $sdt_nguoi_nhan,
                    $email_nguoi_nhan,
                    $dia_chi_nguoi_nhan,
                    $ghi_chu,
                    $trang_thai_id
                );
                header("Location: " . BASE_URL_ADMIN . '?act=don-hang');
                exit();
            } else {
                // Trả về form lỗi
                // Đặt chỉ thị xóa session sau khi hiển thị form
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang=' . $don_hang_id);
                exit();
            }
        }
    }
}
