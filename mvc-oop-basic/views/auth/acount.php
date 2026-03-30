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
                                    <div class="col-md-4">
                                        <div class="card p-3 mb-4 text-center" style="border: 1px solid #ddd; border-radius: 8px;">
                                            <div class="mb-3">
                                                <img src="<?= !empty($user['anh_dai_dien']) ? BASE_URL . $user['anh_dai_dien'] : BASE_ASSETS_IMG . 'avatar_default.jpg' ?>" alt="Avatar" style="width: 160px; height: 160px; object-fit: cover; border-radius: 50%; border: 2px solid #eee;" onerror="this.onerror=null;this.src='<?= BASE_ASSETS_IMG ?>avatar_default.jpg'" />
                                            </div>
                                            <div class="form-group">
                                                <label for="avatar">Cập nhật avatar</label>
                                                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" />
                                            </div>
                                            <p class="small text-muted">Định dạng: JPG, PNG. Kích thước tối đa 2MB.</p>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
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

                                <hr>
                                <h6 class="mb-3">Đổi mật khẩu (Để trống nếu không muốn đổi)</h6>

                                <div class="single-input-item">
                                    <input type="password" placeholder="Mật khẩu hiện tại" name="old_password" />
                                </div>

                                <div class="single-input-item">
                                    <input type="password" placeholder="Mật khẩu mới" name="new_password" />
                                </div>

                                <div class="single-input-item">
                                    <button class="btn btn-sqr login-btn">CẬP NHẬT THÔNG TIN</button>
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