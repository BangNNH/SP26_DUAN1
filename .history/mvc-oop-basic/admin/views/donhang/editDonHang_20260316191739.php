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
                    <h1>Quản lý thông tin đơn hàng</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Sửa thông tin đơn hàng <?= $donHang['ma_don_hang'] ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?= BASE_URL_ADMIN . '?act=sua-don-hang' ?>" method="POST">
                            <input type="text" value="<?= $donHang['id'] ?>" name="id" hidden>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Tên người nhận: </label>
                                    <input type="text" class="form-control" name="ten_nguoi_nhan"
                                        value="<?= $donHang['ten_nguoi_nhan'] ?>" placeholder="Nhập tên người nhận">
                                    <?php if (isset($errors['ten_nguoi_nhan'])) { ?>
                                        <p class="text-danger"><?= $errors['ten_nguoi_nhan'] ?></p>
                                        <?php
                                    } ?>
                                </div>

                                <div class="form-group">
                                    <label>Số điện thoại: </label>
                                    <input type="text" class="form-control" name="so_dien_thoai"
                                        value="<?= $donHang['so_dien_thoai'] ?>" placeholder="Nhập số điện thoại">
                                    <?php if (isset($errors['so_dien_thoai'])) { ?>
                                        <p class="text-danger"><?= $errors['so_dien_thoai'] ?></p>
                                        <?php
                                    } ?>
                                </div>

                                <div class="form-group">
                                    <label>Email: </label>
                                    <input type="text" class="form-control" name="email"
                                        value="<?= $donHang['email'] ?>" placeholder="Nhập email">
                                    <?php if (isset($errors['email'])) { ?>
                                        <p class="text-danger"><?= $errors['email'] ?></p>
                                        <?php
                                    } ?>
                                </div>

                                <div class="form-group">
                                    <label>Địa Chỉ: </label>
                                    <input type="text" class="form-control" name="dia_chi"
                                        value="<?= $donHang['dia_chi_nguoi_nhan'] ?>" placeholder="Nhập địa chỉ">
                                    <?php if (isset($errors['dia_chi_nguoi_nhan'])) { ?>
                                        <p class="text-danger"><?= $errors['dia_chi_nguoi_nhan'] ?></p>
                                        <?php
                                    } ?>
                                </div>

                                <div class="form-group">
                                    <label>Ghi chú: </label>
                                    <textarea name="ghi_chu" id="" class="form-control"
                                        placeholder="Nhập ghi chú"><?= $donHang['ghi_chu'] ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="danh_muc_id">Trạng thái đơn hàng</label>
                                    <select name="danh_muc_id" class="form-control custom-select">
                                        <!-- /.chọn disabled để chọn trạng thái cho sản phẩm, Nếu trạng thái của đơn hàng đã qua thì không cho phép chọn lại trạng thái cũ nữa -->
                                        <?php foreach ($listTrangThaiDonHang as $trangThai): ?>
                                            <option <?php
                                            if (
                                                $donHang['trang_thai_id'] > $trangThai['id']
                                                || $donHang['trang_thai_id'] == 9
                                                || $donHang['trang_thai_id'] == 10
                                                || $donHang['trang_thai_id'] == 11
                                            ) {
                                                echo 'disabled';

                                            }
                                            ?>
                                                <?= $trangThai['id'] == $donHang['trang_thai_id'] ? 'selected' : '' ?>
                                                value="<?= $trangThai['id'] ?>">
                                                <?= $trangThai['ten_trang_thai'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($_SESSION['errors']['danh_muc_id'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['errors']['danh_muc_id'] ?></p>
                                        <?php
                                    } ?>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
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