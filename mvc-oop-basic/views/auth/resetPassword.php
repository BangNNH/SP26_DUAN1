<?php require_once 'views/layout/header.php' ?>
<?php require_once 'views/layout/menu.php' ?>

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Đặt lại mật khẩu</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="login-register-wrapper section-padding pt-4">
        <div class="container" style="max-width: 500px;">
            <div class="member-area-from-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-reg-form-wrap">
                            <h5 class="text-center">XÁC THỰC & ĐẶT LẠI MẬT KHẨU</h5>

                            <form action="<?= BASE_URL . '?act=verify-and-reset-password' ?>" method="post">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>" />

                                <div class="single-input-item">
                                    <label class="fw-bold">Mã xác thực (OTP)</label>
                                    <input type="text" placeholder="Nhập mã 6 số" name="otp_code" maxlength="6" required
                                        style="letter-spacing: 5px; text-align: center; font-weight: bold; font-size: 20px;" />
                                    <small class="text-muted d-block text-center mt-1">Mã đã được gửi vào Email/SĐT của bạn</small>
                                </div>

                                <hr>

                                <div class="single-input-item">
                                    <label>Mật khẩu mới</label>
                                    <input type="password" placeholder="Nhập mật khẩu mới" name="password" required />
                                </div>

                                <div class="single-input-item">
                                    <label>Xác nhận mật khẩu mới</label>
                                    <input type="password" placeholder="Nhập lại mật khẩu mới" name="password_confirmation" required />
                                </div>

                                <div class="single-input-item">
                                    <button type="submit" class="btn btn-sqr login-btn w-100">XÁC NHẬN ĐỔI MẬT KHẨU</button>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="<?= BASE_URL . '?act=forgot-password' ?>" style="font-size: 13px;">Gửi lại mã khác?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'views/layout/footer.php' ?>