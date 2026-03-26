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
                                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="shop.html">Danh sách sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- cart main wrapper start -->
    <div class="cart-main-wrapper section-padding pt-2">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Cart Table Area -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Ảnh sản phẩm</th>
                                        <th class="pro-title">Tên sản phẩm</th>
                                        <th class="pro-price">Giá tiền</th>
                                        <th class="pro-quantity">Số lượng</th>
                                        <th class="pro-subtotal">Tổng tiền</th>
                                        <th class="pro-remove">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tongGioHang = 0;
                                    foreach ($chiTietGioHang as $key => $sanPham):
                                    ?>
                                        <tr>
                                            <td class="pro-thumbnail"><a href="#"><img class="img-fluid" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="Product" /></a></td>
                                            <td class="pro-title"><a href="#"><?= $sanPham['ten_san_pham'] ?></a></td>
                                            <td class="pro-price">
                                                <?php
                                                $gia = $sanPham['gia_san_pham'] ?? 0;
                                                $gia_khuyen_mai = $sanPham['gia_khuyen_mai'] ?? $gia;
                                                ?>
                                                <?php if ($gia_khuyen_mai > 0 && $gia_khuyen_mai < $gia): ?>
                                                    <span class="price-old"><del><?= formatPrice($gia) ?>đ</del></span>
                                                    <span class="price-regular"><?= formatPrice($gia_khuyen_mai) ?>đ</span>
                                                <?php else: ?>
                                                    <span class="price-regular"><?= formatPrice($gia) ?>đ</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="pro-quantity">
                                                <form action="?act=cap-nhat-gio-hang" method="POST" class="quantity-form">
                                                    <input type="hidden" name="san_pham_id" value="<?= $sanPham['san_pham_id'] ?>">
                                                    <div class="quantity-control">
                                                        <button id="btn-subtract" type="submit" name="action" value="decrease">−</button>
                                                        <input type="text" name="so_luong_hien_tai" value="<?= $sanPham['so_luong'] ?>">
                                                        <button id="btn-plus" type="submit" name="action" value="increase">+</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="pro-subtotal">
                                                <span>
                                                    <?php
                                                    $tong_tien = 0;
                                                    if ($sanPham['gia_khuyen_mai']) {
                                                        $tong_tien = $sanPham['gia_khuyen_mai'] * $sanPham['so_luong'];
                                                    } else {
                                                        $tong_tien = $sanPham['gia_san_pham'] * $sanPham['so_luong'];
                                                    }
                                                    $tongGioHang += $tong_tien;
                                                    echo formatPrice($tong_tien) . "đ";
                                                    ?>
                                                </span>
                                            </td>
                                            <td class="pro-remove">
                                                <form action="?act=xoa-item-gio-hang" method="POST">
                                                    <input type="hidden" name="san_pham_id" value="<?= $sanPham['san_pham_id'] ?>">
                                                    <button id="btn-plus" type="submit" name="submit_delete" value="increase"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Cart Update Option -->
                        <div class="col-lg-5 ml-auto" style="float: right;">
                            <!-- Cart Calculation Area -->
                            <div class="cart-calculator-wrapper">
                                <div class="cart-calculate-items">
                                    <h6>Tổng đơn hàng</h6>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td>Tổng tiền sản phẩm</td>
                                                <td><?= formatPrice($tongGioHang) . "đ" ?></td>
                                            </tr>
                                            <tr>
                                                <td>Vận chuyển</td>
                                                <td>30.000đ</td>
                                            </tr>
                                            <tr class="total">
                                                <td>Tổng thanh toán</td>
                                                <td class="total-amount"><?= formatPrice($tongGioHang + 30000) . "đ" ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <a href="<?= BASE_URL . '?act=thanh-toan' ?>" class="btn btn-sqr d-block">Đặt Hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart main wrapper end -->
</main>


<?php require_once 'layout/miniCart.php' ?>

<?php require_once 'layout/footer.php' ?>