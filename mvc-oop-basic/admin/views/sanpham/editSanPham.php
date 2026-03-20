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
                <div class="col-sm-11">
                    <h1>Sửa thông tin sản phẩm <?= $sanPham['ten_san_pham'] ?></h1>
                </div>
                <div class="col-1">
                    <a href="http://localhost/SP26_DUAN1/mvc-oop-basic/admin/?act=san-pham" class="btn btn-secondary" style="min-width: 100px;margin-left: -25px;">Quay lại</a>
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
                                <label for="ten_san_pham">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" name="ten_san_pham" class="form-control" value="<?= $sanPham['ten_san_pham'] ?>">
                                <?php if (isset($_SESSION['errors']['ten_san_pham'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['errors']['ten_san_pham'] ?></p>
                                <?php
                                } ?>
                            </div>
                            <div class="form-group">
                                <label for="gia_san_pham">Giá sản phẩm <span class="text-danger">*</span></label>
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
                                <label for="hinh_anh">Hình ảnh (đổi nếu cần)</label>
                                <input type="file" name="hinh_anh" class="form-control">
                                <small>Ảnh hiện tại: <a href="<?= BASE_URL . $sanPham['hinh_anh'] ?>" target="_blank">Xem</a></small>
                            </div>
                            <div class="form-group">
                                <label for="code">Mã code</label>
                                <input type="text" name="code" class="form-control" value="<?= $sanPham['code'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="is_new">Sản phẩm mới</label>
                                <select name="is_new" class="form-control custom-select">
                                    <option value="1" <?= $sanPham['is_new'] == 1 ? 'selected' : '' ?>>Có</option>
                                    <option value="0" <?= $sanPham['is_new'] == 0 ? 'selected' : '' ?>>Không</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="is_hot">Sản phẩm hot</label>
                                <select name="is_hot" class="form-control custom-select">
                                    <option value="1" <?= $sanPham['is_hot'] == 1 ? 'selected' : '' ?>>Có</option>
                                    <option value="0" <?= $sanPham['is_hot'] == 0 ? 'selected' : '' ?>>Không</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="gioi_tinh">Giới tính</label>
                                <select name="gioi_tinh" class="form-control custom-select">
                                    <option value="1" <?= $sanPham['gioi_tinh'] == 1 ? 'selected' : '' ?>>Nam</option>
                                    <option value="2" <?= $sanPham['gioi_tinh'] == 2 ? 'selected' : '' ?>>Nữ</option>
                                    <option value="3" <?= $sanPham['gioi_tinh'] == 3 ? 'selected' : '' ?>>Unisex</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="loai_may">Loại máy</label>
                                <input type="text" name="loai_may" class="form-control" value="<?= $sanPham['loai_may'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="xuat_xu">Xuất xứ</label>
                                <input type="text" name="xuat_xu" class="form-control" value="<?= $sanPham['xuat_xu'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="kich_thuoc">Kích thước</label>
                                <input type="text" name="kich_thuoc" class="form-control" value="<?= $sanPham['kich_thuoc'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="chat_lieu_day">Chất liệu dây</label>
                                <input type="text" name="chat_lieu_day" class="form-control" value="<?= $sanPham['chat_lieu_day'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="chong_nuoc">Chống nước</label>
                                <input type="text" name="chong_nuoc" class="form-control" value="<?= $sanPham['chong_nuoc'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="so_luong">Số lượng <span class="text-danger">*</span></label>
                                <input type="number" name="so_luong" class="form-control" value="<?= $sanPham['so_luong'] ?>">
                                <?php if (isset($_SESSION['errors']['so_luong'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['errors']['so_luong'] ?></p>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="ngay_nhap">Ngày nhập <span class="text-danger">*</span></label>
                                <input type="date" name="ngay_nhap" class="form-control" value="<?= $sanPham['ngay_nhap'] ?>">
                                <?php if (isset($_SESSION['errors']['ngay_nhap'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['errors']['ngay_nhap'] ?></p>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="danh_muc_id">Danh mục sản phẩm <span class="text-danger">*</span></label>
                                <select name="danh_muc_id" class="form-control custom-select">
                                    <?php foreach ($listDanhMuc as $danhMuc): ?>
                                        <option <?= $danhMuc['id'] == $sanPham['danh_muc_id'] ? 'selected' : '' ?> value="<?= $danhMuc['id'] ?>"><?= $danhMuc['ten_danh_muc'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($_SESSION['errors']['danh_muc_id'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['errors']['danh_muc_id'] ?></p>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="trang_thai">Trạng thái <span class="text-danger">*</span></label>
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
                                                <td class="mt-10"><button class="badge badge-danger" type="button" onclick="removeRow(<?= $key ?>,<?= $value['id'] ?>)"><i class="fa fa-trash"></i> Xóa</button></td>
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
        html = '<tr id="faqs-row-' + faqs_row + '">';
        html += '<td><img src="https://weart.vn/wp-content/uploads/2025/06/chu-meo-cute-voi-bieu-cam-ngo-ngac-to-mo.jpg"  style="width:50px; height: 50px;"></td>';
        html += '<td><input type="file" name = "img_array[]" class="form-control"></td>';
        html += '<td class="mt-10"><button type ="button" class="badge badge-danger" onclick="removeRow(' + faqs_row + ',null);"><i class="fa fa-trash"></i> Xóa</button></td>';

        html += '</tr>';

        $('#faqs tbody').append(html);

        faqs_row++;
    }

    function removeRow(rowId, imgId) {
        $('#faqs-row-' + rowId).remove();
        if (imgId !== null) {
            var imgDeleteInput = document.getElementById('img_delete')
            var currentValue = imgDeleteInput.value;
            imgDeleteInput.value = currentValue ? currentValue + ',' + imgId : imgId;
        }
    }
</script>

</html>