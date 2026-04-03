<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <?php
        $adminInfo = [];
        if (isset($_SESSION['user_admin'])) {
            $taiKhoanModel = new AdminTaiKhoan();
            $adminInfo = $taiKhoanModel->getTaiKhoanformEmail($_SESSION['user_admin']);
        }
        ?>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= !empty($adminInfo['anh_dai_dien']) ? BASE_URL . $adminInfo['anh_dai_dien'] : BASE_URL_ADMIN . 'assets/dist/img/user2-160x160.jpg' ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?= htmlspecialchars($adminInfo['ho_ten'] ?? ($_SESSION['user_admin'] ?? 'Admin')) ?>
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= BASE_URL_ADMIN ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Thống kê
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL_ADMIN . '?act=danh-muc' ?>" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh mục sản phẩm
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL_ADMIN . '?act=san-pham' ?>" class="nav-link">
                        <i class=" nav-icon fas fa-cat"></i>
                        <p>
                            Sản phẩm
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav icon fas fa-user " style="display: inline-block; padding:0 9px 0 5px;"></i>
                        <p>Quản lý tài khoản</p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri' ?>" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Tài khoản quản trị</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang' ?>" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Tài khoản khách hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-admin' ?>" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Tài khoản cá nhân</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL_ADMIN . '?act=don-hang' ?>" class="nav-link">
                        <i class=" nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Đơn hàng
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL_ADMIN . '?act=quan-ly-binh-luan' ?>" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Quản lý bình luận
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL_ADMIN . '?act=logout-admin' ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Đăng xuất
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>