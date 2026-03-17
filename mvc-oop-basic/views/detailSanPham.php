<?php require_once 'layout/header.php' ?>

<?php require_once 'layout/menu.php' ?>

<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>l"><i class="fa fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="shop.html">Sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding pb-0">
        <div class="container">
            <div class="row">
                <!-- product details wrapper start -->
                <div class="col-lg-12 order-1 order-lg-2">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-large-slider">
                                    <?php if (!empty($listAnhSanPham) && is_array($listAnhSanPham)): ?>
                                        <?php foreach($listAnhSanPham as $key => $anhSanPham): ?>
                                        <div class="pro-large-img img-zoom">
                                            <img src="<?= BASE_URL . $anhSanPham['link_hinh_anh'] ?>" alt="product-details" />
                                        </div>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <div class="pro-large-img img-zoom">
                                            <img src="assets/img/product/product-1.jpg" alt="product-details" />
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="pro-nav slick-row-10 slick-arrow-style">
                                    <?php if (!empty($listAnhSanPham) && is_array($listAnhSanPham)): ?>
                                        <?php foreach($listAnhSanPham as $key => $anhSanPham): ?>
                                        <div class="pro-nav-thumb">
                                            <img src="<?= BASE_URL . $anhSanPham['link_hinh_anh'] ?>" alt="product-details" />
                                        </div>
                                        <?php endforeach ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-des" style="padding-left: 30px;">
                                    <div class="manufacturer-name">
                                        <a href="#"><?= $sanPham['ten_danh_muc'] ?></a>
                                    </div>
                                    <h3 class="product-name"><?= $sanPham['ten_san_pham'] ?></h3>
                                    <div class="ratings d-flex">
                                        <div class="pro-review">
                                            <?php $countComment = (!empty($listBinhLuan) && is_array($listBinhLuan)) ? count($listBinhLuan) : 0; ?>
                                            <span><?= $countComment . ' bình luận'?></span>
                                        </div>
                                    </div>
                                    <div class="price-box">
                                        <?php
                                                            $gia = $sanPham['gia_san_pham'] ?? $sanPham['gia'] ?? 0;
                                                            $gia_khuyen_mai = $sanPham['gia_khuyen_mai'] ?? $gia;
                                                        ?>
                                        <?php if ($gia_khuyen_mai > 0 && $gia_khuyen_mai < $gia): ?>
                                        <span class="price-regular"><?= formatPrice($gia_khuyen_mai) ?>đ</span>
                                        <span class="price-old"><del><?= formatPrice($gia) ?>đ</del></span>
                                        <?php else: ?>
                                        <span class="price-regular"><?= formatPrice($gia) ?>đ</span>
                                        <?php endif; ?>
                                        <!-- <span class="price-regular">$70.00</span>
                                                <span class="price-old"><del>$90.00</del></span> -->
                                    </div>
                                    <h5 class="offer-text"><strong>Hurry up</strong>! offer ends in:</h5>
                                    <div class="product-countdown" data-countdown="2022/12/20"></div>
                                    <div class="availability">
                                        <i class="fa fa-check-circle"></i>
                                        <span><?= $sanPham['so_luong'] . ' trong kho' ?></span>
                                    </div>
                                    <p class="pro-desc"><?= $sanPham['mo_ta'] ?></p>
                                    <form action="<?= BASE_URL . '?act=them-gio-hang' ?>" method="post">
                                        <div class="quantity-cart-box d-flex align-items-center">
                                            <h6 class="option-title">Số lượng:</h6>
                                            <div class="quantity">
                                                <input type="hidden" name="san_pham_id" value="<?= $sanPham['id']; ?>">
                                                <div class="pro-qty"><input type="text" value="1" name="so_luong"></div>
                                            </div>
                                            <div class="action_link">
                                                <button class="btn btn-cart2">Thêm vào giỏ</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- product details inner end -->
            </div>
            <!-- product details wrapper end -->
        </div>
    </div>
    </div>
    <!-- page main wrapper end -->

    <!-- related products area start -->
    <section class="related-products section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm liên quan</h2>   
                        <p class="sub-title"></p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                        <!-- product item start -->
                        <?php if (!empty($listSanPhamCungDanhMuc) && is_array($listSanPhamCungDanhMuc)): ?>
                        <?php foreach($listSanPhamCungDanhMuc as $key => $sanPham): ?>
                        <!-- product item start -->
                        <div class="product-item">
                            <figure class="product-thumb">
                                <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'];?>">
                                    <img class="pri-img" src="<?= BASE_URL . $sanPham['hinh_anh']?>" alt="product">
                                    <!-- <img class="sec-img" src="assets/img/product/product-18.jpg" alt="product"> -->
                                </a>
                                <div class="product-badge">
                                    <?php
                                                        $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                                        $ngayHienTai = new DateTime();
                                                        $tinhNgay = $ngayHienTai->diff($ngayNhap);

                                                        if ($tinhNgay->days <=7) {
                                                    ?>
                                    <div class="product-label new">
                                        <span>Mới</span>
                                    </div>

                                    <?php } ?>
                                    <?php if($sanPham['gia_khuyen_mai']) { ?>
                                    <div class="product-label discount">
                                        <span>Giảm giá</span>
                                    </div>

                                    <?php  } ?>

                                </div>
                                <div class="cart-hover">
                                    <button class="btn btn-cart">Xem chi tiết</button>
                                </div>
                            </figure>
                            <div class="product-caption text-center">
                                <h6 class="product-name">
                                    <a
                                        href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'];?>"><?= $sanPham['ten_san_pham'] ?></a>
                                </h6>
                                <div class="price-box">
                                    <?php
                                                        $gia = $sanPham['gia_san_pham'] ?? $sanPham['gia'] ?? 0;
                                                        $gia_khuyen_mai = $sanPham['gia_khuyen_mai'] ?? $gia;
                                                    ?>
                                    <?php if ($gia_khuyen_mai > 0 && $gia_khuyen_mai < $gia): ?>
                                    <span class="price-regular"><?= formatPrice($gia_khuyen_mai) ?>đ</span>
                                    <span class="price-old"><del><?= formatPrice($gia) ?>đ</del></span>
                                    <?php else: ?>
                                    <span class="price-regular"><?= formatPrice($gia) ?>đ</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- product item end -->
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="col-12 text-center">
                            <p>Hiện chưa có sản phẩm liên quan nào.</p>
                        </div>
                        <?php endif; ?>

                        <!-- product item end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- related products area end -->

    <!-- product details reviews start -->
    <div class="product-details-reviews section-padding pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-review-info">
                        <ul class="nav review-tab">
                            <li>
                                <a class="active" data-bs-toggle="tab" href="#tab_three">Bình luận
                                    (<?= $countComment ?>)</a>
                            </li>
                        </ul>
                        <div class="tab-content reviews-tab">
                            <div class="tab-pane fade show active" id="tab_three">
                                <form action="#" class="review-form">
                                    <div class="total-reviews">
                                        <?php if (!empty($listBinhLuan) && is_array($listBinhLuan)): ?>
                                        <?php foreach ($listBinhLuan as $binhLuan): ?>
                                        <div class="rev-avatar">
                                            <img src="<?= !empty($binhLuan['anh_dai_dien']) ? BASE_URL . $binhLuan['anh_dai_dien'] : 'assets/img/avatar-default.jpg' ?>"
                                                alt="avatar">
                                        </div>
                                        <div class="review-box">
                                            <div class="post-author">
                                                <p><span><?= htmlspecialchars($binhLuan['ho_ten']) ?></span> -
                                                    <?= date('d M, Y', strtotime($binhLuan['ngay_dang'])) ?></p>
                                            </div>
                                            <p><?= htmlspecialchars($binhLuan['noi_dung']) ?></p>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <p>Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label class="col-form-label"><span class="text-danger">*</span>
                                                Nội dung bình luận</label>
                                            <textarea class="form-control" name="noi_dung" required></textarea>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <button class="btn btn-sqr" type="submit">Bình luận</button>
                                    </div>
                                </form> <!-- end of review-form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product details reviews end -->


<?php require_once 'layout/miniCart.php' ?>

<?php require_once 'layout/footer.php' ?>