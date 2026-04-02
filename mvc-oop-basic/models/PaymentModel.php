<?php

class PaymentModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB(); 
    }

    // Cập nhật trạng thái đơn hàng
    public function updatePaymentStatus($orderId, $statusId) {
        try {
            $sql = "UPDATE don_hangs 
                    SET phuong_thuc_thanh_toan_id = 3, -- ID của MoMo bạn vừa thêm
                        trang_thai_id = :statusId 
                    WHERE id = :orderId";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':statusId' => $statusId,
                ':orderId' => $orderId
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Lưu vết vào bảng lich_su_thanh_toan mới thêm
    public function insertPaymentHistory($orderId, $transId, $amount, $message) {
        try {
            $sql = "INSERT INTO lich_su_thanh_toan (don_hang_id, ma_giao_dich_momo, so_tien, loai_thanh_toan, noi_dung) 
                    VALUES (:orderId, :transId, :amount, 'MOMO', :message)";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':orderId' => $orderId,
                ':transId' => $transId,
                ':amount' => $amount,
                ':message' => $message
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}