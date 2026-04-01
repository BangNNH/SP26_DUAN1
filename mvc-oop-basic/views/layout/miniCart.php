<!-- offcanvas mini cart start -->
<?php $cart = getCartFromSession(); ?>
<div class="offcanvas-minicart-wrapper mini-cart">
    <div class="minicart-inner">
        <div class="offcanvas-overlay"></div>
        <div class="minicart-inner-content">
            <div class="minicart-close">
                <i class="pe-7s-close"></i>
            </div>
            <div class="minicart-content-box">
                <div class="minicart-item-wrapper">
                    <ul>
                        <?php if (!empty($cart)): ?>
                            <?php foreach ($cart as $item): ?>
                                <li class="minicart-item">
                                    <div class="minicart-thumb">
                                        <img src="<?= BASE_URL . $item['hinh_anh'] ?>">
                                    </div>

                                    <div class="minicart-content">
                                        <h3><?= $item['ten_san_pham'] ?></h3>

                                        <!-- <p>
                                            <?= $item['so_luong'] ?> ×
                                            <?= formatPrice($item['gia_san_pham']) ?>đ
                                        </p> -->
                                        <div class="product-item-pricing">
                                            <div class="details-qty details-qty-box">
                                                <label for="">Số lượng</label>
                                                <div class="quantity-control">
                                                    <button type="button" class="btn-subtract-session" data-id="<?= $item['san_pham_id'] ?>">−</button>

                                                    <input type="text" class="qty-input" data-id="<?= $item['san_pham_id'] ?>" value="<?= $item['so_luong'] ?>" readonly>

                                                    <button type="button" class="btn-increase-session" data-id="<?= $item['san_pham_id'] ?>">+</button>
                                                </div>

                                                <button type="button" class="btn-delete-pd-session" data-id="<?= $item['san_pham_id'] ?>">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>
                                            <div class="product-info-price">
                                                <label for="">Giá</label>
                                                <span> <?= formatPrice($item['gia_san_pham']) ?>đ</span>
                                            </div>
                                        </div>

                                    </div>
                                </li>

                            <?php endforeach; ?>
                            <div class="minicart-pricing-box" id="cart-summary">
                                <ul>
                                    <li>
                                        <span>Tạm tính</span>
                                        <span id="tam-tinh"><?= isset($_SESSION['tamTinh']) ? $_SESSION['tamTinh'] : 0  ?></span>
                                    </li>
                                    <li>
                                        <span>Giảm giá</span>
                                        <span id="giam-gia"><?= isset($_SESSION['giamGia']) ? $_SESSION['giamGia'] : 0  ?></span>
                                    </li>
                                    <li class="total" style="font-weight: bold;">
                                        <span>Tổng thanh toán</span>
                                        <span id="thanh-toan"><?= isset($_SESSION['thanhToan']) ? $_SESSION['thanhToan'] : 0  ?></span>
                                    </li>
                                </ul>
                                <div class="minicart-button">
                                    <a href="<?= BASE_URL . '?act=thanh-toan' ?>"><i class="fa fa-shopping-cart"></i> Thanh toán</a>
                                    <a href="<?= BASE_URL . '?act=/' ?>"><i class="fa fa-share"></i>Tiếp tục mua sắm</a>
                                </div>
                            </div>
                            <div id="empty-cart" style="display: none;">
                                Không có sản phẩm nào trong giỏ hàng của bạn
                            </div>

                        <?php else: ?>
                            <div style="display: block;">
                                Không có sản phẩm nào trong giỏ hàng của bạn
                            </div>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- <div id="empty-cart" style="display: none;">
                    Không có sản phẩm nào trong giỏ hàng của bạn
                </div> -->

            </div>
        </div>
    </div>
</div>
<!-- offcanvas mini cart end -->