<?php
session_start();
// Kết nối CSDL qua PDO
function connectDB()
{
    // Kết nối CSDL
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

        // cài đặt chế độ báo lỗi là xử lý ngoại lệ
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // cài đặt chế độ trả dữ liệu
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $conn;
    } catch (PDOException $e) {
        echo ("Connection failed: " . $e->getMessage());
    }
}

// Thêm file
function uploadFile($file, $folderUpload)
{
    if (empty($file) || !isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $filename = basename($file['name'] ?? '');
    if (empty($filename)) {
        return null;
    }

    // Chuẩn hóa folderUpload không có ./
    $folderUpload = ltrim($folderUpload, './');
    if (!str_ends_with($folderUpload, '/')) {
        $folderUpload .= '/';
    }

    $pathStorage = $folderUpload . time() . '-' . $filename;
    $to = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($file['tmp_name'], $to)) {
        return $pathStorage;
    }

    return null;
}

// Xóa file
function deleteFile($file)
{
    $pathDelete = PATH_ROOT . $file;

    if (file_exists($pathDelete)) {
        unlink($pathDelete);
    }
}
// Debug
function debug($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die();
}

// Xóa session sau khi load trang
function deleteSessionError()
{
    // Hủy session lỗi/success sau khi đã tải trang
    unset($_SESSION['errors']);
    unset($_SESSION['error']);
    unset($_SESSION['success']);
    unset($_SESSION['flash']);
    // Xóa các lỗi validation cụ thể
    unset($_SESSION['error_email']);
    unset($_SESSION['error_password']);
    unset($_SESSION['error_password_confirmation']);
    unset($_SESSION['old_email']);
}

// upload - update album ảnh 
function uploadFileAlbum($file, $folderUpload, $key)
{
    $pathStorage = $folderUpload . time() . $file['name'][$key];

    $from = $file['tmp_name'][$key];
    $to = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($from, $to)) {
        return $pathStorage;
    }
    return null;
}
//format date 
function formatDate($date)
{
    return date("d-m-Y", strtotime($date));
}

function checkLoginAdmin()
{
    if (!isset($_SESSION['user_admin'])) { // Không có session thì redirect về trang login
        require_once './views/auth/formLogin.php';
        exit();
    }
}

function formatPrice($price)
{
    if ($price === null || $price === '') {
        $price = 0;
    }
    return number_format((float)$price, 0, ',', '.');
}


function getCartCount()
{
    $count = 0;
    if (isset($_SESSION['user_client'])) {
        $count = 5;
    } else {
        $cart = getCartFromSession();
        foreach ($cart as $item) {
            $count += $item['so_luong'];
        }
    }
    return $count;
}

function getCartFromSession()
{
    $cart = $_SESSION['cart'] ?? [];
    $result = [];
    foreach ($cart as $id => $item) {
        $sp = getProductById($id);
        if ($sp) {
            $result[] = [
                'san_pham_id' => $id,
                'id' => $id,
                'ten_san_pham' => $sp['ten_san_pham'],
                'gia_san_pham' => $sp['gia_san_pham'],
                'gia_khuyen_mai' => $sp['gia_khuyen_mai'],
                'so_luong' => $item['so_luong'],
                'hinh_anh' => $sp['hinh_anh'],
            ];
        }
    }
    return $result;
}

function getProductById($id)
{
    $conn = connectDB();

    $sql = "SELECT * FROM san_phams WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);

    return $stmt->fetch();
}

function getCartDBCount()
{
    require_once './models/GioHang.php';

    $gioHangModel = new GioHang();

    if (isset($_SESSION['user_client'])) {
        return $gioHangModel->getTotalQuantity($_SESSION['user_client']['id']);
    }

    return array_sum(array_column($_SESSION['cart'] ?? [], 'quantity'));
}
