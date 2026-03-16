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
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h1>Quản lý danh sách đơn hàng - Đơn hàng: <?= $donHang['ma_don_hang'] ?? "" ?> </h1>
                </div>
                <div class="col-sm-2">
                    <form action="" method="post">
                        <select name="" id="" class="from-group">
                            <option value="" disabled></option>
                            <?php foreach ($listTrangThaiDonHang as $key => $trangThai): ?>
                                <option <?= $trangThai['id'] == $donHang['trang_thai_id'] ? 'selected' : '' ?>
                                    <?= $trangThai['id'] < $donHang['trang_thai_id'] ? 'disabled' : '' ?>
                                    value="<?= $trangThai['id'] ?>">
                                    <?= $trangThai['ten_trang_thai'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php
                    if ($donHang['trang_thai_id'] == 1) {
                        $colorAlerts = 'primary';
                    } elseif ($donHang['trang_thai_id'] >= 2 && ($donHang['trang_thai_id'] <= 9)) {
                        $colorAlerts = 'warning';
                    } elseif ($donHang['trang_thai_id'] == 10) {
                        $colorAlerts = 'success';
                    } else {
                        $colorAlerts = 'danger';
                    }
                    ?>
                    <div class="alert alert-<?= $colorAlerts ?>" role="alert">
                        Đơn hàng: <?= $donHang['ten_trang_thai'] ?>
                    </div>


                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- thông tin chính(mã đơn hàng, trạng thái) -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-cat"> Shop Thú Cưng - Làng Xì Chăm</i>
                                    <small class="float-right">Ngày Đặt: <?= formatDate($donHang['ngay_dat']) ?></small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- Thông tin người đặt -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Thông tin người đặt
                                <div>
                                    <p><strong><?= $donHang['ho_ten'] ?? "" ?></strong><br>
                                    <p>Số điện thoại:
                                        <?= $donHang['so_dien_thoai'] ?? "" ?>
                                    </p>
                                    <p></p>Email:
                                    <?= $donHang['email'] ?? "" ?>
                                    </p>
                                </div>
                            </div>
                            <!-- Thông tin người nhận -->
                            <div class="col-sm-4 invoice-col">
                                Người nhận:
                                <div>
                                    <p><strong><?= $donHang['ten_nguoi_nhan'] ?? "" ?></strong></p>
                                    <p></p>Email người nhận: <?= $donHang['email_nguoi_nhan'] ?? "" ?></p>
                                    <p>Số điện thoại người nhận: <?= $donHang['sdt_nguoi_nhan'] ?? "" ?></p>
                                    <p>Địa chỉ: <?= $donHang['dia_chi_nguoi_nhan'] ?? "" ?></p>
                                </div>
                            </div>
                            <!-- Chi tiết đơn hàng -->
                            <div class="col-sm-4 invoice-col">
                                Thông tin đơn hàng
                                <div>
                                    <p><strong>Mã đơn hàng:<?= $donHang['ma_don_hang'] ?? "" ?></strong></p>
                                    <p></p>Tổng tiền: <?= number_format($donHang['tong_tien'] ?? 0, 0, ',', '.') ?>đ</p>
                                    <p>Ghi chú: <?= $donHang['ghi_chu'] ?? "" ?></p>
                                    <p>Phương thức thanh toán: <?= $donHang['ten_phuong_thuc'] ?? "" ?></p>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Đơn giá</th>
                                            <th>Số lượng</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $tong_tien = 0; ?>
                                        <?php foreach ($sanPhamDonHang ?? [] as $key => $sanPham): ?>
                                            <tr>
                                                <td>
                                                    <?= $key + 1 ?>
                                                </td>
                                                <td>
                                                    <?= $sanPham['ten_san_pham'] ?? "" ?>
                                                </td>
                                                <td>
                                                    <?= number_format($sanPham['don_gia'] ?? 0, 0, ',', '.') ?>đ
                                                </td>
                                                <td>
                                                    <?= $sanPham['so_luong'] ?? 0 ?>
                                                </td>
                                                <td>
                                                    <?= number_format($sanPham['thanh_tien'] ?? 0, 0, ',', '.') ?>
                                                    đ
                                                </td>
                                                <?php $tong_tien += $sanPham['thanh_tien']; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- Thanh toán -->
                            <div class="col-6">
                                <p class="lead">Ngày đặt:
                                    <?= $donHang['ngay_dat'] ?? "" ?>
                                </p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Thành tiền:</th>
                                            <td> <?= number_format($tong_tien, 0, ',', '.') ?>đ </td>
                                        </tr>
                                        <tr>
                                            <th>Vận chuyển</th>
                                            <td> 30.000đ</td>
                                        </tr>
                                        <tr>
                                            <th>Tổng tiền:</th>
                                            <td> <?= number_format($tong_tien + 30000, 0, ',', '.') ?>đ </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                                        class="fas fa-print"></i> Print</a>
                                <button type="button" class="btn btn-success float-right"><i
                                        class="far fa-credit-card"></i> Submit
                                    Payment
                                </button>
                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!--////////////////// Footer //////////////////-->
<?php include './views/layout/footer.php' ?>
<!--//////////////////End Footer //////////////////-->

<!-- Page specific script -->
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
<!-- Code injected by live-server -->
</body>

</html>