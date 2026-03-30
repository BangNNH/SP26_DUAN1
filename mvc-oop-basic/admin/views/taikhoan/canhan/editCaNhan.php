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
                <div class="col-sm-6">
                    <h1>Quản lý tài khoản cá nhân</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card card-widget widget-user-2 shadow-sm">
                                <div class="widget-user-header bg-info" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);padding: 20px 30px;border-radius: 12px;background: linear-gradient(135deg, #2aa4b8, #1e7f8f); display: flex; align-items: center; gap: 15px;">
                                    <div class="widget-user-image">
                                        <img class="img-circle elevation-2" style="width: 80px; height: 80px ; border-radius :  50%;  border: 3px solid #fff;  object-fit: cover; " 
                                        src="<?= BASE_URL_ADMIN . $thongTin['anh_dai_dien'] ?>" alt="Avatar" onerror="this.onerror=null;this.src='https://weart.vn/wp-content/uploads/2025/06/chu-meo-cute-voi-bieu-cam-ngo-ngac-to-mo.jpg'">
                                    </div>
                                    <div style="font-size: 20px; font-weight: 550;">
                                        <h5 class="widget-user-username text-white" style="margin-left: 0px;"><?= htmlspecialchars($thongTin['ho_ten'] ?? 'Admin') ?></h5>
                                        <span class="info-box-number" style="background: rgba(255,255,255,0.2);padding: 4px 10px;  border-radius: 20px; font-size: 13px;  display: inline-block;">Chức vụ: <?= htmlspecialchars($thongTin['ten_dang_nhap'] ?? 'admin') ?></span>
                                    </div>
                                    <!-- <span class="widget-user-desc text-white"><strong>Chức vụ: </strong><?= htmlspecialchars($thongTin['chuc_vu_id'] == 1 ? 'Admin' : '') ?></span> -->
                                </div>
                                <div class="card-footer p-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($thongTin['email'] ?? 'Chưa có') ?></p>
                                            <p class="mb-1"><strong>SĐT:</strong> <?= htmlspecialchars($thongTin['so_dien_thoai'] ?? 'Chưa có') ?></p>
                                            <p class="mb-0"><strong>Địa chỉ:</strong> <?= htmlspecialchars($thongTin['dia_chi'] ?? 'Chưa có') ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="info-box bg-light shadow-sm mt-2">
                                <span class="info-box-icon bg-primary"><i class="fas fa-user-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tài khoản hiện tại</span>
                                    <span class="info-box-number"><?= htmlspecialchars($thongTin['ten_dang_nhap'] ?? 'admin') ?></span>
                                </div>
                            </div> -->
                        </div>

                        <div class="col-lg-8">
                            <?php if (!empty($_SESSION['success'])) { ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['success']) ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            <?php } ?>
                            <?php if (!empty($_SESSION['errors']['general'])) { ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($_SESSION['errors']['general']) ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            <?php } ?>

                            <div class="card card-outline card-info shadow-sm mb-3">
                                <div class="card-header">
                                    <h5 class="card-title">Thông tin cá nhân</h5>
                                </div>
                                <div class="card-body">
                                    <form action="<?= BASE_URL_ADMIN . '?act=sua-thong-tin-ca-nhan-admin' ?>" method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Họ tên</label>
                                                <input class="form-control" type="text" name="ho_ten" value="<?= htmlspecialchars($thongTin['ho_ten'] ?? '') ?>">
                                                <?php if (!empty($_SESSION['errors']['ho_ten'])) { ?><small class="text-danger"><?= htmlspecialchars($_SESSION['errors']['ho_ten']) ?></small><?php } ?>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Email</label>
                                                <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($thongTin['email'] ?? '') ?>">
                                                <?php if (!empty($_SESSION['errors']['email'])) { ?><small class="text-danger"><?= htmlspecialchars($_SESSION['errors']['email']) ?></small><?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Số điện thoại</label>
                                                <input class="form-control" type="text" name="so_dien_thoai" value="<?= htmlspecialchars($thongTin['so_dien_thoai'] ?? '') ?>">
                                                <?php if (!empty($_SESSION['errors']['so_dien_thoai'])) { ?><small class="text-danger"><?= htmlspecialchars($_SESSION['errors']['so_dien_thoai']) ?></small><?php } ?>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Ngày sinh</label>
                                                <input class="form-control" type="date" name="ngay_sinh" value="<?= htmlspecialchars($thongTin['ngay_sinh'] ?? '') ?>">
                                                <?php if (!empty($_SESSION['errors']['ngay_sinh'])) { ?><small class="text-danger"><?= htmlspecialchars($_SESSION['errors']['ngay_sinh']) ?></small><?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Địa chỉ</label>
                                            <textarea class="form-control" name="dia_chi" rows="3"><?= htmlspecialchars($thongTin['dia_chi'] ?? '') ?></textarea>
                                            <?php if (!empty($_SESSION['errors']['dia_chi'])) { ?><small class="text-danger"><?= htmlspecialchars($_SESSION['errors']['dia_chi']) ?></small><?php } ?>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thay đổi</button>
                                    </form>
                                </div>
                            </div>

                            <div class="card card-outline card-warning shadow-sm">
                                <div class="card-header">
                                    <h5 class="card-title">Đổi mật khẩu</h5>
                                </div>
                                <div class="card-body">
                                    <form action="<?= BASE_URL_ADMIN . '?act=sua-mat-khau-ca-nhan-admin' ?>" method="post">
                                        <div class="form-group">
                                            <label>Mật khẩu cũ</label>
                                            <input class="form-control" type="password" name="old_pass" value="">
                                            <?php if (!empty($_SESSION['errors']['old_pass'])) { ?><small class="text-danger"><?= htmlspecialchars($_SESSION['errors']['old_pass']) ?></small><?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Mật khẩu mới</label>
                                            <input class="form-control" type="password" name="new_pass" value="">
                                            <?php if (!empty($_SESSION['errors']['new_pass'])) { ?><small class="text-danger"><?= htmlspecialchars($_SESSION['errors']['new_pass']) ?></small><?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Nhập lại mật khẩu</label>
                                            <input class="form-control" type="password" name="confirm_pass" value="">
                                            <?php if (!empty($_SESSION['errors']['confirm_pass'])) { ?><small class="text-danger"><?= htmlspecialchars($_SESSION['errors']['confirm_pass']) ?></small><?php } ?>
                                        </div>
                                        <button type="submit" class="btn btn-warning"><i class="fas fa-key"></i> Cập nhật mật khẩu</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!--////////////////// Footer //////////////////-->
<?php include './views/layout/footer.php' ?>
<!--//////////////////End Footer //////////////////-->

</body>

</html>