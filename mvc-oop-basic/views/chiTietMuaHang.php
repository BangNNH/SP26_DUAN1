<?php require_once 'layout/header.php' ?>

<?php require_once 'layout/menu.php' ?>

<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                <!-- <li class="breadcrumb-item"><a href="shop.html">Shop</a></li> -->
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- cart main wrapper start -->
    <div class="cart-main-wrapper section-padding pt-4">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-7">
                        <!-- Thông tin sản phẩm của đơn hàng -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">Thông tin sản phẩm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <th>Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Đơn Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                    <?php foreach ($chiTietDonHang as $item): ?>
                                        <tr class="text-center">
                                            <td>
                                                <img class="img-fluid" src="<?= BASE_URL . $item['hinh_anh'] ?>"
                                                    alt="Product" width="100px">
                                            </td>
                                            <td><?= $item['ten_san_pham'] ?></td>
                                            <td><?= number_format($item['don_gia'], 0, ',', '.') ?> VNĐ</td>
                                            <td><?= $item['so_luong'] ?></td>
                                            <td><?= number_format($item['thanh_tien'], 0, ',', '.') ?> VNĐ</td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class=" col-lg-5">
                        <!-- Thông tin đơn hàng -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center">Thông tin đơn hàng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Mã đơn hàng</td>
                                        <td>
                                            <?= $donHang['ma_don_hang'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Người nhận</td>
                                        <td>
                                            <?= $donHang['ten_nguoi_nhan'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>
                                            <?= $donHang['email_nguoi_nhan'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>số điện thoại</td>
                                        <td>
                                            <?= $donHang['sdt_nguoi_nhan'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ</td>
                                        <td>
                                            <?= $donHang['dia_chi_nguoi_nhan'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ngày đặt</td>
                                        <td>
                                            <?= $donHang['ngay_dat'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ghi chú</td>
                                        <td>
                                            <?= $donHang['ghi_chu'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tổng tiền</td>
                                        <td>
                                            <?= number_format($donHang['tong_tien'], 0, ',', '.') ?> VNĐ
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Phương thức thanh toán</td>
                                        <td>
                                            <?= $phuongThucThanhToan[$donHang['phuong_thuc_thanh_toan_id']] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Trạng thái</td>
                                        <td>
                                            <?= $trangThaiDonHang[$donHang['trang_thai_id']] ?>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart main wrapper end -->
</main>


<?php require_once 'layout/miniCart.php' ?>

<?php require_once 'layout/footer.php' ?>