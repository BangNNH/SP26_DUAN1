<!--////////////////// Header //////////////////-->
<?php include './views/layout/header.php' ?>
<?php include './views/layout/navbar.php' ?>
<?php include './views/layout/sidebar.php' ?>

<style>
    body {
        font-size: 16px;
        color: #1f2937;
    }

    .page-title {
        font-size: 26px;
    }

    .card-main {
        border-radius: 16px;
        border: none;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.06);
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .divider {
        height: 1px;
        background: #e5e7eb;
        margin: 20px 0;
    }

    .info-grid p {
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
    }

    .info-grid span:first-child {
        color: #6b7280;
    }

    .info-grid span:last-child {
        font-weight: 500;
    }

    /* IMAGE */
    .image-wrapper {
        /* background: #f9fafb; */
        border-radius: 14px;
        position: relative;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        max-height: 420px;
        object-fit: contain;
        transition: all 0.4s ease;
    }

    .fade-out {
        opacity: 0;
        transform: translateX(-30px);
    }

    .fade-in {
        opacity: 0;
        transform: translateX(30px);
    }

    .thumb-list {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .thumb {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        object-fit: cover;
        cursor: pointer;
        transition: 0.25s;
    }

    .thumb:hover {
        transform: translateY(-3px);
    }

    .thumb.active {
        border: 1px solid #111;
    }

    /* PRICE */
    .price-main {
        font-size: 28px;
        color: #111;
    }

    .price-sale {
        font-size: 14px;
        color: #dc2626;
    }

    /* TABLE */
    .table thead {
        background: #f3f4f6;
    }

    .table tbody tr:hover {
        background: #fafafa;
    }

    .btn-action {
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
    }
</style>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <h1 class="page-title">Chi tiết sản phẩm</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-main">
                <div class="card-body p-4">

                    <div class="row g-5">

                        <!-- LEFT IMAGE -->
                        <div class="col-lg-5">
                            <div class="image-wrapper">
                                <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" id="mainImage" class="product-image">
                            </div>

                            <div class="thumb-list">
                                <?php foreach ($listAnhSanPham as $anhSP): ?>
                                    <img src="<?= BASE_URL . $anhSP['link_hinh_anh'] ?>" class="thumb product-image-thumb">
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- RIGHT INFO -->
                        <div class="col-lg-7">

                            <h2 class="page-title mb-2">
                                <?= $sanPham['ten_san_pham'] ?>
                            </h2>

                            <div class="price-main">
                                <?= number_format($sanPham['gia_san_pham']) ?> VNĐ
                            </div>

                            <div class="price-sale mb-3">
                                Giá khuyến mãi: <?= number_format($sanPham['gia_khuyen_mai']) ?> VNĐ
                            </div>

                            <div class="divider"></div>

                            <div class="row">
                                <div class="col-md-6 info-grid">
                                    <p><span>Số lượng</span><span><?= $sanPham['so_luong'] ?></span></p>
                                    <p><span>Lượt xem</span><span><?= $sanPham['luot_xem'] ?></span></p>
                                    <p><span>Ngày nhập</span><span><?= $sanPham['ngay_nhap'] ?></span></p>
                                    <p><span>Danh mục</span><span><?= $sanPham['ten_danh_muc'] ?></span></p>
                                </div>

                                <div class="col-md-6 info-grid">
                                    <p><span>Trạng thái</span>
                                        <span style="color:<?= $sanPham['trang_thai'] == 1 ? '#16a34a' : '#dc2626' ?>">
                                            <?= $sanPham['trang_thai'] == 1 ? 'Còn hàng' : 'Hết hàng' ?>
                                        </span>
                                    </p>
                                    <p><span>Mã</span><span><?= $sanPham['code'] ?></span></p>
                                    <p><span>Sản phẩm mới</span><span><?= $sanPham['is_new'] ? 'Có' : 'Không' ?></span></p>
                                    <p><span>Sản phẩm hot</span><span><?= $sanPham['is_hot'] ? 'Có' : 'Không' ?></span></p>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <div class="section-title">Thông tin chi tiết</div>

                            <div class="row info-grid">
                                <div class="col-md-6">
                                    <p><span>Giới tính</span><span><?= $sanPham['gioi_tinh'] ?></span></p>
                                    <p><span>Loại máy</span><span><?= $sanPham['loai_may'] ?></span></p>
                                    <p><span>Xuất xứ</span><span><?= $sanPham['xuat_xu'] ?></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>Kích thước</span><span><?= $sanPham['kich_thuoc'] ?></span></p>
                                    <p><span>Chất liệu dây</span><span><?= $sanPham['chat_lieu_day'] ?></span></p>
                                    <p><span>Chống nước</span><span><?= $sanPham['chong_nuoc'] ?></span></p>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <div>
                                <div class="section-title">Mô tả</div>
                                <p style="line-height:1.7;color:#374151;">
                                    <?= $sanPham['mo_ta'] ?>
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- COMMENTS -->
                    <div style="margin-top:50px;">

                        <div class="section-title">Bình luận</div>

                        <div class="card card-main">
                            <div class="card-body p-0">

                                <table id="example1" class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Người dùng</th>
                                            <th>Nội dung</th>
                                            <th>Ngày</th>
                                            <th>Trạng thái</th>
                                            <th class="text-center">Thao tác</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($listBinhLuan as $key => $binhLuan) : ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $binhLuan['ho_ten'] ?></td>
                                                <td><?= $binhLuan['noi_dung'] ?></td>
                                                <td><?= $binhLuan['ngay_dang'] ?></td>
                                                <td><?= $binhLuan['trang_thai'] == 1 ? 'Hiển thị' : 'Ẩn' ?></td>
                                                <td class="text-center">
                                                    <form action="<?= BASE_URL_ADMIN . '?act=update-trang-thai-binh-luan' ?>" method="POST">
                                                        <input type="hidden" name="id_binh_luan" value="<?= $binhLuan['id'] ?>">
                                                        <input type="hidden" name="name_view" value="detail_sanpham">
                                                        <button class="btn-action btn btn-danger">
                                                            <?= $binhLuan['trang_thai'] == 1 ? 'Ẩn' : 'Bỏ ẩn' ?>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<?php include './views/layout/footer.php' ?>

<script>
    $(document).ready(function() {
        let isAnimating = false;

        $('.product-image-thumb').on('click', function() {
            if (isAnimating) return;
            isAnimating = true;

            const img = $('#mainImage');
            const newSrc = $(this).attr('src');

            // slide left + fade out
            img.css({
                transition: 'transform 0.4s ease, opacity 0.4s ease',
                transform: 'translateX(-60px)',
                opacity: '0'
            });

            setTimeout(() => {
                img.attr('src', newSrc);

                // reset vị trí bên phải trước khi slide vào
                img.css({
                    transition: 'none',
                    transform: 'translateX(60px)'
                });

                // force reflow để browser nhận state mới
                img[0].offsetHeight;

                // slide vào mượt
                img.css({
                    transition: 'transform 0.4s ease, opacity 0.4s ease',
                    transform: 'translateX(0)',
                    opacity: '1'
                });

                setTimeout(() => {
                    isAnimating = false;
                }, 400);

            }, 400);

            $('.thumb').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>