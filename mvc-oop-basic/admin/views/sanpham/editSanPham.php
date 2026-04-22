<?php include './views/layout/header.php' ?>
<?php include './views/layout/navbar.php' ?>
<?php include './views/layout/sidebar.php' ?>

<style>
    body {
        font-size: 16px;
        background: #f5f7fa;
    }

    .card {
        border-radius: 14px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 4px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .divider {
        height: 1px;
        background: #eee;
        margin: 20px 0;
    }

    /* album */
    .album-card {
        background: #fff;
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        transition: 0.25s;
    }

    .album-card:hover {
        transform: translateY(-3px);
    }

    .album-card img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1>Quản lý danh sách sản phẩm</h1>
            <a href="<?= BASE_URL_ADMIN . '?act=san-pham' ?>" class="btn btn-light border">Quay lại</a>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- FORM -->
                <div class="col-lg-8">
                    <div class="card  card-primary">
                        <div class="card-header" bis_skin_checked="1">
                            <h3 class="card-title">Sửa thông tin sản phẩm: <?= $sanPham['ten_san_pham'] ?></h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= BASE_URL_ADMIN . '?act=sua-san-pham' ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">

                                <div class="section-title">Thông tin cơ bản</div>
                                <div class="row">

                                    <div class="col-md-6 form-group">
                                        <label>Tên sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" name="ten_san_pham" class="form-control" value="<?= $sanPham['ten_san_pham'] ?>">
                                        <?php if (isset($_SESSION['errors']['ten_san_pham'])): ?>
                                            <small class="text-danger"><?= $_SESSION['errors']['ten_san_pham'] ?></small>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Mã code <span class="text-danger">*</span></label>
                                        <input type="text" name="code" class="form-control" value="<?= $sanPham['code'] ?>">
                                        <?php if (isset($_SESSION['errors']['code'])): ?>
                                            <small class="text-danger"><?= $_SESSION['errors']['code'] ?></small>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Giá <span class="text-danger">*</span></label>
                                        <input type="number" name="gia_san_pham" class="form-control" value="<?= $sanPham['gia_san_pham'] ?>">
                                        <?php if (isset($_SESSION['errors']['gia_san_pham'])): ?>
                                            <small class="text-danger"><?= $_SESSION['errors']['gia_san_pham'] ?></small>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Giá khuyến mãi</label>
                                        <input type="number" name="gia_khuyen_mai" class="form-control" value="<?= $sanPham['gia_khuyen_mai'] ?>">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Danh mục <span class="text-danger">*</span></label>
                                        <select name="danh_muc_id" class="form-control">
                                            <?php foreach ($listDanhMuc as $danhMuc): ?>
                                                <option value="<?= $danhMuc['id'] ?>" <?= $danhMuc['id'] == $sanPham['danh_muc_id'] ? 'selected' : '' ?>>
                                                    <?= $danhMuc['ten_danh_muc'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Hình ảnh <span class="text-danger">*</span></label>
                                        <input type="file" name="hinh_anh" class="form-control">
                                        <small>Ảnh hiện tại: <a target="_blank" href="<?= BASE_URL . $sanPham['hinh_anh'] ?>">Xem</a></small>
                                    </div>

                                </div>

                                <div class="divider"></div>

                                <div class="section-title">Thông số</div>
                                <div class="row">

                                    <div class="col-md-4 form-group">
                                        <label>Loại máy</label>
                                        <input type="text" name="loai_may" class="form-control" value="<?= $sanPham['loai_may'] ?>">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Xuất xứ</label>
                                        <input type="text" name="xuat_xu" class="form-control" value="<?= $sanPham['xuat_xu'] ?>">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Kích thước</label>
                                        <input type="text" name="kich_thuoc" class="form-control" value="<?= $sanPham['kich_thuoc'] ?>">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Chất liệu dây</label>
                                        <input type="text" name="chat_lieu_day" class="form-control" value="<?= $sanPham['chat_lieu_day'] ?>">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Chống nước</label>
                                        <input type="text" name="chong_nuoc" class="form-control" value="<?= $sanPham['chong_nuoc'] ?>">
                                    </div>

                                </div>

                                <div class="divider"></div>

                                <div class="section-title">Trạng thái</div>
                                <div class="row">

                                    <div class="col-md-4 form-group">
                                        <label>Số lượng <span class="text-danger">*</span></label>
                                        <input type="number" name="so_luong" class="form-control" value="<?= $sanPham['so_luong'] ?>">
                                        <?php if (isset($_SESSION['errors']['so_luong'])): ?>
                                            <small class="text-danger"><?= $_SESSION['errors']['so_luong'] ?></small>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Ngày nhập <span class="text-danger">*</span></label>
                                        <input type="date" name="ngay_nhap" class="form-control" value="<?= $sanPham['ngay_nhap'] ?>">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Trạng thái <span class="text-danger">*</span></label>
                                        <select name="trang_thai" class="form-control">
                                            <option value="1" <?= $sanPham['trang_thai'] == 1 ? 'selected' : '' ?>>Còn hàng</option>
                                            <option value="2" <?= $sanPham['trang_thai'] == 2 ? 'selected' : '' ?>>Hết hàng</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Sản phẩm mới</label>
                                        <select name="is_new" class="form-control">
                                            <option value="1" <?= $sanPham['is_new'] == 1 ? 'selected' : '' ?>>Có</option>
                                            <option value="0" <?= $sanPham['is_new'] == 0 ? 'selected' : '' ?>>Không</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Sản phẩm hot</label>
                                        <select name="is_hot" class="form-control">
                                            <option value="1" <?= $sanPham['is_hot'] == 1 ? 'selected' : '' ?>>Có</option>
                                            <option value="0" <?= $sanPham['is_hot'] == 0 ? 'selected' : '' ?>>Không</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Giới tính</label>
                                        <select name="gioi_tinh" class="form-control">
                                            <option value="1" <?= $sanPham['gioi_tinh'] == 1 ? 'selected' : '' ?>>Nam</option>
                                            <option value="2" <?= $sanPham['gioi_tinh'] == 2 ? 'selected' : '' ?>>Nữ</option>
                                            <option value="3" <?= $sanPham['gioi_tinh'] == 3 ? 'selected' : '' ?>>Unisex</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="divider"></div>

                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea name="mo_ta" class="form-control" rows="4"><?= $sanPham['mo_ta'] ?></textarea>
                                </div>

                                <div class="text-center mt-3">
                                    <button class="btn btn-primary">Cập nhật</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                <!-- ALBUM -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header"><b>Album ảnh</b></div>
                        <div class="card-body">

                            <form action="<?= BASE_URL_ADMIN . '?act=sua-album-anh-san-pham' ?>" method="post" enctype="multipart/form-data">

                                <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                                <input type="hidden" name="img_delete" id="img_delete">

                                <div id="album-list" class="row">

                                    <?php foreach ($listAnhSanPham as $key => $value): ?>
                                        <div class="col-6 mb-3" id="faqs-row-<?= $key ?>">
                                            <div class="album-card">

                                                <input type="hidden" name="current_img_ids[]" value="<?= $value['id'] ?>">

                                                <img src="<?= BASE_URL . $value['link_hinh_anh'] ?>">

                                                <input type="file" name="img_array[]" class="form-control mt-2">

                                                <button type="button"
                                                    onclick="removeRow(<?= $key ?>,<?= $value['id'] ?>)"
                                                    class="btn btn-danger btn-sm w-100 mt-2">
                                                    Xóa
                                                </button>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>

                                <button type="button" onclick="addfaqs()" class="btn btn-light border w-100 mt-2">
                                    + Thêm ảnh
                                </button>

                                <div class="text-center mt-3">
                                    <button class="btn btn-primary">Cập nhật album</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<?php include './views/layout/footer.php' ?>

<script>
    var faqs_row = <?= count($listAnhSanPham) ?>;

    function addfaqs() {
        let html = `
    <div class="col-6 mb-3" id="faqs-row-${faqs_row}">
        <div class="album-card">
            <img src="https://via.placeholder.com/150">
            <input type="file" name="img_array[]" class="form-control mt-2">
            <button type="button"
                onclick="removeRow(${faqs_row}, null)"
                class="btn btn-danger btn-sm w-100 mt-2">
                Xóa
            </button>
        </div>
    </div>`;

        $('#album-list').append(html);
        faqs_row++;
    }

    function removeRow(rowId, imgId) {
        $('#faqs-row-' + rowId).remove();
        if (imgId !== null) {
            let input = document.getElementById('img_delete');
            input.value = input.value ? input.value + ',' + imgId : imgId;
        }
    }
</script>