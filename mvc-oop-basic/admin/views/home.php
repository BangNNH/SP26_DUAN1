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
    <div class="container-fluid p-5">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h3 class="display-6 fw-extrabold mt-1 mb-0">Thống kê</h3>
            </div>
            <button class="btn btn-primary-executive d-flex align-items-center gap-2">
                <span class="material-symbols-outlined">download</span>
                Export Report
            </button>
        </div>
        <!-- Summary Cards -->
        <div class="row g-4 mb-5">
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
            <div class="col-md-3">
                <div class="card p-4 stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-slate-light">
                            <span class="material-symbols-outlined">speed</span>
                        </div>
                        <span class="badge-stat bg-slate-light text-muted">-1.4%</span>
                    </div>
                    <p class="text-secondary fw-bold text-uppercase mb-1"
                        style="font-size: 10px; letter-spacing: 0.05em">
                        Conversion Rate
                    </p>
                    <h4 class="fw-black mb-0">3.42%</h4>
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
                            <path class="line-chart" d="M0,30 L100,30" fill="none" stroke="#b70011" stroke-width="1.5">
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
                                    Fulfilled
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

                    <div class="vstack gap-4">
                        <?php foreach ($topProducts as $item):
                            $percentQty = $maxQuantity > 0 ? ($item['total_quantity'] / $maxQuantity) * 100 : 0;
                            $percentRevenue = $maxRevenue > 0 ? ($item['total_revenue'] / $maxRevenue) * 100 : 0;
                            ?>
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <div class="fw-bold small">
                                        <?= $item['ten_san_pham'] ?>
                                    </div>
                                    <div class="text-muted">
                                        <?= $item['ten_danh_muc'] ?? 'N/A' ?>
                                    </div>
                                </div>

                                <div class="col-md-10">

                                    <!-- SỐ LƯỢNG -->
                                    <div class="progress-stack position-relative group">
                                        <div style="width: <?= $percentQty ?>%; height: 100%; background: #b70011; border-radius: 100px;"
                                            title="Số lượng: <?= $item['total_quantity'] ?>">
                                        </div>
                                    </div>

                                    <!-- DOANH THU -->
                                    <div class="progress-sub position-relative group">
                                        <div style="width: <?= $percentRevenue ?>%; height: 100%; background: #ffdad6; border-radius: 100px;"
                                            title="Doanh thu: <?= number_format($item['total_revenue']) ?> đ">
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
    </header>
</div>

<!-- chuyển dữ liệu db sang js -->
<script>
    const data7Ngay = <?= json_encode($data7Ngay) ?>;
    const data12Thang = <?= json_encode($data12Thang) ?>;
</script>
<script src="<?= BASE_ASSETS ?>js/dashboard/dashboard.js"></script>
<!--////////////////// Footer //////////////////-->
<?php include './views/layout/footer.php' ?>
<!--//////////////////End Footer //////////////////-->

<!-- Page specific script -->

<!-- Code injected by live-server -->

</body>

</html>