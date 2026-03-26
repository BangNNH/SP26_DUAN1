<?php

class CartController
{
    public $modelTaiKhoan;
    public $modelGioHang;


    public function __construct()
    {
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
    }

    public function addGioHang()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $san_pham_id = $_POST['san_pham_id'] ?? 0;
            $so_luong = $_POST['so_luong'] ?? 1;

            if (isset($_SESSION['user_client'])) {
                // LUỒNG DB khi user đã login
                $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);

                $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);

                if (!$gioHang) {
                    $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                    $gioHang = ['id' => $gioHangId];
                }

                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

                $checkSanPham = false;

                foreach ($chiTietGioHang as $detail) {
                    if ($detail['san_pham_id'] == $san_pham_id) {
                        $newSoLuong = $detail['so_luong'] + $so_luong;
                        $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
                        $checkSanPham = true;
                        break;
                    }
                }

                if (!$checkSanPham) {
                    $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);
                }
                header("Location: " . BASE_URL . '?act=gio-hang');
                exit();
            } else {
                // LUỒNG SESSION khi user chưa login
                $_SESSION['openCart'] = true;
                $this->addToCartSession($san_pham_id, $so_luong);
                header("Location: " . ($_SERVER['HTTP_REFERER'] ?? BASE_URL));
                exit();
            }
        }
    }

    function addToCartSession($san_pham_id, $so_luong)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$san_pham_id])) {
            $_SESSION['cart'][$san_pham_id]['so_luong'] += $so_luong;
        } else {
            $_SESSION['cart'][$san_pham_id] = [
                'so_luong' => $so_luong
            ];
        }
    }


    public function gioHang()
    {
        if (isset($_SESSION['user_client'])) {
            // LUỒNG DB
            unset($_SESSION['cart']);
            $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);

            $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);

            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                $gioHang = ['id' => $gioHangId];
            }

            $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        } else {
            // LUỒNG SESSION 
            // $_SESSION['openCart'] = true;
            $chiTietGioHang = getCartFromSession();
        }

        require_once './views/gioHang.php';
    }
}
