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
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= BASE_URL . '?act=gio-hang' ?>">Giỏ hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- checkout main wrapper start -->
    <div class="checkout-page-wrapper section-padding pt-4">
        <div class="container">
            <form action="<?= BASE_URL . '?act=xu-ly-thanh-toan' ?>" method="POST">
                <div class="row">
                    <!-- Checkout Billing Details -->
                    <div class="col-lg-6">
                        <div class="checkout-billing-details-wrap">
                            <h5 class="checkout-title">Thông tin người nhận</h5>
                            <div class="billing-form-wrap">
                                <div class="single-input-item">
                                    <label for="ten_nguoi_nhan" class="required">Tên người nhận</label>
                                    <input type="text" id="ten_nguoi_nhan" name="ten_nguoi_nhan" value="<?= isset($user['ho_ten']) ? $user['ho_ten'] : '' ?>" placeholder="Tên người nhận" required />
                                </div>

                                <div class="single-input-item">
                                    <label for="email_nguoi_nhan" class="required">Email</label>
                                    <input type="email" id="email_nguoi_nhan" name="email_nguoi_nhan" value="<?= isset($user['email']) ? $user['email'] : '' ?>" placeholder="Địa chỉ Email" required />
                                </div>

                                <div class="single-input-item">
                                    <label for="sdt_nguoi_nhan" class="required">SĐT</label>
                                    <input type="text" id="sdt_nguoi_nhan" name="sdt_nguoi_nhan" value="<?= isset($user['so_dien_thoai']) ? $user['so_dien_thoai'] : '' ?>" placeholder="SĐT người nhận" required />
                                </div>

                                <div class="single-input-item">
                                    <label for="dia_chi_nguoi_nhan">Địa chỉ</label>
                                    <input type="text" id="dia_chi_nguoi_nhan" name="dia_chi_nguoi_nhan" value="<?= isset($user['dia_chi']) ? $user['dia_chi'] : '' ?>" placeholder="Địa chỉ người nhận" />
                                </div>

                                <div class="single-input-item">
                                    <label for="ghi_chu">Ghi chú</label>
                                    <textarea name="ghi_chu" id="ghi_chu" cols="30" rows="3" placeholder="Ghi chú đơn hàng của bạn"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Details -->
                    <div class="col-lg-6">
                        <div class="order-summary-details">
                            <h5 class="checkout-title">Thông tin đơn hàng</h5>
                            <div class="order-summary-content">
                                <!-- Order Summary Table -->
                                <div class="order-summary-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="font-weight: bold">
                                                <th>Sản phẩm</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $tongGioHang = 0;
                                            foreach ($chiTietGioHang as $key => $sanPham):
                                                $tong_tien = 0; ?>
                                                <tr>
                                                    <td><a href="product-details.html"><?= $sanPham['ten_san_pham'] ?><strong> × <?= $sanPham['so_luong'] ?></strong></a>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($sanPham['gia_khuyen_mai']) {
                                                            $tong_tien = $sanPham['gia_khuyen_mai'] * $sanPham['so_luong'];
                                                        } else {
                                                            $tong_tien = $sanPham['gia_san_pham'] * $sanPham['so_luong'];
                                                        }
                                                        $tongGioHang += $tong_tien;
                                                        echo formatPrice($tong_tien . " VND");
                                                        ?> VNĐ
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Tổng tiền sản phẩm</td>
                                                <td><strong><?= formatPrice($tongGioHang) ?> VNĐ</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Phí ship</td>
                                                <td class="d-flex justify-content-center">
                                                    <strong>30.000 VNĐ</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color:#921918; font-weight: 600;">Tổng đơn hàng</td>
                                                <input type="hidden" name="tong_tien" value="<?= $tongGioHang + 30000 ?> ">
                                                <td style="color:#921918; font-weight: 600;"><?= formatPrice($tongGioHang + 30000) ?> VNĐ</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- Order Payment Method -->
                                <div class="order-payment-method">
                                    <div class="single-payment-method show">
                                        <div class="payment-method-name">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="cashon" name="phuong_thuc_thanh_toan_id" value="1" name="phuong_thuc_thanh_toan" class="custom-control-input" checked />
                                                <label class="custom-control-label" for="cashon">Thanh toán khi nhận hàng</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-payment-method">
                                        <div class="payment-method-name">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="directbank" name="phuong_thuc_thanh_toan_id" value="2" name="phuong_thuc_thanh_toan" class="custom-control-input" />
                                                <label class="custom-control-label" for="directbank">Thanh toán online</label>
                                            </div>
                                        </div>
                                        <div class="payment-method-details" data-method="bank">
                                            <p>Khách hàng thanh toán online</p>
                                        </div>
                                    </div>
                                    <div class="summary-footer-area">
                                        <div class="custom-control custom-checkbox mb-20">
                                            <input type="checkbox" class="custom-control-input" id="terms" required />
                                            <label class="custom-control-label" for="terms">Tôi đồng ý với các <a href="index.html">điều khoản và điều kiện</a> của website</label>
                                        </div>
                                        <button type="submit" class="btn btn-sqr">Tiến hành đặt hàng</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- checkout main wrapper end -->
</main>
<?php require_once 'layout/miniCart.php' ?>

<?php require_once 'layout/footer.php' ?>