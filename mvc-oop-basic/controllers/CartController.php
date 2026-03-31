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
                $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);

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
        // debug($_SESSION['cart']);
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$san_pham_id])) {
            $_SESSION['cart'][$san_pham_id]['so_luong'] += 1;
        } else {
            $_SESSION['cart'][$san_pham_id] = [
                'so_luong' => $so_luong
            ];
        }
        $cart = getCartFromSession();
        $this->calculateCartSession($cart);
    }

    public function calculateCartSession($cart)
    {
        $tamTinh = 0;
        $giamGia = 0;

        if (!empty($cart)) {
            foreach ($cart as $item) {
                $tamTinh += $item['gia_san_pham'] * $item['so_luong'];
                $giamGia += ($item['gia_san_pham'] - $item['gia_khuyen_mai']) * $item['so_luong'];
            }
        }
        $_SESSION['tamTinh'] = $tamTinh;
        $_SESSION['giamGia'] = $giamGia;
        $_SESSION['thanhToan'] = $tamTinh - $giamGia;
        $totalQuantity = 0;

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                if (!is_array($item)) continue;
                $totalQuantity += $item['so_luong'];
            }
        }
        $_SESSION['tong_so_luong'] = $totalQuantity;

        return [
            'tamTinh' =>  $tamTinh,
            'giamGia' => $giamGia,
            'thanhToan' => $tamTinh - $giamGia,
            'totalQuantity' => $totalQuantity
        ];
    }

    public function ajaxCartSession()
    {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data['san_pham_id'];
        $action = $data['action'];

        if (!isset($_SESSION['cart'][$id])) {
            echo json_encode(['success' => false]);
            exit;
        }

        if ($action === 'increase') {
            $_SESSION['cart'][$id]['so_luong']++;
        }

        if ($action === 'decrease') {
            $_SESSION['cart'][$id]['so_luong']--;
            if ($_SESSION['cart'][$id]['so_luong'] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }

        if ($action === 'delete') {
            unset($_SESSION['cart'][$id]);
        }

        $cart = getCartFromSession();
        $result = $this->calculateCartSession($cart);
        $isEmpty = empty($cart);

        echo json_encode([
            'success' => true,
            'id' => $id,
            'so_luong' => $_SESSION['cart'][$id]['so_luong'] ?? 0,
            'tamTinh' => $result['tamTinh'],
            'giamGia' => $result['giamGia'],
            'thanhToan' => $result['thanhToan'],
            'isEmpty' => $isEmpty,
            'totalQuantity' => $result['totalQuantity']
        ]);
        exit;
    }

    public function gioHang()
    {
        if (isset($_SESSION['user_client'])) {
            // LUỒNG DB
            // unset($_SESSION['cart']);
            $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);

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

    public function updateCartItem()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = $_POST['action'];
            $san_pham_id = $_POST['san_pham_id'];
            $so_luong_hien_tai = $_POST['so_luong_hien_tai'];
            $tai_khoan_id = $_SESSION['user_client']['id'];

            if ($action == 'increase') {
                $this->modelGioHang->increaseQuantity($tai_khoan_id, $san_pham_id);
            } elseif ($action == 'decrease') {
                $this->modelGioHang->decreaseQuantity($tai_khoan_id, $san_pham_id, $so_luong_hien_tai);
            }

            header("Location: " . BASE_URL . "?act=gio-hang");
            // exit();
        }
    }

    public function deleteCartItem()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $san_pham_id = $_POST['san_pham_id'];
            $tai_khoan_id = $_SESSION['user_client']['id'];

            $this->modelGioHang->deleteItem($tai_khoan_id, $san_pham_id);

            header("Location: " . BASE_URL . "?act=gio-hang");
            exit();
        }
    }
}
