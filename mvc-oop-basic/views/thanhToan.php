<?php require_once 'layout/header.php' ?>
<?php require_once 'layout/menu.php' ?>

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= isset($_SESSION['user_client']) ? '?act=gio-hang' : '?act=login' ?>">Giỏ hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-page-wrapper section-padding pt-4">
        <div class="container">
            <!-- Hiển thị lỗi sản phẩm bị xoá -->
            <?php if (!empty($_SESSION['errors']) && ($_GET['status'] ?? '' === 'product-deleted' || !empty($_SESSION['flash']))): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">⚠️ Sản phẩm không khả dụng</h4>
                    <ul style="margin-bottom: 0;">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['errors']); unset($_SESSION['flash']); ?>
            <?php endif ?>

            <!-- Hiển thị lỗi tồn kho -->
            <?php if (!empty($_SESSION['errors']) && $_GET['status'] ?? '' === 'stock-error'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Rất tiếc, sản phẩm hiện không đủ số lượng!</h4>
                    <ul style="margin-bottom: 0;">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['errors']); unset($_SESSION['flash']); ?>
            <?php endif ?>

            <!-- Hiển thị lỗi thanh toán -->
            <?php if (($_GET['status'] ?? '') === 'error'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading"> Thanh toán thất bại</h4>
                    <p>Giao dịch thanh toán của bạn không thành công. Vui lòng thử lại.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>

            <!-- Hiển thị success -->
            <?php if (($_GET['status'] ?? '') === 'success'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">✓ Thanh toán thành công</h4>
                    <p>Đơn hàng của bạn đã được tạo thành công. Vui lòng chờ xanh nhân viên liên hệ.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>

            <form action="<?= BASE_URL . '?act=xu-ly-thanh-toan' ?>" method="POST" id="main-checkout-form">
                <input type="hidden" name="direct_san_pham_id" value="<?= htmlspecialchars($direct_san_pham_id ?? '') ?>">
                <input type="hidden" name="direct_so_luong" value="<?= htmlspecialchars($direct_so_luong ?? 1) ?>">
                <div class="row">
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

                    <div class="col-lg-6">
                        <div class="order-summary-details">
                            <h5 class="checkout-title">Thông tin đơn hàng</h5>
                            <div class="order-summary-content">
                                <div class="order-summary-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $tongGioHang = 0;
                                            foreach ($chiTietGioHang as $sanPham):
                                                $gia = $sanPham['gia_khuyen_mai'] ?: $sanPham['gia_san_pham'];
                                                $thanhTien = $gia * $sanPham['so_luong'];
                                                $tongGioHang += $thanhTien;
                                            ?>
                                                <tr>
                                                    <td><?= $sanPham['ten_san_pham'] ?><strong> × <?= $sanPham['so_luong'] ?></strong></td>
                                                    <td><?= formatPrice($thanhTien) ?> VNĐ</td>
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
                                                <td><strong>30.000 VNĐ</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#921918; font-weight: 600;">Tổng đơn hàng</td>
                                                <input type="hidden" name="tong_tien" value="<?= $tongGioHang + 30000 ?>">
                                                <td style="color:#921918; font-weight: 600;"><?= formatPrice($tongGioHang + 30000) ?> VNĐ</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="order-payment-method">
                                    <div class="single-payment-method show">
                                        <div class="payment-method-name">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="cashon" name="phuong_thuc_thanh_toan_id" value="1" class="custom-control-input" checked />
                                                <label class="custom-control-label" for="cashon">Thanh toán khi nhận hàng (COD)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-payment-method">
                                        <div class="payment-method-name">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="momo" name="phuong_thuc_thanh_toan_id" value="3" class="custom-control-input" />
                                                <label class="custom-control-label" for="momo">Thanh toán qua ví MoMo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-footer-area">
                                        <div class="custom-control custom-checkbox mb-20">
                                            <input type="checkbox" class="custom-control-input" id="terms" required />
                                            <label class="custom-control-label" for="terms">Tôi đồng ý với các điều khoản...</label>
                                        </div>
                                        <button type="submit" id="btn-submit-order" class="btn btn-sqr">Tiến hành đặt hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="?act=momo-payment" method="POST" id="momo-payment-form" style="display: none;">
                <input type="hidden" name="ten_nguoi_nhan" id="momo_ten">
                <input type="hidden" name="email_nguoi_nhan" id="momo_email">
                <input type="hidden" name="sdt_nguoi_nhan" id="momo_sdt">
                <input type="hidden" name="dia_chi_nguoi_nhan" id="momo_diachi">
                <input type="hidden" name="ghi_chu" id="momo_ghichu">

                <?php if (isset($_POST['is_mua_ngay']) && $_POST['is_mua_ngay'] == 1): ?>
                    <input type="hidden" name="is_mua_ngay" value="1">
                    <input type="hidden" name="san_pham_id" value="<?= $_POST['san_pham_id'] ?? '' ?>">
                    <input type="hidden" name="ten_san_pham" value="<?= $_POST['ten_san_pham'] ?? '' ?>">
                    <input type="hidden" name="gia_san_pham" value="<?= $_POST['gia_san_pham'] ?? '' ?>">
                    <input type="hidden" name="so_luong" value="<?= $_POST['so_luong'] ?? 1 ?>">
                    
                    <?php 
                        // Tính lại tổng tiền Momo (Giá x Số lượng + Phí ship 30k)
                        $gia = (int)($_POST['gia_san_pham'] ?? 0);
                        $soluong = (int)($_POST['so_luong'] ?? 1);
                        $total_momo = ($gia * $soluong) + 30000;
                    ?>
                    <input type="hidden" name="total_momo" value="<?= $total_momo ?>">
                <?php else: ?>
                    <input type="hidden" name="total_momo" value="<?= $tongGioHang + 30000 ?>">
                <?php endif; ?>
            </form>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainForm = document.getElementById('main-checkout-form');

        if (mainForm) {
            mainForm.addEventListener('submit', function(e) {
                const selectedMethod = document.querySelector('input[name="phuong_thuc_thanh_toan_id"]:checked').value;

                if (selectedMethod == '3') {
                    e.preventDefault(); // Chặn gửi về xu-ly-thanh-toan

                    if (!document.getElementById('terms').checked) {
                        alert('Vui lòng đồng ý với điều khoản dịch vụ!');
                        return false;
                    }

                    // ĐỔ DỮ LIỆU TỪ FORM CHÍNH SANG FORM MOMO TRƯỚC KHI SUBMIT
                    document.getElementById('momo_ten').value = document.getElementById('ten_nguoi_nhan').value;
                    document.getElementById('momo_email').value = document.getElementById('email_nguoi_nhan').value;
                    document.getElementById('momo_sdt').value = document.getElementById('sdt_nguoi_nhan').value;
                    document.getElementById('momo_diachi').value = document.getElementById('dia_chi_nguoi_nhan').value;
                    document.getElementById('momo_ghichu').value = document.getElementById('ghi_chu').value;

                    console.log("Dữ liệu đã copy xong. Đang chuyển hướng MoMo...");
                    document.getElementById('momo-payment-form').submit();
                }
            });
        }
    });
</script>

<?php require_once 'layout/miniCart.php' ?>
<?php require_once 'layout/footer.php' ?>