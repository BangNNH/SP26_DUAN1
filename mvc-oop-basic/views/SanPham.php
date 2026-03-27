<?php require_once 'layout/header.php' ?>
<?php require_once 'layout/menu.php' ?>

<main>
    <!-- Product Listing Section Start -->
    <div class="product-listing-section py-5 mb-5" style="background-color: #f8f9fa;">
        <div class="container">
            <!-- Page Title -->
            <div class="text-center mb-5 pt-3">
                <h1 class="page-title mb-2">Danh Sách Sản Phẩm</h1>
                <p class="text-muted">Khám phá bộ sưu tập đồng hồ cao cấp của chúng tôi</p>
            </div>

            <!-- Filters Section -->
            <div class="filters-section mb-5">
                <form method="GET" id="filterForm" class="filter-form">
                    <input type="hidden" name="act" value="san-pham">
                    
                    <div class="row g-3 align-items-end">
                        <!-- Search Input -->
                        <div class="col-lg-4 col-md-6">
                            <label for="searchInput" class="form-label fw-bold">Tìm kiếm sản phẩm</label>
                            <input type="text" class="form-control form-control-lg" id="searchInput" 
                                   name="search" placeholder="Nhập tên sản phẩm..." 
                                   value="<?= htmlspecialchars($searchKeyword) ?>"
                                   style="border-radius: 8px; border: 2px solid #e0e0e0;">
                        </div>

                        <!-- Price Range -->
                        <div class="col-lg-3 col-md-6">
                            <label for="minPrice" class="form-label fw-bold">Khoảng giá (VNĐ)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="minPrice" name="min_price" 
                                       placeholder="Từ" min="0" value="<?= htmlspecialchars($minPrice) ?>"
                                       style="border-radius: 8px 0 0 8px; border: 2px solid #e0e0e0;">
                                <span class="input-group-text" style="border: none; background-color: #f8f9fa;">-</span>
                                <input type="number" class="form-control" id="maxPrice" name="max_price" 
                                       placeholder="Đến" value="<?= htmlspecialchars($maxPrice < 999999999 ? $maxPrice : '') ?>"
                                       style="border-radius: 0 8px 8px 0; border: 2px solid #e0e0e0;">
                            </div>
                        </div>

                        <!-- Product Type Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="typeFilter" class="form-label fw-bold">Loại đồng hồ</label>
                            <select class="form-select form-select-lg" id="typeFilter" name="type"
                                    style="border-radius: 8px; border: 2px solid #e0e0e0;">
                                <option value="">-- Tất cả loại --</option>
                                <?php if (!empty($productTypes)): ?>
                                    <?php foreach ($productTypes as $item): ?>
                                        <option value="<?= htmlspecialchars($item['loai_may']) ?>" 
                                                <?= ($productType === $item['loai_may']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($item['loai_may']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-lg-2 col-md-6 d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" 
                                    style="border-radius: 8px; background-color: #1a1a1a; border: none; font-weight: 600;">
                                <i class="fa fa-search me-2"></i> Tìm kiếm
                            </button>
                        </div>
                    </div>

                    <!-- Reset Link -->
                    <div class="mt-3 text-center">
                        <a href="?act=san-pham" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-redo me-2"></i> Đặt lại bộ lọc
                        </a>
                    </div>
                </form>
            </div>

            <!-- Results Info -->
            <div class="results-info mb-4">
                <p class="text-muted">
                    <strong>Tìm thấy <?= count($listSanPham) ?> sản phẩm</strong>
                    <?php if (!empty($searchKeyword)): ?>
                        cho từ khóa "<strong><?= htmlspecialchars($searchKeyword) ?></strong>"
                    <?php endif; ?>
                    <?php if (!empty($productType)): ?>
                        trong danh mục "<strong><?= htmlspecialchars($productType) ?></strong>"
                    <?php endif; ?>
                </p>
            </div>

            <!-- Products Grid -->
            <?php if (!empty($listSanPham)): ?>
                <div class="products-grid">
                    <div class="row g-4">
                        <?php foreach ($listSanPham as $sanPham): ?>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="product-item">
                                    <figure class="product-thumb">
                                        <a class="product-thumb-link" href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>">
                                            <img class="pri-img" src="<?= htmlspecialchars($sanPham['hinh_anh'] ? BASE_URL . $sanPham['hinh_anh'] : BASE_URL . 'assets/img/avatar_default.jpg') ?>"
                                                 alt="<?= htmlspecialchars($sanPham['ten_san_pham']) ?>"
                                                 onerror="this.src='<?= BASE_URL . 'assets/img/avatar_default.jpg' ?>'">
                                            <div class="product-badge">
                                                <?php if ($sanPham['is_new'] == 1): ?>
                                                    <div class="product_label product_label_new">
                                                        <div class="product_label__item"><span>New</span></div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ($sanPham['is_hot'] == 1): ?>
                                                    <div class="product_label product_label_hot">
                                                        <div class="product_label__item"><span>Hot</span></div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                        <div class="button-group">
                                            <a href="#" class="text-decoration-none"><i class="pe-7s-like"></i></a>
                                        </div>
                                    </figure>
                                    <div class="product-caption text-center">
                                        <h6 class="product-name">
                                            <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>"><?= htmlspecialchars($sanPham['ten_san_pham']) ?></a>
                                        </h6>
                                        <p class="product-code" style="color:#921817;font-weight:600;font-size:12px;"><?= htmlspecialchars($sanPham['code'] ?? '') ?></p>
                                        <div class="product-des">
                                            <span><?= htmlspecialchars($sanPham['kich_thuoc'] ?? '') ?></span>
                                            <span><?= htmlspecialchars($sanPham['loai_may'] ?? '') ?></span>
                                        </div>
                                        <div class="price-box">
                                            <?php if (!empty($sanPham['gia_san_pham'])): ?>
                                                <p class="price-old"><del><?= number_format($sanPham['gia_san_pham'], 0, ',', '.') ?>đ</del></p>
                                            <?php endif; ?>
                                            <p class="price-regular"><span>Giá KM:</span>
                                                <span><?= number_format($sanPham['gia_khuyen_mai'] ?? 0, 0, ',', '.') ?>đ</span>
                                            </p>
                                        </div>
                                    </div>
                                    <form action="<?= BASE_URL . '?act=them-gio-hang' ?>" method="POST" style="display:inline;">
                                        <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                                        <input type="hidden" name="so_luong" value="1">
                                        <button type="submit" class="btn-addToCard">Thêm vào giỏ</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- No Products Found -->
                <div class="alert alert-info text-center py-5" style="border-radius: 12px; background-color: #e8f4f8; border: 1px solid #b8d4dc;">
                    <i class="fa fa-inbox" style="font-size: 3rem; color: #0c5460;"></i>
                    <h4 class="mt-3 mb-2" style="color: #0c5460;">Không tìm thấy sản phẩm</h4>
                    <p class="mb-0" style="color: #0c5460;">
                        Hãy thử thay đổi các bộ lọc hoặc từ khóa tìm kiếm của bạn
                    </p>
                    <a href="?act=san-pham" class="btn btn-primary btn-sm mt-3">Xem tất cả sản phẩm</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- CSS for Product Listing -->
<style>
    /* ===== GENERAL STYLES ===== */
    * {
        box-sizing: border-box;
    }

    .product-listing-section {
        min-height: 70vh;
        background: radial-gradient(circle at top, #ffffff 0%, #f8f9fa 40%, #e9edf0 100%);
        padding: 60px 0;
    }

    /* ===== PAGE TITLE ===== */
    .page-title {
        font-size: 3rem;
        font-weight: 900;
        letter-spacing: -1px;
        margin-bottom: 10px;
        background: linear-gradient(90deg, #b79891 0%, #ac8963 35%, #8d6e54 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        margin-top: 15px;
    }

    /* ===== FILTER SECTION ===== */
    .filter-form {
        background: #ffffff;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 12px 40px rgba(34, 41, 47, 0.12);
        border-top: 4px solid #b79891;
        transition: all 0.3s ease;
    }

    .filter-form:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
    }

    .form-label {
        color: #5f4b41;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .filter-form .form-control,
    .filter-form .form-select {
        border: 2px solid #d6b9aa;
        border-radius: 12px;
        /* padding: 10px 14px; */
        font-size: 0.92rem;
        transition: all 0.25s ease;
        background-color: #fffdfa;
        box-shadow: inset 0 2px 8px rgba(134, 102, 85, 0.08);
    }

    .filter-form .form-control:focus,
    .filter-form .form-select:focus {
        border-color: #a17f6d;
        background-color: #ffffff;
        box-shadow: 0 0 0 0.25rem rgba(161, 127, 109, 0.22);
        outline: none;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        background-color: white;
        box-shadow: 0 0 0 0.3rem rgba(102, 126, 234, 0.15);
        outline: none;
    }

    .form-control::placeholder {
        color: #a0aec0;
        font-weight: 500;
    }

    .input-group-text {
        border: 2px solid #e8e8e8;
        background-color: #f8f9fa !important;
        color: #667eea;
        font-weight: 600;
    }

    /* ===== BUTTONS ===== */
    .btn-primary {
        background: linear-gradient(90deg, #b79891 0%, #a17f6d 45%, #8f704b 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 28px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.23);
        transform: translateY(0);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .btn-primary:active {
        transform: translateY(-1px);
    }

    .btn-outline-secondary {
        border-color: #e0e0e0;
        color: #667eea;
        font-weight: 600;
    }

    .btn-outline-secondary:hover {
        background-color: #667eea;
        border-color: #667eea;
        color: white;
    }

    /* ===== RESULTS INFO ===== */
    .results-info {
        font-size: 1rem;
        color: #555;
        font-weight: 500;
        margin-bottom: 20px;
        padding: 15px 0;
        border-bottom: 2px solid #f0f0f0;
    }

    /* ===== PRODUCT CARD ===== */
    .product-item {
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.35s ease;
        box-shadow: 0 12px 30px rgba(21, 28, 39, 0.12);
        border: 1px solid rgba(173, 154, 133, 0.24);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 22px 60px rgba(0, 0, 0, 0.14);
    }

    .product-thumb {
        position: relative;
        overflow: hidden;
    }

    .product-thumb .pri-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.35s ease, filter 0.35s ease;
    }

    .product-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 2;
}

    .product-item:hover .product-thumb .pri-img {
        transform: scale(1.04);
        filter: brightness(0.95);
    }

    .product-caption {
        padding: 16px 14px 18px;
    }

    .product-name {
        margin-bottom: 10px;
        font-size: 1rem;
        line-height: 1.4;
        min-height: 46px;
    }

    .product-caption .product-des {
        display: flex;
        justify-content: center;
        gap: 8px;
        color: #777;
        font-size: 0.82rem;
        margin-bottom: 8px;
    }

    .price-box {
        margin-bottom: 13px;
    }

    .price-old,
    .price-regular {
        margin: 0;
        line-height: 1.2;
    }

    .price-old del {
        color: #a0a0a0;
        font-size: 0.9rem;
    }

    .price-regular {
        font-size: 1rem;
        font-weight: 700;
        color: #e85a4f;
    }

    .btn-addToCard {
        background: linear-gradient(90deg, #b79891 0%, #a17f6d 45%, #8f704b 100%);
        color: #fff;
        width: 100%;
        border: none;
        border-radius: 8px;
        padding: 10px 0;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn-addToCard:hover {
        transform: translateY(-1px);
        background: linear-gradient(90deg, #8f704b 0%, #a17f6d 45%, #b79891 100%);
    }

    /* ===== PRODUCT IMAGE ===== */
    .product-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 220px;
        background: linear-gradient(135deg, #f9f9f9 0%, #ebebe8 100%);
    }

    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1), filter 0.3s ease;
    }

    .product-card:hover .product-image-wrapper img {
        transform: scale(1.08) rotate(2deg);
        filter: brightness(0.95);
    }

    /* Overlay on Hover */
    .product-image-wrapper > div {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .product-image-wrapper > div {
        opacity: 1 !important;
    }

    /* Badge Styles */
    .badge {
        font-size: 0.72rem;
        padding: 8px 14px;
        font-weight: 700;
        letter-spacing: 1px;
        border-radius: 20px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.20);
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, #b79891 0%, #a17f6d 100%) !important;
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #f8d776 0%, #d9b166 100%) !important;
        color: #4a3d2d !important;
    }

    /* ===== PRODUCT INFO ===== */
    .product-info {
        padding: 22px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-info p.text-muted {
        color: #a0aec0 !important;
        font-size: 0.85rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    /* ===== PRODUCT NAME ===== */
    .product-name {
        line-height: 1.5;
        margin-bottom: 8px;
        flex-grow: 1;
    }

    .product-name a {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        transition: all 0.3s ease;
        display: block;
    }

    .product-name a:hover {
        color: #667eea;
    }

    /* ===== PRICE SECTION ===== */
    .price-section {
        margin-bottom: 16px;
        padding: 12px 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        align-items: center;
    }

    .product-price {
        font-size: 1.4rem !important;
        font-weight: 800 !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .original-price {
        font-size: 0.9rem !important;
        color: #a0aec0 !important;
    }

    /* ===== ADD TO CART BUTTON ===== */
    .product-info .btn-dark {
        background: linear-gradient(135deg, #2c3e50 0%, #1a1a1a 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 16px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(26, 26, 26, 0.2);
    }

    .product-info .btn-dark:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        transform: translateY(-2px);
    }

    /* ===== QUICK VIEW LINK ===== */
    .product-info > p:last-child a {
        color: #667eea;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .product-info > p:last-child a:hover {
        color: #764ba2;
    }

    /* ===== EMPTY STATE ===== */
    .alert-info {
        background: linear-gradient(135deg, #e8f4f8 0%, #f0f8ff 100%) !important;
        border: 2px solid #b8d4dc !important;
        border-radius: 14px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1200px) {
        .page-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .product-listing-section {
            padding: 40px 0;
        }

        .page-title {
            font-size: 1.8rem;
        }

        .filter-form {
            padding: 25px;
        }

        .product-info {
            padding: 16px;
        }

        .product-image-wrapper {
            height: 200px;
        }
    }

    @media (max-width: 576px) {
        .product-listing-section {
            padding: 30px 0;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .page-title::after {
            width: 60px;
        }

        .filter-form {
            padding: 20px;
            border-radius: 12px;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            padding: 10px 12px;
            font-size: 0.9rem;
        }

        .btn-primary {
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .product-card {
            margin-bottom: 20px;
        }

        .product-image-wrapper {
            height: 180px;
        }

        .product-info {
            padding: 14px;
        }

        .product-name a {
            font-size: 1rem;
        }

        .product-price {
            font-size: 1.2rem !important;
        }
    }

    /* ===== ANIMATIONS ===== */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-card {
        animation: slideInUp 0.6s ease-out forwards;
    }

    .product-card:nth-child(1) { animation-delay: 0.1s; }
    .product-card:nth-child(2) { animation-delay: 0.2s; }
    .product-card:nth-child(3) { animation-delay: 0.3s; }
    .product-card:nth-child(4) { animation-delay: 0.4s; }
    .product-card:nth-child(5) { animation-delay: 0.5s; }
    .product-card:nth-child(6) { animation-delay: 0.6s; }
    .product-card:nth-child(7) { animation-delay: 0.7s; }
    .product-card:nth-child(8) { animation-delay: 0.8s; }

</style>

<?php require_once 'layout/footer.php' ?>
