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
                                <li class="breadcrumb-item active" aria-current="page">Thông tin tài khoản</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="login-register-wrapper section-padding pt-4">
        <div class="container" style="max-width: 80vw"> <div class="member-area-from-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-reg-form-wrap">
                            <h5 class="text-center">THÔNG TIN TÀI KHOẢN</h5>
                            
                            <?php if (!empty($_SESSION['success'])) { ?>
                                <p class="text-success text-center"><?= htmlspecialchars($_SESSION['success']) ?></p>
                                <?php unset($_SESSION['success']); ?>
                            <?php } elseif (!empty($_SESSION['error'])) { ?>
                                <p class="text-danger text-center"><?= htmlspecialchars($_SESSION['error']) ?></p>
                                <?php unset($_SESSION['error']); ?>
                            <?php } ?>

                            <form action="<?= BASE_URL . '?act=update-profile' ?>" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div class="card p-3 text-center" style="border: 1px solid #ddd; border-radius: 8px; display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;">
                                            <div class="avatar-upload-wrapper" style="position: relative; display: inline-block; cursor: pointer; margin-bottom: 15px;">
                                                <img src="<?= !empty($user['anh_dai_dien']) ? BASE_URL . $user['anh_dai_dien'] : BASE_ASSETS_IMG . 'avatar_default.jpg' ?>" alt="Avatar" style="width: 160px; height: 160px; object-fit: cover; border-radius: 50%; border: 2px solid #eee; display: block;" onerror="this.onerror=null;this.src='<?= BASE_ASSETS_IMG ?>avatar_default.jpg'" />
                                                <label for="avatar" style="position: absolute; bottom: 0; right: 0; width: 45px; height: 45px; border-radius: 50%; background: #dc3545; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; cursor: pointer; border: 3px solid #fff; transition: all 0.3s ease;">
                                                    +
                                                </label>
                                            </div>
                                            <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;" />
                                            <p class="small text-muted" style="margin-top: 0;">Cập nhật avatar<br>Định dạng: JPG, PNG. Kích thước tối đa 2MB.</p>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <div class="card p-4" style="border: 1px solid #ddd; border-radius: 8px; height: 100%;">
                                            <h6 class="mb-3">Thông tin tài khoản</h6>
                                            <div class="single-input-item">
                                                <label>Họ và tên</label>
                                                <input type="text" placeholder="Họ và tên" name="name" value="<?= htmlspecialchars($user['ho_ten'] ?? '') ?>" required />
                                            </div>

                                            <div class="single-input-item">
                                                <label>Email (Không thể thay đổi)</label>
                                                <input type="email" placeholder="Email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly style="background-color: #f4f4f4;" />
                                            </div>

                                            <div class="single-input-item">
                                                <label>Số điện thoại</label>
                                                <input type="text" placeholder="Số điện thoại" name="phone" value="<?= htmlspecialchars($user['so_dien_thoai'] ?? '') ?>" />
                                            </div>

                                            <div class="single-input-item">
                                                <label>Địa chỉ</label>
                                                <input type="text" placeholder="Địa chỉ" name="address" value="<?= htmlspecialchars($user['dia_chi'] ?? '') ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <div class="card p-4" style="border: 1px solid #ddd; border-radius: 8px; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                                            <div>
                                                <h6 class="mb-3">Đổi mật khẩu</h6>
                                                <p class="small text-muted mb-3">Để trống nếu không muốn đổi</p>

                                                <div class="single-input-item">
                                                    <input type="password" placeholder="Mật khẩu hiện tại" name="old_password" />
                                                </div>

                                                <div class="single-input-item">
                                                    <input type="password" placeholder="Mật khẩu mới" name="new_password" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12" style="display: flex; justify-content: center;">
                                        <button class="btn btn-sqr login-btn" style="width: 35%;">CẬP NHẬT THÔNG TIN</button>
                                    </div>
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