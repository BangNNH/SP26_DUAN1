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
                    <h1>Sửa thông tin sản phẩm <?= $sanPham['ten_san_pham'] ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin sản phẩm</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <form action="<?= BASE_URL_ADMIN . '?act=sua-san-pham' ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                                <label for="ten_san_pham">Tên sản phẩm</label>
                                <input type="text" name="ten_san_pham" class="form-control" value="<?= $sanPham['ten_san_pham'] ?>">
                                <?php if (isset($_SESSION['errors']['ten_san_pham'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['errors']['ten_san_pham'] ?></p>
                                <?php
                                } ?>
                            </div>
                            <div class="form-group">
                                <label for="gia_san_pham">Giá sản phẩm</label>
                                <input type="number" name="gia_san_pham" class="form-control" value="<?= $sanPham['gia_san_pham'] ?>">
                                <?php if (isset($_SESSION['errors']['gia_san_pham'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['errors']['gia_san_pham'] ?></p>
                                <?php
                                } ?>
                            </div>
                            <div class="form-group">
                                <label for="gia_khuyen_mai">Giá khuyến mãi</label>
                                <input type="number" name="gia_khuyen_mai" class="form-control" value="<?= $sanPham['gia_khuyen_mai'] ?>">
                                <?php if (isset($_SESSION['errors']['gia_khuyen_mai'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['errors']['gia_khuyen_mai'] ?></p>
                                <?php
                                } ?>
                            </div>
                            <div class="form-group">
                                <label for="hinh_anh">Hình ảnh</label>
                                <input type="file" name="hinh_anh" class="form-control" value="<?= $sanPham['hinh_anh'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="ten_san_pham">Số lượng</label>
                                <input type="number" name="so_luong" class="form-control" value="<?= $sanPham['so_luong'] ?>">
                                <?php if (isset($_SESSION['errors']['so_luong'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['errors']['so_luong'] ?></p>
                                <?php
                                } ?>
                            </div>
                            <div class="form-group">
                                <label for="ten_san_pham">Ngày nhập</label>
                                <input type="date" name="ngay_nhap" class="form-control" value="<?= $sanPham['ngay_nhap'] ?>">
                                <?php if (isset($_SESSION['errors']['ngay_nhap'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['errors']['ngay_nhap'] ?></p>
                                <?php
                                } ?>
                            </div>
                            <div class="form-group">
                                <label for="danh_muc_id">Danh mục sản phẩm</label>
                                <select name="danh_muc_id" class="form-control custom-select">
                                    <?php foreach ($listDanhMuc as $danhMuc): ?>
                                        <option <?= $danhMuc['id'] == $sanPham['danh_muc_id'] ? 'selected' : '' ?> value="<?= $danhMuc['id'] ?>"><?= $danhMuc['ten_danh_muc'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($_SESSION['errors']['danh_muc_id'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['errors']['danh_muc_id'] ?></p>
                                <?php
                                } ?>
                            </div>
                            <div class="form-group">
                                <label for="trang_thai">Trạng thái</label>
                                <select name="trang_thai" class="form-control custom-select">
                                    <option value="1" <?= $sanPham['trang_thai'] == 1 ? 'selected' : '' ?>>Còn hàng</option>
                                    <option value="2" <?= $sanPham['trang_thai'] == 2 ? 'selected' : '' ?>>Dừng bán</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="mo_ta">Mô tả</label>
                                <textarea name="mo_ta" class="form-control" rows="4"><?= $sanPham['mo_ta'] ?></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Sửa thông tin</button>
                        </div>
                </div>
                </form>
                <!-- /.card -->
            </div>
            <div class="col-md-4">
                <!-- /.card -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Album ảnh sản phẩm</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <form action="<?= BASE_URL_ADMIN . '?act=sua-album-anh-san-pham' ?>" method="post" enctype="multipart/form-data">
                            <div class="table-responsive">
                                <table id="faqs" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ảnh</th>
                                            <th>File</th>
                                            <th>
                                                <div class="text-center"><button onclick="addfaqs();" type="button" class="badge badge-success"><i class="fa fa-plus"></i> Thêm</button></div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                                        <input type="hidden" name="img_delete" id="img_delete">
                                        <?php foreach ($listAnhSanPham as $key => $value): ?>
                                            <tr id="faqs-row-<?= $key ?>">
                                                <input type="hidden" name="current_img_ids[]" value="<?= $value['id'] ?>">
                                                <td><img src="<?= BASE_URL . $value['link_hinh_anh'] ?>" style="width: 50px; height: 50px;" alt=""></td>
                                                <td><input type="file" name="img_array[]" placeholder="Product name" class="form-control"></td>
                                                <td class="mt-10"><button class="badge badge-danger" onclick="removeRow(<?= $key ?>,<?= $value['id'] ?>)"><i class="fa fa-trash"></i> Xóa</button></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">Sửa thông tin</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Save Changes" class="btn btn-success float-right">
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
<script>
    var faqs_row = count(<?= count($listAnhSanPham) ?>);

    function addfaqs() {
        html = '<tr id="faqs-row' + faqs_row + '">';
        html += '<td><img src="https://weart.vn/wp-content/uploads/2025/06/chu-meo-cute-voi-bieu-cam-ngo-ngac-to-mo.jpg"  style="width:50px; height: 50px;"></td>';
        html += '<td><input type="file" name = "img_array[]" class="form-control"></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="removeRow(' + faqs_row + ',null);"><i class="fa fa-trash"></i> Xóa</button></td>';

        html += '</tr>';

        $('#faqs tbody').append(html);

        faqs_row++;
    }
</script>

</html>