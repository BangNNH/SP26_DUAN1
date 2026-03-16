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
        <div class="container">
            <hr>
            <div class="row">
                <!-- left column -->

                <div class="col-md-3">
                    <div class="text-center">
                        <img src="<?= BASE_URL_ADMIN . $thongTin['anh_dai_dien']?>" style="width: 100px;"
                            class="avatar img-circle" alt="avatar"
                            onerror="this.onerror = null; this.src = 'https://weart.vn/wp-content/uploads/2025/06/chu-meo-cute-voi-bieu-cam-ngo-ngac-to-mo.jpg'">
                        </td>
                        <h6 class="mt-2">Họ tên:<?=$thongTin['ho_ten'] ?></h6>
                        <h6 class="mt-2">Chức vụ:<?=$thongTin['chuc_vu_id'] ?></h6>

                    </div>
                </div>

                <!-- edit form column -->
                <div class="col-md-9 personal-info">
                    <hr>
                    <h3>Thông tin cá nhân</h3>

                    <?php if (!empty($_SESSION['success'])) { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-check"></i>
                        <?= htmlspecialchars($_SESSION['success']) ?>
                    </div>
                    <?php } ?>
                    <?php if (!empty($_SESSION['errors']['general'])) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-exclamation-triangle"></i>
                        <?= htmlspecialchars($_SESSION['errors']['general']) ?>
                    </div>
                    <?php } ?>

                    <form action="<?= BASE_URL_ADMIN . '?act=sua-thong-tin-ca-nhan-admin' ?>" method="post">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Họ tên:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" name="ho_ten" value="<?= htmlspecialchars($thongTin['ho_ten'] ?? '') ?>">
                                <?php if (!empty($_SESSION['errors']['ho_ten'])) { ?>
                                    <p class="text-danger"><?= htmlspecialchars($_SESSION['errors']['ho_ten']) ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" name="email" value="<?= htmlspecialchars($thongTin['email'] ?? '') ?>">
                                <?php if (!empty($_SESSION['errors']['email'])) { ?>
                                    <p class="text-danger"><?= htmlspecialchars($_SESSION['errors']['email']) ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Số điện thoại:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" name="so_dien_thoai" value="<?= htmlspecialchars($thongTin['so_dien_thoai'] ?? '') ?>">
                                <?php if (!empty($_SESSION['errors']['so_dien_thoai'])) { ?>
                                    <p class="text-danger"><?= htmlspecialchars($_SESSION['errors']['so_dien_thoai']) ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Ngày sinh:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="date" name="ngay_sinh" value="<?= htmlspecialchars($thongTin['ngay_sinh'] ?? '') ?>">
                                <?php if (!empty($_SESSION['errors']['ngay_sinh'])) { ?>
                                    <p class="text-danger"><?= htmlspecialchars($_SESSION['errors']['ngay_sinh']) ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Địa chỉ:</label>
                            <div class="col-lg-12">
                                <textarea class="form-control" name="dia_chi" rows="3"><?= htmlspecialchars($thongTin['dia_chi'] ?? '') ?></textarea>
                                <?php if (!empty($_SESSION['errors']['dia_chi'])) { ?>
                                    <p class="text-danger"><?= htmlspecialchars($_SESSION['errors']['dia_chi']) ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" value="Lưu thay đổi">
                            </div>
                        </div>
                    </form>

                    <h3>Đổi mật khẩu</h3>

                    <form action="<?= BASE_URL_ADMIN . '?act=sua-mat-khau-ca-nhan-admin' ?>" method="post">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Mật khẩu cũ:</label>
                            <div class="col-md-12">
                                <input class="form-control" type="password" name="old_pass" value="">
                                <?php if (!empty($_SESSION['errors']['old_pass'])) { ?>
                                        <p class="text-danger"><?= htmlspecialchars($_SESSION['errors']['old_pass']) ?></p>
                                    <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Mật khẩu mới:</label>
                            <div class="col-md-12">
                                <input class="form-control" type="password" name="new_pass" value="">
                                <?php if (!empty($_SESSION['errors']['new_pass'])) { ?>
                                        <p class="text-danger"><?= htmlspecialchars($_SESSION['errors']['new_pass']) ?></p>
                                    <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nhập lại mật khẩu:</label>
                            <div class="col-md-12">
                                <input class="form-control" type="password" name="confirm_pass" value="">
                                 <?php if (!empty($_SESSION['errors']['confirm_pass'])) { ?>
                                        <p class="text-danger"><?= htmlspecialchars($_SESSION['errors']['confirm_pass']) ?></p>
                                    <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" value="Save Changes">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!--////////////////// Footer //////////////////-->
<?php include './views/layout/footer.php' ?>
<!--//////////////////End Footer //////////////////-->

</body>

</html>