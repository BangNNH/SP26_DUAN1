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
                    <h1>Quản lý danh sách sản phẩm</h1>
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
                            <h3 class="card-title">Thêm sản phẩm</h3>
                        </div>
                        <!-- form start -->
                        <form action="<?= BASE_URL_ADMIN . '?act=them-san-pham' ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body row">

                                <!-- Tên -->
                                <div class="form-group col-12">
                                    <label>Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ten_san_pham">
                                    <?php if (isset($_SESSION['errors']['ten_san_pham'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['errors']['ten_san_pham'] ?></p>
                                    <?php
                                    } ?>
                                </div>

                                <!-- Giá -->
                                <div class="form-group col-6">
                                    <label>Giá sản phẩm <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="gia_san_pham">
                                    <?php if (isset($_SESSION['errors']['gia_san_pham'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['errors']['gia_san_pham'] ?></p>
                                    <?php
                                    } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label>Giá khuyến mãi</label>
                                    <input type="number" class="form-control" name="gia_khuyen_mai">
                                </div>

                                <!-- Ảnh -->
                                <div class="form-group col-6">
                                    <label>Hình ảnh <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="hinh_anh">
                                    <?php if (isset($_SESSION['errors']['hinh_anh'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['errors']['hinh_anh'] ?></p>
                                    <?php
                                    } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label>Album ảnh</label>
                                    <input type="file" class="form-control" name="img_array[]" multiple>
                                </div>

                                <!-- Số lượng -->
                                <div class="form-group col-6">
                                    <label>Số lượng <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="so_luong">
                                    <?php if (isset($_SESSION['errors']['so_luong'])): ?>
                                        <small class="text-danger"><?= $_SESSION['errors']['so_luong'] ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Ngày nhập -->
                                <div class="form-group col-6">
                                    <label>Ngày nhập <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="ngay_nhap">
                                    <?php if (isset($_SESSION['errors']['ngay_nhap'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['errors']['ngay_nhap'] ?></p>
                                    <?php
                                    } ?>
                                </div>

                                <!-- Danh mục -->
                                <div class="form-group col-6">
                                    <label>Danh mục <span class="text-danger">*</span></label>
                                    <select class="form-control" name="danh_muc_id">
                                        <option value="">Chọn danh mục</option>
                                        <?php foreach ($listDanhMuc as $danhMuc): ?>
                                            <option value="<?= $danhMuc['id'] ?>"><?= $danhMuc['ten_danh_muc'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($_SESSION['errors']['danh_muc_id'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['errors']['danh_muc_id'] ?></p>
                                    <?php
                                    } ?>
                                </div>

                                <!-- Trạng thái -->
                                <div class="form-group col-6">
                                    <label>Trạng thái <span class="text-danger">*</span></label>
                                    <select class="form-control" name="trang_thai">
                                        <option value="">Chọn trạng thái</option>
                                        <option value="1">Còn hàng</option>
                                        <option value="2">Dừng bán</option>
                                    </select>
                                    <?php if (isset($_SESSION['errors']['trang_thai'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['errors']['trang_thai'] ?></p>
                                    <?php
                                    } ?>
                                </div>

                                <!-- Code -->
                                <div class="form-group col-6">
                                    <label>Mã code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="code">
                                    <?php if (isset($_SESSION['errors']['code'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['errors']['code'] ?></p>
                                    <?php
                                    } ?>
                                </div>

                                <!-- Sản phẩm mới -->
                                <div class="form-group col-3">
                                    <label>Sản phẩm mới</label>
                                    <select class="form-control" name="is_new">
                                        <option value="1">Có</option>
                                        <option value="0">Không</option>
                                    </select>
                                </div>

                                <!-- Sản phẩm hot -->
                                <div class="form-group col-3">
                                    <label>Sản phẩm hot</label>
                                    <select class="form-control" name="is_hot">
                                        <option value="1">Có</option>
                                        <option value="0">Không</option>
                                    </select>
                                </div>

                                <!-- Giới tính -->
                                <div class="form-group col-4">
                                    <label>Giới tính</label>
                                    <select class="form-control" name="gioi_tinh">
                                        <option value="1">Nam</option>
                                        <option value="2">Nữ</option>
                                        <option value="3">Unisex</option>
                                    </select>
                                </div>

                                <!-- Loại máy -->
                                <div class="form-group col-4">
                                    <label>Loại máy</label>
                                    <input type="text" class="form-control" name="loai_may">
                                </div>

                                <!-- Xuất xứ -->
                                <div class="form-group col-4">
                                    <label>Xuất xứ</label>
                                    <input type="text" class="form-control" name="xuat_xu">
                                </div>

                                <!-- Kích thước -->
                                <div class="form-group col-4">
                                    <label>Kích thước</label>
                                    <input type="text" class="form-control" name="kich_thuoc">
                                </div>

                                <!-- Chất liệu dây -->
                                <div class="form-group col-4">
                                    <label>Chất liệu dây</label>
                                    <input type="text" class="form-control" name="chat_lieu_day">
                                </div>

                                <!-- Chống nước -->
                                <div class="form-group col-4">
                                    <label>Chống nước</label>
                                    <input type="text" class="form-control" name="chong_nuoc">
                                </div>

                                <!-- Mô tả -->
                                <div class="form-group col-12">
                                    <label>Mô tả</label>
                                    <textarea name="mo_ta" class="form-control"></textarea>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
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