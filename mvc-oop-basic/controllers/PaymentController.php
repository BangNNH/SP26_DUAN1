<?php
// Gọi Model để sử dụng
require_once './models/DonHang.php';
require_once './models/PaymentModel.php';
require_once './models/GioHang.php';
require_once './models/SanPham.php';

class PaymentController
{
    private $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    private $partnerCode = 'MOMOBKUN20180529';
    private $accessKey = 'klm05TvNBzhg7h7j';
    private $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    /**
     * Kiểm tra tồn kho trước khi thanh toán
     * @param array $itemsToCheckout - Danh sách sản phẩm cần thanh toán
     * @return array ['status' => true/false, 'errors' => ['lỗi1', 'lỗi2', ...]]
     */
    private function validateStockBeforePayment($itemsToCheckout)
    {
        $errors = [];
        $sanPhamModel = new SanPham();

        if (empty($itemsToCheckout)) {
            $errors[] = 'Không có sản phẩm nào để thanh toán.';
            return ['status' => false, 'errors' => $errors];
        }

        // Kiểm tra từng sản phẩm trong danh sách (từ Giỏ hàng hoặc Mua ngay)
        foreach ($itemsToCheckout as $item) {
            $checkResult = $sanPhamModel->checkStock($item['san_pham_id'], $item['so_luong']);

            if (!$checkResult['status']) {
                $errors[] = $checkResult['message'];
            }
        }

        if (!empty($errors)) {
            return ['status' => false, 'errors' => $errors];
        }

        return ['status' => true, 'errors' => []];
    }

    public function momo_payment()
    {
        // 1. Lấy thông tin chung của đơn hàng
        $amount_raw = $_POST['total_momo'] ?? 0;
        $tong_tien = (string)intval($amount_raw); 

        $tai_khoan_id = $_SESSION['user_client']['id'] ?? null; 
        $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'] ?? 'Khách lẻ';
        $email_nguoi_nhan = $_POST['email_nguoi_nhan'] ?? '';
        $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'] ?? '';
        $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'] ?? '';
        $ghi_chu = $_POST['ghi_chu'] ?? '';
        
        $phuong_thuc_thanh_toan_id = 3; // 3 là MoMo
        $trang_thai_id = 1; 
        $ngay_dat = date('Y-m-d H:i:s'); 
        $ma_don_hang = 'DH' . time(); 

        // 2. Phân loại nguồn dữ liệu sản phẩm (Giỏ hàng vs Mua ngay)
        $itemsToCheckout = [];
        $gioHangModel = new GioHang();
        $gioHang = null;
        
        // Kiểm tra cờ 'is_mua_ngay' từ form gửi lên
        $is_mua_ngay = isset($_POST['is_mua_ngay']) && $_POST['is_mua_ngay'] == 1;

        if ($is_mua_ngay) {
            // Lấy dữ liệu 1 sản phẩm trực tiếp từ form POST
            $itemsToCheckout[] = [
                'san_pham_id' => $_POST['san_pham_id'],
                'so_luong' => $_POST['so_luong'],
                'gia_khuyen_mai' => $_POST['gia_san_pham'], // Dùng giá từ form gửi sang
                'gia_san_pham' => $_POST['gia_san_pham'],
                'ten_san_pham' => $_POST['ten_san_pham'] ?? 'Sản phẩm mua ngay'
            ];
        } else {
            // Lấy toàn bộ sản phẩm từ Giỏ Hàng
            $gioHang = $gioHangModel->getGioHangFromUser($tai_khoan_id);
            if ($gioHang) {
                $itemsToCheckout = $gioHangModel->getDetailGioHang($gioHang['id']);
            }
        }

        // 3. Validate tồn kho trước khi lưu DB
        $stockValidation = $this->validateStockBeforePayment($itemsToCheckout);

        if (!$stockValidation['status']) {
            // Có lỗi tồn kho -> Quay lại báo lỗi
            $_SESSION['errors'] = $stockValidation['errors'];
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL . '?act=thanh-toan&status=stock-error');
            exit();
        }

        // 4. Lưu thông tin đơn hàng gốc vào DB
        $donHangModel = new DonHang();
        $realOrderId = $donHangModel->addDonHang(
            $tai_khoan_id,
            $ten_nguoi_nhan,
            $email_nguoi_nhan,
            $sdt_nguoi_nhan,
            $dia_chi_nguoi_nhan,
            $ghi_chu,
            $tong_tien,
            $phuong_thuc_thanh_toan_id,
            $ngay_dat,
            $trang_thai_id,
            $ma_don_hang
        );

        if ($realOrderId) {
            // 5. Lưu chi tiết đơn hàng (Đã xóa tên sản phẩm)
            foreach ($itemsToCheckout as $sanPham) {
                $donGia = $sanPham['gia_khuyen_mai'] ?: $sanPham['gia_san_pham'];
                $thanhTien = $donGia * $sanPham['so_luong'];

                $donHangModel->addChiTietDonHang(
                    $realOrderId,
                    $sanPham['san_pham_id'], 
                    $donGia,
                    $sanPham['so_luong'],
                    $thanhTien
                );
            }
                    
            // 6. Xóa chi tiết giỏ hàng (Chỉ xóa nếu thanh toán từ giỏ hàng)
            if (!$is_mua_ngay && $gioHang) {
                $gioHangModel->clearDetailGioHang($gioHang['id']); 
            }

            // 7. Cấu hình và gọi API MoMo
            $orderId = $realOrderId . "_" . time(); 
            $orderInfo = "Thanh toan don hang MoMo";
            $requestId = (string)time();
            $requestType = "payWithATM";
            $extraData = "";
            
            $redirectUrl = BASE_URL . "?act=payment-callback";
            $ipnUrl = BASE_URL . "?act=payment-callback";

            // Tạo chuỗi mã hóa CHUẨN THỨ TỰ cho MoMo
            $rawHash = "accessKey=" . $this->accessKey . 
                       "&amount=" . $tong_tien . 
                       "&extraData=" . $extraData . 
                       "&ipnUrl=" . $ipnUrl . 
                       "&orderId=" . $orderId . 
                       "&orderInfo=" . $orderInfo . 
                       "&partnerCode=" . $this->partnerCode . 
                       "&redirectUrl=" . $redirectUrl . 
                       "&requestId=" . $requestId . 
                       "&requestType=" . $requestType;

            $signature = hash_hmac("sha256", $rawHash, $this->secretKey);

            $data = [
                'partnerCode' => $this->partnerCode,
                'partnerName' => "Test Store",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $tong_tien,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            ];

            $result = $this->execPostRequest($this->endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);

            if (isset($jsonResult['payUrl'])) {
                header('Location: ' . $jsonResult['payUrl']);
                exit();
            } else {
                echo "Lỗi từ API MoMo: " . ($jsonResult['message'] ?? 'Unknown');
                echo "<br>Mã lỗi: " . ($jsonResult['resultCode'] ?? 'N/A');
                echo "<br>Vui lòng F5 lại trang.";
            }
        } else {
            echo "Lỗi truy vấn Database: Không thể lưu đơn hàng. Hãy kiểm tra các trường bắt buộc trong hàm addDonHang.";
        }
    }

    public function callback() {
        // Nhận dữ liệu MoMo trả về
        $resultCode = $_GET['resultCode'] ?? -1;
        $momoOrderId = $_GET['orderId'] ?? ''; // Chuỗi nhận về có dạng: 15_1712000123
        $amount = $_GET['amount'] ?? 0;
        $transId = $_GET['transId'] ?? null; 
        $message = $_GET['message'] ?? '';

        // Tách chuỗi để lấy lại ID thật của đơn hàng trong database
        $orderIdParts = explode('_', $momoOrderId);
        $orderId = $orderIdParts[0]; 

        $paymentModel = new PaymentModel();
        $donHangModel = new DonHang();
        $sanPhamModel = new SanPham();

        if ($resultCode == 0) {
            // Thanh toán thành công -> Đổi trạng thái đơn hàng
            $paymentModel->updatePaymentStatus($orderId, 2);
            $paymentModel->insertPaymentHistory($orderId, $transId, $amount, $message);
            
            // Lấy chi tiết đơn hàng để trừ tồn kho
            $chiTietDonHang = $donHangModel->getChiTietDonHangByDonHangId($orderId);
            
            if ($chiTietDonHang) {
                foreach ($chiTietDonHang as $item) {
                    // Giảm tồn kho cho mỗi sản phẩm
                    $sanPhamModel->decreaseStock($item['san_pham_id'], $item['so_luong']);
                }
            }
            
            // Xóa session giỏ hàng nếu bạn đang dùng Session lưu giỏ hàng
            if (isset($_SESSION['cart'])) {
                unset($_SESSION['cart']); 
            }
            
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang&status=success');
        } else {
            // Thanh toán thất bại hoặc người dùng tự hủy giao dịch
            $paymentModel->insertPaymentHistory($orderId, $transId, $amount, "That bai: " . $message);
            header('Location: ' . BASE_URL . '?act=thanh-toan&status=error');
        }
        exit();
    }

    protected function execPostRequest($url, $data) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}