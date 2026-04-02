<?php

class PaymentController
{
    private $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    private $partnerCode = 'MOMOBKUN20180529';
    private $accessKey = 'klm05TvNBzhg7h7j';
    private $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    public function momo_payment()
{
    // 1. Lấy số tiền và ép kiểu chuẩn (không dấu phẩy, không số lẻ)
    $amount = $_POST['total_momo'] ?? 0;
    $amount = (string)intval($amount);

    // 2. XỬ LÝ ORDER ID: Đảm bảo không bao giờ bị rỗng
    // Nếu $_POST['order_id_real'] rỗng, ta dùng time() để tạo mã đơn hàng tạm thời
    $rawOrderId = $_POST['order_id_real'] ?? "";
    if (empty($rawOrderId)) {
        $orderId = "DH" . time(); // Ví dụ: DH1712001234
    } else {
        $orderId = (string)$rawOrderId;
    }
    
    // 3. Thông tin khác (KHÔNG DẤU TIẾNG VIỆT)
    $orderInfo = "Thanh toan don hang MoMo";
    $requestId = (string)time();
    $requestType = "payWithATM";
    $extraData = "";
    
    $redirectUrl = BASE_URL . "?act=payment-callback";
    $ipnUrl = BASE_URL . "?act=payment-callback";

    // 4. Chuỗi rawHash (Giữ nguyên thứ tự chuẩn MoMo V2)
    $rawHash = "accessKey=" . $this->accessKey . 
               "&amount=" . $amount . 
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
        'amount' => $amount,
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
    }

    echo "Lỗi từ MoMo: " . ($jsonResult['message'] ?? 'Unknown Error');
    echo "<br>Chi tiết JSON: " . $result;
}

    public function callback() {
        $resultCode = $_GET['resultCode'] ?? -1;
        $orderId = $_GET['orderId'] ?? null;
        $amount = $_GET['amount'] ?? 0;
        $transId = $_GET['transId'] ?? null; 
        $message = $_GET['message'] ?? '';

        $paymentModel = new PaymentModel();

        if ($resultCode == 0) {
            $paymentModel->updatePaymentStatus($orderId, 2);
            $paymentModel->insertPaymentHistory($orderId, $transId, $amount, $message);
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang&status=success');
        } else {
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