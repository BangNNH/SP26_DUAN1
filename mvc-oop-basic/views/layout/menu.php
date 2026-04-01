<div class="sticky">
    <header class="header-wrapper">
        <div class="header-content">
            <div class="header-contact">
                <a href="#"><i class="fi fi-rr-marker"></i><span>Hệ thống cửa hàng</span></a>
                <a href="#"><i class="fi fi-rr-phone-call"></i><span>1800 6785</span></a>
            </div>
            <div class="header-logo">
                <a href="?action=/"><img src="<?= BASE_ASSETS_IMG . 'logo/main-logo.png' ?>" alt="header logo"></a>
            </div>
            <!-- mini cart area start -->
            <div class="col-lg-4">
                <div
                    class="header-right d-flex align-items-center justify-content-xl-between justify-content-lg-end">
                    <div class="header-search-container">
                        <button class="search-trigger d-xl-none d-lg-block"><i
                                class="pe-7s-search"></i></button>
                        <form class="header-search-box d-lg-none d-xl-block">
                            <input type="text" placeholder="Nhập tên sản phẩm" class="header-search-field">
                            <button class="header-search-btn"><i class="pe-7s-search"></i></button>
                        </form>
                    </div>
                    <div class="header-configure-area">
                        <ul class="nav justify-content-end">
                            <li class="user-hover">
                                <a href="#">
                                    <i class="pe-7s-user"></i>
                                </a>
                                <ul class="dropdown-list">
                                    <?php
                                    if (!isset($_SESSION['user_client'])) { ?>
                                        <li><a href="<?= BASE_URL . '?act=login' ?>">Đăng nhập</a></li>
                                    <?php } else {
                                    ?>
                                        <li><a href="<?= BASE_URL . '?act=tai-khoan' ?>">Tài khoản</a></li>
                                        <li><a href="<?= BASE_URL . '?act=lich-su-mua-hang' ?>">Đơn hàng</a></li>
                                        <li><a href="<?= BASE_URL . '?act=logout' ?>">Đăng xuất</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li>
                                <a href="wishlist.html">
                                    <i class="pe-7s-like"></i>
                                    <div class="notification">0</div>
                                </a>
                            </li>
                            <li>
                                <?php if (isset($_SESSION['user_client'])): ?>
                                    <!--Đã login -->
                                    <a href="<?= BASE_URL . '?act=gio-hang' ?>">
                                        <i class="pe-7s-shopbag"></i>
                                        <div class="notification"><?= $soLuongCart ?? 0 ?></div>
                                    </a>
                                <?php else: ?>
                                    <!--Chưa login -->
                                    <a href="#" class="minicart-btn">
                                        <i class="pe-7s-shopbag"></i>
                                        <div class="notification" id="cart-count"><?= isset($_SESSION['tong_so_luong']) ? $_SESSION['tong_so_luong'] : 0 ?></div>
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- mini cart area end -->
        </div>
    </header>
    <nav class="nav-main-wrapper">
        <div class="nav-main">
            <ul class="nav-main-menu">
                <li><a href="?action=/" class="menu-link"><i class="fi fi-rr-home"></i><span></span></a>
                </li>
                <li><a href="?act=san-pham" class="menu-link"><i class="fi fi-rr-watch"></i><span>SẢN PHẨM</span></a>
                </li>
                <li><a href="#" class="menu-link"><i class="fi fi-rr-marker-time"></i><span>PHỤ
                            KIỆN</span></a>
                </li>
                <li><a href="#" class="menu-link menu-link--service"><i
                            class="fi fi-rr-wrench-simple"></i><span>DỊCH VỤ</span></a>
                </li>
                <li><a href="#" class="menu-link"><i class="fi fi-rr-calendar-star"></i></i><span>TIN
                            TỨC</span></a>
                </li>
                <li><a href="#" class="menu-link"><i class="fi fi-rr-sparkles"></i><span>LIÊN
                            HỆ</span></a>
                </li>
            </ul>
        </div>
    </nav>
</div>