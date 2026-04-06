<?php

require_once './models/AdminBaoCaoThongKe.php';

class AdminBaoCaoThongKeController
{
    public $modelBaoCaoThongKe;

    public function __construct()
    {
        $this->modelBaoCaoThongKe = new AdminBaoCaoThongKe();
    }

    public function home()
    {
        //lấy doanh số theo ngày

        $data = $this->modelBaoCaoThongKe->getDoanhThuHomNayVaHomQua();
        $topUsers = $this->modelBaoCaoThongKe->getTopUsers();
        $homNay = 0;
        $homQua = 0;

        //tính phần trăm doanh thu ngày
        foreach ($data as $item) {
            if ($item['ngay'] == date('Y-m-d')) {
                $homNay = $item['doanh_thu'];
            } else {
                $homQua = $item['doanh_thu'];
            }
        }

        // Tính %
        $phanTram = 0;
        if ($homQua > 0) {
            $phanTram = (($homNay - $homQua) / $homQua) * 100;
        }

        //tính phần trăm doanh thu tuần
        $data = $this->modelBaoCaoThongKe->getDoanhThu2Tuan();

        $tuanNay = 0;
        $tuanTruoc = 0;

        $currentWeek = date('oW');
        $lastWeek = date('oW', strtotime('-1 week'));

        foreach ($data as $item) {
            if ($item['tuan'] == $currentWeek) {
                $tuanNay = $item['doanh_thu'];
            } elseif ($item['tuan'] == $lastWeek) {
                $tuanTruoc = $item['doanh_thu'];
            }
        }
        // tính %
        $phanTramTuan = 0;
        if ($tuanTruoc > 0) {
            $phanTramTuan = (($tuanNay - $tuanTruoc) / $tuanTruoc) * 100;
        }

        // lấy đơn hàng mới theo ngày
        $dataDonMoi = $this->modelBaoCaoThongKe->getDonMoiHomNayVaHomQua();

        $homNayDon = 0;
        $homQuaDon = 0;

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        foreach ($dataDonMoi as $item) {
            if ($item['ngay'] == $today) {
                $homNayDon = $item['tong_don_moi'];
            } elseif ($item['ngay'] == $yesterday) {
                $homQuaDon = $item['tong_don_moi'];
            }
        }

        // tính %
        $phanTramDon = 0;
        if ($homQuaDon > 0) {
            $phanTramDon = (($homNayDon - $homQuaDon) / $homQuaDon) * 100;
        }

        // tính tỉ lệ nhận hàng
        $dataTyLe = $this->modelBaoCaoThongKe->getTyLeDonHang();

        $tongDon = $dataTyLe['tong_don'] ?? 0;

        $canceled = $dataTyLe['canceled'] ?? 0;


        $fulfilled = $dataTyLe['fulfilled'] ?? 0;
        $processing = $dataTyLe['processing'] ?? 0;
        $delayed = $dataTyLe['delayed'] ?? 0;

        // tránh chia 0
        $percentFulfilled = $tongDon > 0 ? ($fulfilled / $tongDon) * 100 : 0;
        $percentProcessing = $tongDon > 0 ? ($processing / $tongDon) * 100 : 0;
        $percentDelayed = $tongDon > 0 ? ($delayed / $tongDon) * 100 : 0;
        $percentCanceled = $tongDon > 0 ? ($canceled / $tongDon) * 100 : 0;

        // tổng hiển thị giữa (ví dụ lấy fulfilled)
        $percentMain = round($percentFulfilled);

        // hiển thị top đơ hàng bán chạy nhất
        $topProducts = $this->modelBaoCaoThongKe->getTopSanPham();

        // tìm max để scale %
        $maxQuantity = max(array_column($topProducts, 'total_quantity') ?: [0]);
        $maxRevenue = max(array_column($topProducts, 'total_revenue') ?: [0]);

        //controller truyền dữ liệu sang js
        $data7Ngay = $this->modelBaoCaoThongKe->getDoanhThuTuan();
        $data12Thang = $this->modelBaoCaoThongKe->getDoanhThu12Thang();

        // tính toán lượng tài khoản đăng ký mới theo ngày
        $dataTaiKhoanMoi = $this->modelBaoCaoThongKe->getTaiKhoanMoiHomNayVaHomQua();

        $homNayTaiKhoan = 0;
        $homQuaTaiKhoan = 0;

        foreach ($dataTaiKhoanMoi as $item) {
            if ($item['ngay'] == date('Y-m-d')) {
                $homNayTaiKhoan = $item['tong_tai_khoan_moi'];
            } else {
                $homQuaTaiKhoan = $item['tong_tai_khoan_moi'];
            }
        }
        // tính % tài khoản mới
        $phanTramTaiKhoan = 0;
        if ($homQuaTaiKhoan > 0) {
            $phanTramTaiKhoan = (($homNayTaiKhoan - $homQuaTaiKhoan) / $homQuaTaiKhoan) * 100;
        }

        require_once './views/home.php';
    }
    public function filter()
    {
        $from = $_GET['from'] ?? '';
        $to = $_GET['to'] ?? '';

        if (!$from || !$to) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Thiếu ngày']);
            exit;
        }

        $thongKe = $this->modelBaoCaoThongKe->getThongKeTheoKhoangThoiGian($from, $to);
        $taiKhoan = $this->modelBaoCaoThongKe->getTaiKhoanMoiTheoKhoang($from, $to);
        $topProducts = $this->modelBaoCaoThongKe->getTopSanPhamTheoKhoang($from, $to);
        $topUsers = $this->modelBaoCaoThongKe->getTopUsersTheoKhoang($from, $to);

        $result = [
            'doanh_thu' => $thongKe['doanh_thu'] ?? 0,
            'don_moi' => $thongKe['don_moi'] ?? 0,
            'tai_khoan' => $taiKhoan['tai_khoan'] ?? 0,
            'top_products' => $topProducts,
            'top_users' => $topUsers,
        ];


        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}

?>