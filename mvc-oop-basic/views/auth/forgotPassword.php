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
                            <h5 class="text-center">QUÊN MẬT KHẨU</h5>

                            <?php if (!empty($_SESSION['success'])) : ?>
                                <div class="alert alert-success text-center">
                                    <?= htmlspecialchars($_SESSION['success']);
                                    unset($_SESSION['success']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($_SESSION['error'])) : ?>
                                <div class="alert alert-danger text-center">
                                    <?= htmlspecialchars($_SESSION['error']);
                                    unset($_SESSION['error']); ?>
                                </div>
                            <?php endif; ?>

                            <form action="<?= BASE_URL . '?act=send-otp-forgot-password' ?>" method="post">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>" />

                                <p class="text-center">Nhập Email hoặc Số điện thoại đã đăng ký để nhận mã xác thực (OTP).</p>

                                <div class="single-input-item">
                                    <input type="text" placeholder="Email hoặc Số điện thoại" name="contact_info"
                                        value="<?= htmlspecialchars($_SESSION['old_contact'] ?? '') ?>" required />
                                    <?php if (!empty($_SESSION['error_contact'])) : ?>
                                        <small class="text-danger"><?= $_SESSION['error_contact'];
                                                                    unset($_SESSION['error_contact']); ?></small>
                                    <?php endif; ?>
                                </div>

                                <div class="single-input-item">
                                    <button type="submit" class="btn btn-sqr login-btn w-100">GỬI MÃ XÁC NHẬN</button>
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