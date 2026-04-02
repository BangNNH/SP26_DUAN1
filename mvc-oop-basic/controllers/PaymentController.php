<?php
// Gọi Model để sử dụng
require_once './models/DonHang.php';
require_once './models/PaymentModel.php';
require_once './models/GioHang.php'; // Đã bổ sung gọi Model GioHang

class PaymentController
{
    private $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    private $partnerCode = 'MOMOBKUN20180529';
    private $accessKey = 'klm05TvNBzhg7h7j';
    private $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    public function momo_payment()
    {
        // ========================================================
        // BƯỚC 1: NHẬN DỮ LIỆU TỪ FORM ẨN VÀ CHUẨN BỊ LƯU DB
        // ========================================================
        $amount_raw = $_POST['total_momo'] ?? 0;
        $tong_tien = (string)intval($amount_raw); 

        // Lấy thông tin khách hàng từ Form ẩn (JS đã copy qua)
        $tai_khoan_id = $_SESSION['user_client']['id'] ?? null; 
        $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'] ?? 'Khách lẻ';
        $email_nguoi_nhan = $_POST['email_nguoi_nhan'] ?? '';
        $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'] ?? '';
        $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'] ?? '';
        $ghi_chu = $_POST['ghi_chu'] ?? '';
        
        $phuong_thuc_thanh_toan_id = 3; // 3 là ID MoMo của bạn
        $trang_thai_id = 1; // 1: Chờ thanh toán
        $ngay_dat = date('Y-m-d H:i:s'); // Thời gian hiện tại
        $ma_don_hang = 'DH' . time(); // Sinh mã đơn hàng ngẫu nhiên (VD: DH1712000)

        // ========================================================
        // BƯỚC 2: GỌI MODEL LƯU VỎ ĐƠN HÀNG VÀO DATABASE
        // ========================================================
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

        // ========================================================
        // BƯỚC 2.5: LƯU CHI TIẾT SẢN PHẨM VÀO ĐƠN HÀNG
        // ========================================================
        if ($realOrderId) {
            $gioHangModel = new GioHang();
            
            // 1. Lấy thông tin giỏ hàng của user hiện tại
            $gioHang = $gioHangModel->getGioHangFromUser($tai_khoan_id);

            if ($gioHang) {
                // 2. Lấy danh sách sản phẩm dựa vào ID giỏ hàng
                $chiTietGioHang = $gioHangModel->getDetailGioHang($gioHang['id']);

                if ($chiTietGioHang) {
                    foreach ($chiTietGioHang as $sanPham) {
                        $donGia = $sanPham['gia_khuyen_mai'] ?: $sanPham['gia_san_pham'];
                        $thanhTien = $donGia * $sanPham['so_luong'];

                        // Insert từng sản phẩm vào bảng chi_tiet_don_hangs
                        $donHangModel->addChiTietDonHang(
                            $realOrderId,
                            $sanPham['san_pham_id'], 
                            $donGia,
                            $sanPham['so_luong'],
                            $thanhTien
                        );
                    }
                    
                    // 3. Xóa chi tiết giỏ hàng sau khi mua thành công
                    // Mình thấy bạn có viết sẵn hàm clearDetailGioHang rồi này!
                    // $gioHangModel->clearDetailGioHang($gioHang['id']); 
                }
            }

            // ========================================================
            // BƯỚC 3: TẠO CHỮ KÝ VÀ CHUYỂN HƯỚNG SANG MOMO
            // ========================================================
            // FIX LỖI 41: Thêm time() vào phía sau ID thật để tạo ra 1 chuỗi hoàn toàn độc nhất
            $orderId = $realOrderId . "_" . time(); 
            
            $orderInfo = "Thanh toan don hang MoMo";
            $requestId = (string)time();
            $requestType = "payWithATM";
            $extraData = "";
            
            $redirectUrl = BASE_URL . "?act=payment-callback";
            $ipnUrl = BASE_URL . "?act=payment-callback";

            // Tạo chuỗi mã hóa CHUẨN THỨ TỰ
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

        // FIX LỖI 41: Tách chuỗi để lấy lại ID thật của đơn hàng (vd: số 15)
        $orderIdParts = explode('_', $momoOrderId);
        $orderId = $orderIdParts[0]; 

        $paymentModel = new PaymentModel();

        if ($resultCode == 0) {
            // Thanh toán thành công -> Đổi trạng thái đơn hàng
            $paymentModel->updatePaymentStatus($orderId, 2);
            $paymentModel->insertPaymentHistory($orderId, $transId, $amount, $message);
            
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