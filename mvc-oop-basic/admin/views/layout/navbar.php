<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= BASE_URL ?>" class="nav-link">Website</a>
        </li>
    </ul>

    <!-- Tìm kiếm -->
    <ul class="navbar-nav">
        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Search -->

    </ul>

    <ul class="navbar-nav ml-auto">
        <div class="d-flex align-items-center gap-4">
            <div class="search-container d-none d-lg-block">
                <span class="material-symbols-outlined">search</span>
                <input placeholder="Tìm kiếm sản phẩm..." type="text" />
            </div>
        </div>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Điều hướng thông báo -->

        <li class="nav-item">
            <a class="btn btn-link p-0 text-secondary position-relative" href="#" role="button">
                <span class="material-symbols-outlined nav-link">notifications</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="d-flex gap-3 nav-link" href="#" role="button">
                <button class="btn btn-link p-0 text-secondary">
                    <span class="material-symbols-outlined">mail</span>
                </button>
            </a>
        </li>

        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL_ADMIN . '?act=login-admin' ?>#"
                onclick="return confirm('Đăng xuất tài khoản?')">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->