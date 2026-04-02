<?php
class AdminBinhLuanController
{
    public $modelBinhLuan;

    public function __construct()
    {
        $this->modelBinhLuan = new AdminBinhLuan();
    }

    public function danhSachBinhLuan()
    {
        // 1. Lấy dữ liệu lọc
        $san_pham_id = $_GET['san_pham_id'] ?? null;
        $tu_ngay = $_GET['tu_ngay'] ?? null;
        $den_ngay = $_GET['den_ngay'] ?? null;

        // 2. Lấy dữ liệu sắp xếp từ URL (Đây là phần bạn có thể đang thiếu)
        $sort = $_GET['sort'] ?? 'id';
        $order = $_GET['order'] ?? 'desc';

        // 3. Truyền tất cả vào Model
        $listBinhLuan = $this->modelBinhLuan->getAllBinhLuan($san_pham_id, $tu_ngay, $den_ngay, $sort, $order);
        $listSanPham = $this->modelBinhLuan->getDanhSachSanPham();

        // 4. Gọi View
        require_once './views/binhluan/list.php';
    }

    public function xoaBinhLuan()
    {
        $id = $_GET['id_binh_luan'];
        $this->modelBinhLuan->deleteBinhLuan($id);
        header("Location: " . BASE_URL_ADMIN . "?act=quan-ly-binh-luan");
    }
}