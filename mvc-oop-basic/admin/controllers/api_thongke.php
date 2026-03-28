<?php
require_once './models/AdminBaoCaoThongKe.php';

$model = new AdminBaoCaoThongKe();

$type = $_GET['type'] ?? 'day';

switch ($type) {
    case 'week':
        $data = $model->getTheoTuan();
        break;
    case 'month':
        $data = $model->getTheoThang();
        break;
    default:
        $data = $model->getTheoNgay();
}

echo json_encode($data);