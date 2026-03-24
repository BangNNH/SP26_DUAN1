<?php require_once 'layout/header.php' ?>

<?php require_once 'layout/menu.php' ?>

<main>
    <!-- hero slider area start -->
    <!--sliders  -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500" data-bs-wrap="true" data-bs-pause="false">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="6" aria-label="Slide 7"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/DUANMAU/assets/img/sliders/banner0.png.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/DUANMAU/assets/img/sliders/banner1.jpg.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/DUANMAU/assets/img/sliders/banner2.jpg.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/DUANMAU/assets/img/sliders/banner3.jpg.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/DUANMAU/assets/img/sliders/banner4.jpg.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/DUANMAU/assets/img/sliders/banner5.jpg.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/DUANMAU/assets/img/sliders/banner6.jpg.webp" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- promo section start -->
    <div class="promo-section">
        <ul class="promo-list">
            <li>
                <i class="fi fi-tr-medal"></i>
                <div class="promo-content">
                    <p>Trung tâm bảo hành chính hãng</p>
                    <p class="promo-detail">Tiêu chuẩn thụy sĩ</p>
                </div>
            </li>
            <li>
                <i class="fi fi-tr-shield-check"></i>
                <div class="promo-content">
                    <p>Thương hiệu uy tín</p>
                    <p class="promo-detail">21 NĂM PHÁT TRIỂN</p>
                </div>
            </li>
            <li>
                <i class="fi fi-tr-brand"></i>
                <div class="promo-content">
                    <p>Đa dạng thương hiệu </p>
                    <p class="promo-detail">40+ THƯƠNG HIỆU CHÍNH HÃNG</p>
                </div>
            </li>
        </ul>
    </div>
    <!-- promo section end -->

    <!-- product area start -->
    <section class="product-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">KHÁM PHÁ SẢN PHẨM</h2>
                        <p class="sub-title">Chọn danh mục bạn quan tâm</p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-container">
                        <!-- product tab menu start -->
                        <div class="product-tab-menu">
                            <ul class="nav justify-content-center">
                                <li><a href="#tab1" data-bs-toggle="tab" class="active">Automatic</a></li>
                                <li><a href="#tab2" data-bs-toggle="tab" class="">Quartz</a></li>
                                <li><a href="#tab3" data-bs-toggle="tab" class="">Eco-Drive</a></li>
                                <li><a href="#tab4" data-bs-toggle="tab" class="">Sport</a></li>
                                <li><a href="#tab5" data-bs-toggle="tab" class="">Smartwatch</a></li>
                            </ul>
                        </div>
                        <!-- product tab content by category start -->
                        <div class="tab-content">
                            <!-- automatic -->
                            <div class="tab-pane fade show active" id="tab1">
                                <div class="product-carousel-5 slick-row-10 slick-arrow-style">
                                    <?php if (!empty($listAutomatic) && is_array($listAutomatic)): ?>
                                        <?php foreach ($listAutomatic as $key => $sanPham): ?>
                                            <!-- product item start -->
                                            <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>">
                                                        <img class="pri-img" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                                    </a>
                                                    <div class="product-badge">
                                                        <?php
                                                        $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                                        $ngayHienTai = new DateTime();
                                                        $tinhNgay = $ngayHienTai->diff($ngayNhap);

                                                        if ($tinhNgay->days <= 1) {
                                                        ?>
                                                            <div class="product_label product_label_new" bis_skin_checked="1">
                                                                <div class="product_label__item" bis_skin_checked="1">
                                                                    <span>New</span>
                                                                </div>
                                                            </div>

                                                        <?php } ?>
                                                        <?php if ($sanPham['gia_khuyen_mai']) {
                                                            $phanTramGG = calcDiscountPercent($sanPham['gia_san_pham'], $sanPham['gia_khuyen_mai']); ?>
                                                            <div class="product-discount-label" bis_skin_checked="1">
                                                                <span>-<?= $phanTramGG ?>%</span>
                                                            </div>
                                                        <?php  } ?>

                                                    </div>
                                                    <div class="cart-hover" style="display: flex; justify-content: center; align-items: center;">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>" class="btn btn-cart">Xem chi tiết</a>
                                                        <!-- <button class="btn btn-cart">Xem chi tiết</button> -->
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham='  . $sanPham['id'] ?>"><?= $sanPham['ten_san_pham'] ?></a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <?php
                                                        $gia = $sanPham['gia_san_pham'] ?? $sanPham['gia'] ?? 0;
                                                        $gia_khuyen_mai = $sanPham['gia_khuyen_mai'] ?? $gia;
                                                        ?>
                                                        <?php if ($gia_khuyen_mai > 0 && $gia_khuyen_mai < $gia): ?>
                                                            <span class="price-old"><del><?= formatPrice($gia) ?>đ</del></span>
                                                            <span class="price-regular"><?= formatPrice($gia_khuyen_mai) ?>đ</span>
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
                                            <p>Hiện chưa có sản phẩm nào.</p>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <!-- quarzt -->
                            <div class="tab-pane fade show" id="tab2">
                                <div class="product-carousel-5 slick-row-10 slick-arrow-style">
                                    <?php if (!empty($listQuartz) && is_array($listQuartz)): ?>
                                        <?php foreach ($listQuartz as $key => $sanPham): ?>
                                            <!-- product item start -->
                                            <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>">
                                                        <img class="pri-img" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                                    </a>
                                                    <div class="product-badge">
                                                        <?php
                                                        $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                                        $ngayHienTai = new DateTime();
                                                        $tinhNgay = $ngayHienTai->diff($ngayNhap);

                                                        if ($tinhNgay->days <= 1) {
                                                        ?>
                                                            <div class="product_label product_label_new" bis_skin_checked="1">
                                                                <div class="product_label__item" bis_skin_checked="1">
                                                                    <span>New</span>
                                                                </div>
                                                            </div>

                                                        <?php } ?>
                                                        <?php if ($sanPham['gia_khuyen_mai']) {
                                                            $phanTramGG = calcDiscountPercent($sanPham['gia_san_pham'], $sanPham['gia_khuyen_mai']); ?>
                                                            <div class="product-discount-label" bis_skin_checked="1">
                                                                <span>-<?= $phanTramGG ?>%</span>
                                                            </div>
                                                        <?php  } ?>

                                                    </div>
                                                    <div class="cart-hover" style="display: flex; justify-content: center; align-items: center;">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>" class="btn btn-cart">Xem chi tiết</a>
                                                        <!-- <button class="btn btn-cart">Xem chi tiết</button> -->
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham='  . $sanPham['id'] ?>"><?= $sanPham['ten_san_pham'] ?></a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <?php
                                                        $gia = $sanPham['gia_san_pham'] ?? $sanPham['gia'] ?? 0;
                                                        $gia_khuyen_mai = $sanPham['gia_khuyen_mai'] ?? $gia;
                                                        ?>
                                                        <?php if ($gia_khuyen_mai > 0 && $gia_khuyen_mai < $gia): ?>
                                                            <span class="price-old"><del><?= formatPrice($gia) ?>đ</del></span>
                                                            <span class="price-regular"><?= formatPrice($gia_khuyen_mai) ?>đ</span>
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
                                            <p>Hiện chưa có sản phẩm nào.</p>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <!-- eco-drive -->
                            <div class="tab-pane fade show" id="tab3">
                                <div class="product-carousel-5 slick-row-10 slick-arrow-style">
                                    <?php if (!empty($listEco) && is_array($listEco)): ?>
                                        <?php foreach ($listEco as $key => $sanPham): ?>
                                            <!-- product item start -->
                                            <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>">
                                                        <img class="pri-img" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                                    </a>
                                                    <div class="product-badge">
                                                        <?php
                                                        $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                                        $ngayHienTai = new DateTime();
                                                        $tinhNgay = $ngayHienTai->diff($ngayNhap);

                                                        if ($tinhNgay->days <= 1) {
                                                        ?>
                                                            <div class="product_label product_label_new" bis_skin_checked="1">
                                                                <div class="product_label__item" bis_skin_checked="1">
                                                                    <span>New</span>
                                                                </div>
                                                            </div>

                                                        <?php } ?>
                                                        <?php if ($sanPham['gia_khuyen_mai']) {
                                                            $phanTramGG = calcDiscountPercent($sanPham['gia_san_pham'], $sanPham['gia_khuyen_mai']); ?>
                                                            <div class="product-discount-label" bis_skin_checked="1">
                                                                <span>-<?= $phanTramGG ?>%</span>
                                                            </div>
                                                        <?php  } ?>

                                                    </div>
                                                    <div class="cart-hover" style="display: flex; justify-content: center; align-items: center;">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>" class="btn btn-cart">Xem chi tiết</a>
                                                        <!-- <button class="btn btn-cart">Xem chi tiết</button> -->
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham='  . $sanPham['id'] ?>"><?= $sanPham['ten_san_pham'] ?></a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <?php
                                                        $gia = $sanPham['gia_san_pham'] ?? $sanPham['gia'] ?? 0;
                                                        $gia_khuyen_mai = $sanPham['gia_khuyen_mai'] ?? $gia;
                                                        ?>
                                                        <?php if ($gia_khuyen_mai > 0 && $gia_khuyen_mai < $gia): ?>
                                                            <span class="price-old"><del><?= formatPrice($gia) ?>đ</del></span>
                                                            <span class="price-regular"><?= formatPrice($gia_khuyen_mai) ?>đ</span>
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
                                            <p>Hiện chưa có sản phẩm nào.</p>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <!-- sport -->
                            <div class="tab-pane fade show" id="tab4">
                                <div class="product-carousel-5 slick-row-10 slick-arrow-style">
                                    <?php if (!empty($listSport) && is_array($listSport)): ?>
                                        <?php foreach ($listSport as $key => $sanPham): ?>
                                            <!-- product item start -->
                                            <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>">
                                                        <img class="pri-img" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                                    </a>
                                                    <div class="product-badge">
                                                        <?php
                                                        $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                                        $ngayHienTai = new DateTime();
                                                        $tinhNgay = $ngayHienTai->diff($ngayNhap);

                                                        if ($tinhNgay->days <= 1) {
                                                        ?>
                                                            <div class="product_label product_label_new" bis_skin_checked="1">
                                                                <div class="product_label__item" bis_skin_checked="1">
                                                                    <span>New</span>
                                                                </div>
                                                            </div>

                                                        <?php } ?>
                                                        <?php if ($sanPham['gia_khuyen_mai']) {
                                                            $phanTramGG = calcDiscountPercent($sanPham['gia_san_pham'], $sanPham['gia_khuyen_mai']); ?>
                                                            <div class="product-discount-label" bis_skin_checked="1">
                                                                <span>-<?= $phanTramGG ?>%</span>
                                                            </div>
                                                        <?php  } ?>

                                                    </div>
                                                    <div class="cart-hover" style="display: flex; justify-content: center; align-items: center;">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>" class="btn btn-cart">Xem chi tiết</a>
                                                        <!-- <button class="btn btn-cart">Xem chi tiết</button> -->
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham='  . $sanPham['id'] ?>"><?= $sanPham['ten_san_pham'] ?></a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <?php
                                                        $gia = $sanPham['gia_san_pham'] ?? $sanPham['gia'] ?? 0;
                                                        $gia_khuyen_mai = $sanPham['gia_khuyen_mai'] ?? $gia;
                                                        ?>
                                                        <?php if ($gia_khuyen_mai > 0 && $gia_khuyen_mai < $gia): ?>
                                                            <span class="price-old"><del><?= formatPrice($gia) ?>đ</del></span>
                                                            <span class="price-regular"><?= formatPrice($gia_khuyen_mai) ?>đ</span>
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
                                            <p>Hiện chưa có sản phẩm nào.</p>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <!-- smartwatch -->
                            <div class="tab-pane fade show" id="tab5">
                                <div class="product-carousel-5 slick-row-10 slick-arrow-style">
                                    <?php if (!empty($listSmart) && is_array($listSmart)): ?>
                                        <?php foreach ($listSmart as $key => $sanPham): ?>
                                            <!-- product item start -->
                                            <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>">
                                                        <img class="pri-img" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                                    </a>
                                                    <div class="product-badge">
                                                        <?php
                                                        $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                                        $ngayHienTai = new DateTime();
                                                        $tinhNgay = $ngayHienTai->diff($ngayNhap);

                                                        if ($tinhNgay->days <= 1) {
                                                        ?>
                                                            <div class="product_label product_label_new" bis_skin_checked="1">
                                                                <div class="product_label__item" bis_skin_checked="1">
                                                                    <span>New</span>
                                                                </div>
                                                            </div>

                                                        <?php } ?>
                                                        <?php if ($sanPham['gia_khuyen_mai']) {
                                                            $phanTramGG = calcDiscountPercent($sanPham['gia_san_pham'], $sanPham['gia_khuyen_mai']); ?>
                                                            <div class="product-discount-label" bis_skin_checked="1">
                                                                <span>-<?= $phanTramGG ?>%</span>
                                                            </div>
                                                        <?php  } ?>

                                                    </div>
                                                    <div class="cart-hover" style="display: flex; justify-content: center; align-items: center;">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>" class="btn btn-cart">Xem chi tiết</a>
                                                        <!-- <button class="btn btn-cart">Xem chi tiết</button> -->
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham='  . $sanPham['id'] ?>"><?= $sanPham['ten_san_pham'] ?></a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <?php
                                                        $gia = $sanPham['gia_san_pham'] ?? $sanPham['gia'] ?? 0;
                                                        $gia_khuyen_mai = $sanPham['gia_khuyen_mai'] ?? $gia;
                                                        ?>
                                                        <?php if ($gia_khuyen_mai > 0 && $gia_khuyen_mai < $gia): ?>
                                                            <span class="price-old"><del><?= formatPrice($gia) ?>đ</del></span>
                                                            <span class="price-regular"><?= formatPrice($gia_khuyen_mai) ?>đ</span>
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
                                            <p>Hiện chưa có sản phẩm nào.</p>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <!-- product tab content end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product area end -->

    <!-- product banner statistics area start -->
    <section class="product-banner-statistics">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="product-banner-carousel slick-row-10">
                        <!-- banner single slide start -->
                        <div class="banner-slide-item">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="https://cdn.luxshopping.vn/Thumnails/Uploads/Advs/versace16.png.webp" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="#">AUTOMATIC</a></h5>
                                </div>
                            </figure>
                        </div>
                        <!-- banner single slide start -->
                        <!-- banner single slide start -->
                        <div class="banner-slide-item">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="https://cdn.luxshopping.vn/Thumnails/Uploads/Advs/tissot15.png.webp" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="#">QUARZT</a></h5>
                                </div>
                            </figure>
                        </div>
                        <!-- banner single slide start -->
                        <!-- banner single slide start -->
                        <div class="banner-slide-item">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="https://cdn.luxshopping.vn/Thumnails/Uploads/Advs/bulova25.png.webp" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="#">ECO-DRIVE</a></h5>
                                </div>
                            </figure>
                        </div>
                        <!-- banner single slide start -->
                        <!-- banner single slide start -->
                        <div class="banner-slide-item">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="	https://cdn.luxshopping.vn/Thumnails/Uploads/Advs/longines17.png.webp" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="">SPORT</a></h5>
                                </div>
                            </figure>
                        </div>
                        <!-- banner single slide start -->
                        <!-- banner single slide start -->
                        <div class=" banner-slide-item">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="	https://cdn.luxshopping.vn/Thumnails/Uploads/Advs/michael-kors7.png.webp" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="#">SMARTWATCH</a></h5>
                                </div>
                            </figure>
                        </div>
                        <!-- banner single slide start -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product banner statistics area end -->

    <!-- hot product area start -->
    <section class="feature-product section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-wrapper--block" bis_skin_checked="1">
                        <h2 class="title-wapper">
                            <span>SẢN PHẨM BÁN CHẠY</span>
                        </h2>
                        <div class="product-nav--btn" bis_skin_checked="1">
                            <a href="#" class="btn-swicth btn-active">Đồng hồ nam</a>
                            <a href="#" class="btn-swicth">Đồng hồ nữ</a>
                        </div>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-5_2 slick-row-10 slick-arrow-style">
                        <?php foreach ($listSanPhamBanChay as $sanPham): ?>
                            <!-- product item start -->
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a class="product-thumb-link" href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' .  $sanPham['id'] ?>">
                                        <img class="pri-img" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                        <div class="product-badge">
                                            <?php
                                            $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                            $ngayHienTai = new DateTime();
                                            $tinhNgay = $ngayHienTai->diff($ngayNhap);

                                            if ($tinhNgay->days <= 1) {
                                            ?>
                                                <div class="product_label product_label_new" bis_skin_checked="1">
                                                    <div class="product_label__item" bis_skin_checked="1">
                                                        <span>New</span>
                                                    </div>
                                                </div>

                                            <?php } ?>
                                            <?php if ($sanPham['gia_khuyen_mai']) {
                                                $phanTramGG = calcDiscountPercent($sanPham['gia_san_pham'], $sanPham['gia_khuyen_mai']); ?>
                                                <div class="product-discount-label" bis_skin_checked="1">
                                                    <span>-<?= $phanTramGG ?>%</span>
                                                </div>
                                            <?php  } ?>

                                        </div>
                                    </a>
                                    <div class="button-group">
                                        <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-placement="left"><i class="pe-7s-like"></i></a>
                                    </div>
                                </figure>
                                <div class="product-caption text-center">
                                    <h6 class="product-name">
                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' .  $sanPham['id'] ?>"><?= $sanPham['ten_san_pham'] ?></a>
                                    </h6>
                                    <p style="  color: #921817;font-weight:600; font-size:12px;"><?= $sanPham['code'] ?></p>
                                    <div class="product-des" bis_skin_checked="1">
                                        <span><?= $sanPham['kich_thuoc'] ?></span>
                                        <span><?= $sanPham['loai_may'] ?></span>
                                    </div>
                                    <div class="price-box">
                                        <p class="price-old"><del><?= number_format($sanPham['gia_san_pham'], 0, ",", ".") . "đ" ?></del></p>
                                        <p class="price-regular">
                                            <span>Giá KM:</span>
                                            <span><?= number_format($sanPham['gia_khuyen_mai'], 0, ",", ".") . "đ" ?></span>
                                        </p>
                                    </div>
                                </div>
                                <?php if (isset($_SESSION['user']) && $_SESSION['user']) { ?>
                                    <a href="?act=gio-hang&id=<?= $sanPham['id'] ?>" class="btn-addToCard">
                                        Thêm vào giỏ
                                    </a>
                                <?php } else { ?>
                                    <a href="?act=login" class="btn-addToCard">
                                        Thêm vào giỏ
                                    </a>
                                <?php } ?>

                            </div>
                            <!-- product item end -->
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- hot product area end -->

    <!-- new product area start -->
    <section class="feature-product section-padding" style="padding-top:0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-wrapper--block" bis_skin_checked="1">
                        <h2 class="title-wapper">
                            <span>SẢN PHẨM MỚI</span>
                        </h2>
                        <div class="product-nav--btn" bis_skin_checked="1">
                            <a href="#" class="btn-swicth btn-active">Đồng hồ nam</a>
                            <a href="#" class="btn-swicth">Đồng hồ nữ</a>
                        </div>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-5_2 slick-row-10 slick-arrow-style">
                        <?php foreach ($listSanPhamBanChay as $sanPham): ?>
                            <!-- product item start -->
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a class="product-thumb-link" href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' .  $sanPham['id'] ?>">
                                        <img class="pri-img" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                        <div class="product-badge">
                                            <?php
                                            $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                            $ngayHienTai = new DateTime(); ?>
                                            <div class="product_label product_label_new" bis_skin_checked="1">
                                                <div class="product_label__item" bis_skin_checked="1">
                                                    <span>New</span>
                                                </div>
                                            </div>


                                            <?php if ($sanPham['gia_khuyen_mai']) {
                                                $phanTramGG = calcDiscountPercent($sanPham['gia_san_pham'], $sanPham['gia_khuyen_mai']); ?>
                                                <div class="product-discount-label" bis_skin_checked="1">
                                                    <span>-<?= $phanTramGG ?>%</span>
                                                </div>
                                            <?php  } ?>

                                        </div>
                                    </a>
                                    <div class="button-group">
                                        <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-placement="left"><i class="pe-7s-like"></i></a>
                                    </div>
                                </figure>
                                <div class="product-caption text-center">
                                    <h6 class="product-name">
                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' .  $sanPham['id'] ?>"><?= $sanPham['ten_san_pham'] ?></a>
                                    </h6>
                                    <p style="  color: #921817;font-weight:600; font-size:12px;"><?= $sanPham['code'] ?></p>
                                    <div class="product-des" bis_skin_checked="1">
                                        <span><?= $sanPham['kich_thuoc'] ?></span>
                                        <span><?= $sanPham['loai_may'] ?></span>
                                    </div>
                                    <div class="price-box">
                                        <p class="price-old"><del><?= number_format($sanPham['gia_san_pham'], 0, ",", ".") . "đ" ?></del></p>
                                        <p class="price-regular">
                                            <span>Giá KM:</span>
                                            <span><?= number_format($sanPham['gia_khuyen_mai'], 0, ",", ".") . "đ" ?></span>
                                        </p>
                                    </div>
                                </div>
                                <?php if (isset($_SESSION['user']) && $_SESSION['user']) { ?>
                                    <a href="?act=gio-hang&id=<?= $sanPham['id'] ?>" class="btn-addToCard">
                                        Thêm vào giỏ
                                    </a>
                                <?php } else { ?>
                                    <a href="?act=login" class="btn-addToCard">
                                        Thêm vào giỏ
                                    </a>
                                <?php } ?>

                            </div>
                            <!-- product item end -->
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- new product area end -->

    <!-- latest blog area start -->
    <section class="latest-blog-area section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">latest blogs</h2>
                        <p class="sub-title">There are latest blog posts</p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="blog-carousel-active slick-row-10 slick-arrow-style">
                        <!-- blog post item start -->
                        <div class="blog-post-item">
                            <figure class="blog-thumb">
                                <a href="blog-details.html">
                                    <img src="assets/img/blog/blog-img1.jpg" alt="blog image">
                                </a>
                            </figure>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <p>25/03/2019 | <a href="#">Corano</a></p>
                                </div>
                                <h5 class="blog-title">
                                    <a href="blog-details.html">Celebrity Daughter Opens Up About Having Her Eye Color Changed</a>
                                </h5>
                            </div>
                        </div>
                        <!-- blog post item end -->

                        <!-- blog post item start -->
                        <div class="blog-post-item">
                            <figure class="blog-thumb">
                                <a href="blog-details.html">
                                    <img src="assets/img/blog/blog-img2.jpg" alt="blog image">
                                </a>
                            </figure>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <p>25/03/2019 | <a href="#">Corano</a></p>
                                </div>
                                <h5 class="blog-title">
                                    <a href="blog-details.html">Children Left Home Alone For 4 Days In TV series Experiment</a>
                                </h5>
                            </div>
                        </div>
                        <!-- blog post item end -->

                        <!-- blog post item start -->
                        <div class="blog-post-item">
                            <figure class="blog-thumb">
                                <a href="blog-details.html">
                                    <img src="assets/img/blog/blog-img3.jpg" alt="blog image">
                                </a>
                            </figure>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <p>25/03/2019 | <a href="#">Corano</a></p>
                                </div>
                                <h5 class="blog-title">
                                    <a href="blog-details.html">Lotto Winner Offering Up Money To Any Man That Will Date Her</a>
                                </h5>
                            </div>
                        </div>
                        <!-- blog post item end -->

                        <!-- blog post item start -->
                        <div class="blog-post-item">
                            <figure class="blog-thumb">
                                <a href="blog-details.html">
                                    <img src="assets/img/blog/blog-img4.jpg" alt="blog image">
                                </a>
                            </figure>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <p>25/03/2019 | <a href="#">Corano</a></p>
                                </div>
                                <h5 class="blog-title">
                                    <a href="blog-details.html">People are Willing Lie When Comes Money, According to Research</a>
                                </h5>
                            </div>
                        </div>
                        <!-- blog post item end -->

                        <!-- blog post item start -->
                        <div class="blog-post-item">
                            <figure class="blog-thumb">
                                <a href="blog-details.html">
                                    <img src="assets/img/blog/blog-img5.jpg" alt="blog image">
                                </a>
                            </figure>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <p>25/03/2019 | <a href="#">Corano</a></p>
                                </div>
                                <h5 class="blog-title">
                                    <a href="blog-details.html">romantic Love Stories Of Hollywoodâ€™s Biggest Celebrities</a>
                                </h5>
                            </div>
                        </div>
                        <!-- blog post item end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- latest blog area end -->

    <!-- brand logo area start -->
    <div class="brand-logo section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="brand-logo-carousel slick-row-10 slick-arrow-style">
                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/1.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/2.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/3.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/4.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/5.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/6.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- brand logo area end -->
</main>


<?php require_once 'layout/miniCart.php' ?>

<?php require_once 'layout/footer.php' ?>