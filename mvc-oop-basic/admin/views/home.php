<!--////////////////// Header //////////////////-->
<?php include './views/layout/header.php' ?>
<!--//////////////////End Header //////////////////-->

<!--////////////////// Navbar //////////////////-->
<?php include './views/layout/navbar.php' ?>
<!--//////////////////End Navbar //////////////////-->

<!--////////////////// main sidebar container //////////////////-->
<?php include './views/layout/sidebar.php' ?>
<!--//////////////////End sidebar //////////////////-->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-fluid p-2" id="mainDashboard">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <!-- Lọc theo ngày -->
            <button class="btn btn-primary-executive d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#dateFilterModal">
                <span class="material-symbols-outlined">
                    calendar_month
                </span>
                Lọc theo ngày
            </button>
            <!-- popup lọc dashboard -->
            <div class="modal fade" id="dateFilterModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Lọc theo ngày</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Từ ngày</label>
                                <input type="date" class="form-control" id="dateFrom">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Đến ngày</label>
                                <input type="date" class="form-control" id="dateTo">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="todayBtn">Hôm nay</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary-executive" id="filterBtn">Lọc</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Summary Cards -->
        <div class="row g-3 mb-3">
            <!-- doanh thu theo ngày -->
            <?php
            $isTang = $phanTram >= 0;
            $class = $isTang ? 'bg-red-light' : 'bg-slate-light';
            $icon = $isTang ? '+' : '';
            ?>

            <div class="col-md-3">
                <div class="card p-4 stat-card active">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-red-light">
                            <span class="material-symbols-outlined">payments</span>
                        </div>

                        <!-- % tăng giảm -->
                        <span class="badge-stat <?= $class ?>">
                            <?= $icon . round($phanTram, 1) ?>%
                        </span>
                    </div>

                    <p class="text-secondary fw-bold text-uppercase mb-1">
                        Thống kê theo ngày
                    </p>

                    <h4 class="fw-black mb-0">
                        <?= number_format($homNay) ?> đ
                    </h4>
                </div>
            </div>
            <!-- doanh thu theo tuần -->
            <?php
            $isTang = $phanTramTuan >= 0;
            $class = $isTang ? 'bg-red-light' : 'bg-slate-light';
            $icon = $isTang ? '+' : '';
            ?>

            <div class="col-md-3">
                <div class="card p-4 stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-red-light">
                            <span class="material-symbols-outlined">calendar_month</span>
                        </div>

                        <!-- % tăng giảm -->
                        <span class="badge-stat <?= $class ?>">
                            <?= $icon . round($phanTramTuan, 1) ?>%
                        </span>
                    </div>

                    <p class="text-secondary fw-bold text-uppercase mb-1">
                        Thống kê theo tuần
                    </p>

                    <h4 class="fw-black mb-0">
                        <?= number_format($tuanNay) ?> đ
                    </h4>
                </div>
            </div>
            <!-- đơn hàng theo ngày -->
            <?php
            $isTang = $phanTramDon >= 0;
            $class = $isTang ? 'bg-red-light' : 'bg-slate-light';
            $icon = $isTang ? '+' : '';
            ?>

            <div class="col-md-3">
                <div class="card p-4 stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-red-light">
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </div>

                        <span class="badge-stat <?= $class ?>">
                            <?= $icon . round($phanTramDon, 1) ?>%
                        </span>
                    </div>

                    <p class="text-secondary fw-bold text-uppercase mb-1">
                        Đơn hàng mới
                    </p>

                    <h4 class="fw-black mb-0">
                        <?= $homNayDon ?> đơn
                    </h4>
                </div>
            </div>
            <?php
            $isTang = $phanTramTaiKhoan >= 0;
            $class = $isTang ? 'bg-red-light' : 'bg-slate-light';
            $icon = $isTang ? '+' : '';
            ?>

            <div class="col-md-3">
                <div class="card p-4 stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-slate-light">
                            <span class="material-symbols-outlined">person_add</span>
                        </div>
                        <span class="badge-stat <?= $class ?>">
                            <?= $icon . round($phanTramTaiKhoan, 1) ?>%
                        </span>
                    </div>
                    <p class="text-secondary fw-bold text-uppercase mb-1"
                        style="font-size: 10px; letter-spacing: 0.05em">
                        Tài khoản mới
                    </p>
                    <h4 class="fw-black mb-0"><?= $homNayTaiKhoan ?? 0 ?> tài khoản</h4>
                </div>
            </div>
        </div>
        <!-- Doanh thu theo thời gian  -->
        <div class="row g-4 mb-5">
            <!-- Line Chart Card -->
            <div class="col-lg-8">
                <div class="card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-0">Thống kê thu nhập</h5>
                            <p class="text-muted small mb-0">Doanh thu theo thời gian</p>
                        </div>

                        <!-- BUTTON -->
                        <div class="btn-group btn-group-sm chart-filter">
                            <button class="btn active bg-red-light px-3" data-type="day">Ngày</button>
                            <button class="btn px-3 bg-red-light px-3" data-type="week">Tuần</button>
                            <button class="btn px-3 bg-red-light px-3" data-type="month">Tháng</button>
                        </div>
                    </div>

                    <!-- CHART -->
                    <div class="chart-container">
                        <svg class="w-100 h-100" preserveAspectRatio="none" viewBox="0 0 100 40">

                            <!-- GRID -->
                            <line x1="0" x2="100" y1="10" y2="10" stroke="#f1f5f9" stroke-width="0.2"></line>
                            <line x1="0" x2="100" y1="20" y2="20" stroke="#f1f5f9" stroke-width="0.2"></line>
                            <line x1="0" x2="100" y1="30" y2="30" stroke="#f1f5f9" stroke-width="0.2"></line>
                            <line x1="0" x2="100" y1="40" y2="40" stroke="#f1f5f9" stroke-width="0.2"></line>

                            <!-- AREA -->
                            <path class="area-chart" d="M0,40 L100,40 Z" fill="rgba(183, 0, 17, 0.05)">
                            </path>

                            <!-- LINE -->
                            <path class="line-chart" d="M0,30 L100,30" fill="none" stroke="#b70011" stroke-width="0.5">
                            </path>
                        </svg>
                    </div>

                    <!-- LABEL -->
                    <div class="chart-labels d-flex justify-content-between text-muted fw-bold mt-3"
                        style="font-size: 10px">
                        <!-- JS sẽ render -->
                    </div>
                </div>
            </div>

            <!-- tỉ lệ giao hàng thành công -->
            <div class="col-lg-4">
                <div class="card p-4 h-100">
                    <h5 class="fw-bold mb-0">Tỉ lệ nhận hàng</h5>
                    <p class="text-muted small mb-4">Tỷ lệ đơn hàng được giao thành công</p>

                    <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1">
                        <div class="position-relative d-flex align-items-center justify-content-center">

                            <svg class="donut-chart" viewBox="0 0 36 36">
                                <!-- nền -->
                                <circle cx="18" cy="18" r="16" fill="transparent" stroke="#f1f5f9" stroke-width="4">
                                </circle>

                                <!-- Fulfilled -->
                                <circle cx="18" cy="18" r="16" fill="transparent" stroke="#22c55e" stroke-width="4"
                                    stroke-dasharray="<?= $percentFulfilled ?> 100">
                                </circle>

                                <!-- Processing -->
                                <circle cx="18" cy="18" r="16" fill="transparent" stroke="#3b82f6" stroke-width="4"
                                    stroke-dasharray="<?= $percentProcessing ?> 100"
                                    stroke-dashoffset="-<?= $percentFulfilled ?>">
                                </circle>

                                <!-- Canceled -->
                                <circle cx="18" cy="18" r="16" fill="transparent" stroke="#ef4444" stroke-width="4"
                                    stroke-dasharray="<?= $percentCanceled ?> 100"
                                    stroke-dashoffset="-<?= ($percentFulfilled + $percentProcessing) ?>">
                                </circle>
                            </svg>

                            <!-- % ở giữa -->
                            <div class="position-absolute text-center">
                                <h3 class="fw-black mb-0"><?= round($percentFulfilled) ?>%</h3>
                                <p class="text-uppercase text-muted fw-bold mb-0" style="font-size: 10px">
                                    Tỉ lệ nhận hàng
                                </p>
                            </div>
                        </div>

                        <!-- legend -->
                        <div class="w-100 mt-5">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold">Thành Công</span>
                                <span class="small text-muted"><?= round($percentFulfilled) ?>%</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold">Đang Xử Lý</span>
                                <span class="small text-muted"><?= round($percentProcessing) ?>%</span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span class="small fw-bold">Đã Hủy</span>
                                <span class="small text-muted"><?= round($percentCanceled) ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- sản phẩm có doanh thu cao nhất và sản phẩm bán chạy nhất -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-0">Top sản phẩm bán chạy</h5>
                            <p class="text-muted small mb-0">
                                Top sản phẩm bán chạy nhất & doanh số cao nhất
                            </p>
                        </div>
                        <div class="d-flex gap-4">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 12px; height: 12px; background: #b70011"></div>
                                <span class="text-muted fw-bold text-uppercase" style="font-size: 10px">
                                    Số lượng
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 12px; height: 12px; background: #ffdad6"></div>
                                <span class="text-muted fw-bold text-uppercase" style="font-size: 10px">
                                    Doanh thu
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="vstack gap-4 top-products-container">

                        <?php foreach ($topProducts as $item):
                            $percentQty = $maxQuantity > 0 ? ($item['total_quantity'] / $maxQuantity) * 100 : 0;
                            $percentRevenue = $maxRevenue > 0 ? ($item['total_revenue'] / $maxRevenue) * 100 : 0;
                            ?>

                            <div class="product-item d-flex align-items-center gap-4">

                                <!-- LEFT -->
                                <div class="product-info">
                                    <div class="fw-bold small">
                                        <?= $item['ten_san_pham'] ?>
                                    </div>
                                    <div class="text-muted small">
                                        <?= $item['ten_danh_muc'] ?? 'N/A' ?>
                                    </div>
                                </div>

                                <!-- RIGHT -->
                                <div class="flex-grow-1">

                                    <!-- SỐ LƯỢNG -->
                                    <div class="progress-stack">
                                        <div class="progress-bar-qty" style="width: <?= $percentQty ?>%"
                                            title="<?= $item['total_quantity'] ?>">
                                        </div>
                                    </div>

                                    <!-- DOANH THU -->
                                    <div class=" progress-sub mt-2">
                                        <div class="progress-bar-revenue" style="width: <?= $percentRevenue ?>%"
                                            title="<?= number_format($item['total_revenue']) ?>đ">
                                        </div>
                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- thống kê sau khi lọc -->
    <div class="container-fluid p-2" id="filteredDashboard" style="display:none">
        <!-- Page Header -->
        <div class=" d-flex justify-content-between align-items-end mb-4">
            <button id="clearFilter" class="btn btn-primary-executive d-flex align-items-center gap-2">
                <span class="material-symbols-outlined">
                    arrow_back
                </span>
                Quay lại
            </button>
        </div>
        <div class="row g-4">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="custom-card metric-card-red d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-white bg-opacity-10 text-uppercase tracking-wider py-2 px-3">Tổng
                                doanh thu</span>
                            <h3 class="display-4 fw-bold mt-4 mb-1 doanh-thu">
                                <?= number_format($tongDoanhThu ?? 0) ?>
                            </h3>
                            <p class="text-white text-opacity-75 date-range">
                                Khoảng thời gian
                                <?= $from ?? '' ?> →
                                <?= $to ?? '' ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-card metric-card-light d-flex flex-column justify-content-between">
                        <div>
                            <div class="bg-white rounded-3 d-inline-flex p-2 mb-3 text-danger shadow-sm">
                                <span class="material-symbols-outlined">analytics</span>
                            </div>
                            <h4 class="h5 fw-bold mb-1">Đơn hàng mới</h4>
                            <p class="display-6 fw-bold mb-0 don-moi">
                                <?= $tongDonMoi ?? 0 ?>
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-card metric-card-light d-flex flex-column justify-content-between">
                        <div>
                            <div class="bg-danger bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3 text-danger">
                                <span class="material-symbols-outlined">speed</span>
                            </div>
                            <h4 class="h5 fw-bold mb-1">Tài khoản mới</h4>
                            <p class="display-6 fw-bold mb-0 tai-khoan">
                                <?= $tongTaiKhoan ?? 0 ?>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="custom-card h-100">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h3 class="h4 fw-bold text-dark">
                                Top sản phẩm bán chạy nhất
                            </h3>
                            <p class="small text-muted mb-0">
                                Sản phẩm có số lượng bán ra cao nhất trong khoảng thời gian đã chọn
                            </p>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-danger rounded-1" style="width: 12px; height: 12px"></div>
                                <span class="small fw-bold text-uppercase" style="font-size: 10px">Sản phẩm</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-danger-subtle rounded-1" style="width: 12px; height: 12px"></div>
                                <span class="small fw-bold text-uppercase" style="font-size: 10px">Doanh thu</span>
                            </div>
                        </div>
                    </div>
                    <div class="top-products-container">
                        <?php foreach ($topProducts as $item): ?>
                            <?php
                            $percentQty = $maxQuantity > 0 ? ($item['total_quantity'] / $maxQuantity) * 100 : 0;
                            $percentRevenue = $maxRevenue > 0 ? ($item['total_revenue'] / $maxRevenue) * 100 : 0;
                            ?>
                            <div class="bar-group">
                                <div class="bars">
                                    <div class="bar-units" style="height: <?= $percentQty ?>%">
                                        <span class="bar-value text-danger">
                                            <?= number_format($item['total_quantity']) ?>
                                        </span>
                                    </div>
                                    <div class="bar-revenue" style="height: <?= $percentRevenue ?>%">
                                        <span class="bar-value text-danger-emphasis">
                                            <?= number_format($item['total_revenue']) ?>đ
                                        </span>
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <p class="mb-0 fw-bold small text-truncate">
                                        <?= $item['ten_san_pham'] ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- Active Users List -->
            <div class="col-lg-5">
                <div class="custom-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="h5 fw-bold text-dark">Top 5 khách hàng chi tiêu nhiều nhất</h3>
                        <button class="btn btn-link text-muted p-0">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </button>
                    </div>
                    <div class="user-list">
                        <?php foreach ($topUsers as $user): ?>
                            <div class="user-item">
                                <div class="d-flex align-items-center gap-3">
                                    <img class="avatar" src="<?= BASE_URL_ADMIN ?>assets/img/avatar.png" />
                                    <div>
                                        <p class=" mb-0 fw-bold small text-dark">
                                            <?= $user['ho_ten'] ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0 fw-extrabold text-danger">
                                        <?= number_format($user['total_spent']) ?>đ
                                    </p>
                                    <p class="mb-0 text-muted" style="font-size: 10px">
                                        <?= $user['total_orders'] ?> đơn
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- chuyển dữ liệu db sang js -->
<script>
    window.data7Ngay = <?= json_encode($data7Ngay) ?>;
    window.data12Thang = <?= json_encode($data12Thang) ?>;
    window.ADMIN_URL = "<?= BASE_URL_ADMIN ?>index.php";
</script>
<script src="<?= BASE_ASSETS ?>js/dashboard/dashboard.js"></script>
<!--////////////////// Footer //////////////////-->
<?php include './views/layout/footer.php' ?>
<!--//////////////////End Footer //////////////////-->

<!-- Page specific script -->

<!-- Code injected by live-server -->

</body>

</html>