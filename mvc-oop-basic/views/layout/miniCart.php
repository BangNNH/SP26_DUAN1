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
                        <?php $tamTinh = 0;
                        $giamGia = 0;
                        $thanhToan = 0;
                        $countSl = 0; ?>
                        <?php if (!empty($cart)): ?>
                            <?php foreach ($cart as $item):
                                $tamTinh += $item['gia_san_pham'] * $item['so_luong'];
                                $giamGia += ($item['gia_san_pham'] - $item['gia_khuyen_mai'])  * $item['so_luong'];
                                $thanhToan  = $tamTinh - $giamGia;
                                $countSl += $item['so_luong'];
                            ?>
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
                                            <div class="details-qty">
                                                <label for="">Số lượng</label>
                                                <div class="quant">
                                                    <form action="?act=cap-nhat-gio-hang-session" method="POST" class="quantity-form">
                                                        <input type="hidden" name="san_pham_id" value="<?= $item['san_pham_id'] ?>">
                                                        <div class="quantity-control">
                                                            <button id="btn-subtract-session" type="submit" name="action" value="decrease">−</button>
                                                            <input type="text" name="so_luong_hien_tai" value="<?= $item['so_luong'] ?>">
                                                            <button id="btn-plus-session" type="submit" name="action" value="increase">+</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="remove-product-session">
                                                    <form action="?act=xoa-gio-hang-session" method="POST">
                                                        <input type="hidden" name="san_pham_id" value="<?= $item['san_pham_id'] ?>">
                                                        <button id="btn-delete" type="submit" name="submit_delete" value="remove"><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="product-info-price">
                                                <label for="">Giá</label>
                                                <span> <?= formatPrice($item['gia_san_pham']) ?>đ</span>
                                            </div>
                                        </div>

                                    </div>
                                </li>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Giỏ hàng trống</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="minicart-pricing-box">
                    <ul>
                        <li>
                            <span>Tạm tính</span>
                            <span><strong><?= formatPrice($tamTinh)  ?> VNĐ</strong></span>
                        </li>
                        <li>
                            <span>Giảm giá</span>
                            <span><strong><?= formatPrice($giamGia)  ?> VNĐ</strong></span>
                        </li>
                        <li class="total" style="font-weight: bold;">
                            <span>Tổng thanh toán</span>
                            <span style="font-weight: bold; color: #921918"><?= formatPrice($thanhToan)  ?> VNĐ</span>
                        </li>
                    </ul>
                </div>

                <div class="minicart-button">
                    <a href="<?= BASE_URL . '?act=thanh-toan' ?>"><i class="fa fa-shopping-cart"></i> Thanh toán</a>
                    <a href="<?= BASE_URL . '?act=/' ?>"><i class="fa fa-share"></i>Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- offcanvas mini cart end -->