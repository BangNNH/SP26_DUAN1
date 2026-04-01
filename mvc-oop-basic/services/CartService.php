<?php
class CartService
{
    private $gioHangModel;

    public function __construct()
    {
        $this->gioHangModel = new GioHang();
    }
    public function mergeCartAfterLogin($userId)
    {
        $sessionCart = $_SESSION['cart'] ?? [];

        if (empty($sessionCart)) return;

        // 1. lấy giỏ hàng user
        $gioHang = $this->gioHangModel->getGioHangFromUser($userId);

        if (!$gioHang) {
            $gioHangId = $this->gioHangModel->addGioHang($userId);
        } else {
            $gioHangId = $gioHang['id'];
        }

        try {
            $this->gioHangModel->beginTransaction();

            foreach ($sessionCart as $san_pham_id => $item) {
                $so_luong = $item['so_luong'];

                $this->gioHangModel->addOrUpdateItem(
                    $gioHangId,
                    $san_pham_id,
                    $so_luong
                );
            }

            $this->gioHangModel->commit();

            // clear session
            unset($_SESSION['cart']);
            unset($_SESSION['tong_so_luong']);
        } catch (Exception $e) {
            $this->gioHangModel->rollBack();
            echo "Lỗi merge cart: " . $e->getMessage();
        }
    }
}
