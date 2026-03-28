<?php require_once 'layout/header.php' ?>
<?php require_once 'layout/menu.php' ?>

<main>
    <div class="product-listing-section">
        <div class="container">
            <div class="page-title-section">
                <h1 class="page-title">Danh Sách Sản Phẩm</h1>
                <p class="page-subtitle">Khám phá bộ sưu tập đồng hồ cao cấp của chúng tôi</p>
            </div>

            <div class="main-layout">
                <aside class="sidebar">
                    <div class="sidebar-content">
                        <h3 class="sidebar-title">Bộ lọc sản phẩm</h3>
                        <form method="GET" id="filterForm" class="filter-form">
                            <input type="hidden" name="act" value="san-pham">

                            <div class="filter-group">
                                <label for="searchInput" class="filter-label">Tìm kiếm sản phẩm</label>
                                <input type="text" class="filter-input" id="searchInput"
                                       name="search" placeholder="Nhập tên sản phẩm..."
                                       value="<?= htmlspecialchars($searchKeyword) ?>">
                            </div>

                            <div class="filter-group">
                                <label class="filter-label">Khoảng giá (VNĐ)</label>
                                <div class="price-range">
                                    <input type="number" class="filter-input price-input" id="minPrice" name="min_price"
                                           placeholder="Từ" min="0" value="<?= htmlspecialchars($minPrice) ?>">
                                    <span class="price-separator">-</span>
                                    <input type="number" class="filter-input price-input" id="maxPrice" name="max_price"
                                           placeholder="Đến" value="<?= htmlspecialchars($maxPrice < 999999999 ? $maxPrice : '') ?>">
                                </div>
                            </div>

                            <div class="filter-group">
                                <label for="typeFilter" class="filter-label">Loại đồng hồ</label>
                                <select class="filter-select" id="typeFilter" name="type">
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

                            <div class="filter-group">
                                <button type="submit" class="filter-submit-btn">
                                    <i class="fa fa-search"></i> Tìm kiếm
                                </button>
                            </div>

                            <div class="filter-group">
                                <a href="?act=san-pham" class="filter-reset-link">
                                    <i class="fa fa-redo"></i> Đặt lại bộ lọc
                                </a>
                            </div>
                        </form>
                    </div>
                </aside>

                <section class="main-content">
                    <div class="results-info">
                        <p>
                            <strong>Tìm thấy <?= count($listSanPham) ?> sản phẩm</strong>
                            <?php if (!empty($searchKeyword)): ?>
                                cho từ khóa "<strong><?= htmlspecialchars($searchKeyword) ?></strong>"
                            <?php endif; ?>
                            <?php if (!empty($productType)): ?>
                                trong danh mục "<strong><?= htmlspecialchars($productType) ?></strong>"
                            <?php endif; ?>
                        </p>
                    </div>

                    <?php if (!empty($listSanPham)): ?>
                        <div class="product-list">
                            <?php foreach ($listSanPham as $sanPham): ?>
                                <div class="product-item">
                                    <figure class="product-thumb">
                                        <a class="product-thumb-link" href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>">
                                            <img class="product-image" src="<?= htmlspecialchars($sanPham['hinh_anh'] ? BASE_URL . $sanPham['hinh_anh'] : BASE_URL . 'assets/img/avatar_default.jpg') ?>"
                                                 alt="<?= htmlspecialchars($sanPham['ten_san_pham']) ?>"
                                                 onerror="this.src='<?= BASE_URL . 'assets/img/avatar_default.jpg' ?>'">
                                            <div class="product-badge">
                                                <?php if ($sanPham['is_new'] == 1): ?>
                                                    <div class="badge badge-new">New</div>
                                                <?php endif; ?>
                                                <?php if ($sanPham['is_hot'] == 1): ?>
                                                    <div class="badge badge-hot">Hot</div>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                        <div class="product-wishlist">
                                            <a href="#" class="wishlist-link"><i class="pe-7s-like"></i></a>
                                        </div>
                                    </figure>
                                    <div class="product-info">
                                        <h6 class="product-name">
                                            <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>"><?= htmlspecialchars($sanPham['ten_san_pham']) ?></a>
                                        </h6>
                                        <p class="product-code"><?= htmlspecialchars($sanPham['code'] ?? '') ?></p>
                                        <div class="product-details">
                                            <span class="product-size"><?= htmlspecialchars($sanPham['kich_thuoc'] ?? '') ?></span>
                                            <span class="product-type"><?= htmlspecialchars($sanPham['loai_may'] ?? '') ?></span>
                                        </div>
                                        <div class="product-price">
                                            <?php if (!empty($sanPham['gia_san_pham'])): ?>
                                                <p class="price-old"><del><?= number_format($sanPham['gia_san_pham'], 0, ',', '.') ?>đ</del></p>
                                            <?php endif; ?>
                                            <p class="price-current">
                                                <span class="price-label">Giá KM:</span>
                                                <span class="price-amount"><?= number_format($sanPham['gia_khuyen_mai'] ?? 0, 0, ',', '.') ?>đ</span>
                                            </p>
                                        </div>
                                        <form action="<?= BASE_URL . '?act=them-gio-hang' ?>" method="POST" class="add-to-cart-form">
                                            <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                                            <input type="hidden" name="so_luong" value="1">
                                            <button type="submit" class="add-to-cart-btn">Thêm vào giỏ</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-products">
                            <i class="fa fa-inbox no-products-icon"></i>
                            <h4 class="no-products-title">Không tìm thấy sản phẩm</h4>
                            <p class="no-products-text">
                                Hãy thử thay đổi các bộ lọc hoặc từ khóa tìm kiếm của bạn
                            </p>
                            <a href="?act=san-pham" class="no-products-link">Xem tất cả sản phẩm</a>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</main>

<style>
/* ===== RESET & BASE STYLES ===== */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
}

/* ===== CONTAINER ===== */
.container {
    max-width: 1600px;
    margin: 0 auto;
    padding: 0 20px;
}

/* ===== PAGE TITLE SECTION ===== */
.page-title-section {
    text-align: center;
    margin-bottom: 40px;
    padding-top: 20px;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
    position: relative;
}

.page-title::after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #2980b9);
    margin: 10px auto 0;
    border-radius: 2px;
}

.page-subtitle {
    color: #7f8c8d;
    font-size: 1.1rem;
    font-weight: 400;
}

/* ===== MAIN LAYOUT: SIDEBAR + MAIN CONTENT ===== */
.main-layout {
    display: flex;
    gap: 30px;
    min-height: 600px;
}

/* ===== SIDEBAR ===== */
.sidebar {
    flex: 0 0 26%;
}

.sidebar-content {
    background: #fff;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #eee;
    position: sticky;
    top: 20px;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
    overflow-x: visible;
}

.sidebar-title {
    font-size: 1.4rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 20px;
    color: #2c3e50;
    position: relative;
}

.sidebar-title::after {
    content: '';
    width: 40px;
    height: 3px;
    background: #921817;
    display: block;
    margin: 8px auto 0;
    border-radius: 2px;
}

/* ===== FILTER FORM ===== */
.filter-form {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.filter-group {
    background: #fafafa;
    padding: 14px;
    border-radius: 10px;
    border: 1px solid #eee;
    transition: 0.25s;
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 1;
    animation: slideInLeft 0.5s ease-out forwards;
}

.filter-group::before {
    content: '';
    position: absolute;
    left: -10px;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 60%;
    background: linear-gradient(135deg, #3498db, #2980b9);
    border-radius: 2px;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
    pointer-events: none;
}

.filter-group:hover::before {
    opacity: 1;
}

.filter-label {
    font-weight: 600;
    color: #34495e;
    margin-bottom: 10px;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 8px;
    position: relative;
}

.filter-label::before {
    content: '';
    width: 6px;
    height: 6px;
    background: #3498db;
    border-radius: 50%;
    flex-shrink: 0;
}

.filter-input,
.filter-select {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e1e8ed;
    border-radius: 12px;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(5px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    position: relative;
    z-index: 2;
}

.filter-input {
    overflow: hidden; 
}
.filter-select {
    overflow: visible; 
    appearance: none;
    /* background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e"); */
    background-position: right 12px center;
    background-repeat: no-repeat;
    background-size: 16px;
    
    height: 52px;
    line-height: 48px; 
    padding: 0 40px 0 18px; 
}


.filter-input::placeholder,
.filter-select option {
    color: #a0aec0;
    font-weight: 400;
}

.filter-input:focus,
.filter-select:focus {
    outline: none;
    border-color: #3498db;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.15), 0 4px 16px rgba(52, 152, 219, 0.1);
    transform: translateY(-1px);
}

.filter-input:focus::placeholder {
    color: #cbd5e0;
}

.price-range {
    display: flex;
    align-items: stretch;
    gap: 10px;
    width: 100%;
    min-width: 0;
    flex-wrap: nowrap;
}

.price-input {
    flex: 1;
    min-width: 0;
    width: 100%;
    box-sizing: border-box;
    position: relative;
}

.price-input[type="number"]::-webkit-outer-spin-button,
.price-input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.price-input[type="number"] {
    -moz-appearance: textfield;
}

.price-input:first-child {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-right: none;
}

.price-input:last-child {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-left: 1px solid #e1e8ed;
}

.price-separator {
    color: #7f8c8d;
    font-weight: 600;
    font-size: 1.1rem;
    background: rgba(255, 255, 255, 0.9);
    padding: 14px 8px;
    border-radius: 0 12px 12px 0;
    border: 2px solid #e1e8ed;
    border-left: none;
    position: relative;
    z-index: 1;
}

/* ===== FILTER BUTTONS ===== */
.filter-submit-btn {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 50%, #21618c 100%);
    color: white;
    border: none;
    padding: 16px 24px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(52, 152, 219, 0.3);
    width: 100%;
}

.filter-submit-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.filter-submit-btn:hover::before {
    left: 100%;
}

.filter-submit-btn:hover {
    background: linear-gradient(135deg, #2980b9 0%, #21618c 50%, #1a4d6b 100%);
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
}

.filter-submit-btn:active {
    transform: translateY(-1px) scale(1.01);
}

.filter-reset-link {
    color: #7f8c8d;
    text-decoration: none;
    font-weight: 500;
    text-align: center;
    padding: 12px 20px;
    border-radius: 10px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 2px solid transparent;
    background: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(5px);
    position: relative;
    overflow: hidden;
    width: 100%;
}

.filter-reset-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #3498db, #2980b9);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.filter-reset-link:hover {
    color: white;
    border-color: #3498db;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(52, 152, 219, 0.2);
}

.filter-reset-link:hover::before {
    opacity: 1;
}

/* ===== ANIMATIONS ===== */
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Thêm z-index giảm dần để các thẻ select khi mở ra không bị các nút bên dưới đè lên */
.filter-group:nth-child(1) { animation-delay: 0.1s; z-index: 5; }
.filter-group:nth-child(2) { animation-delay: 0.2s; z-index: 4; }
.filter-group:nth-child(3) { animation-delay: 0.3s; z-index: 3; } /* Nhóm chứa Select loại đồng hồ */
.filter-group:nth-child(4) { animation-delay: 0.4s; z-index: 2; } /* Nhóm chứa nút Tìm kiếm */
.filter-group:nth-child(5) { animation-delay: 0.5s; z-index: 1; } /* Nhóm chứa nút Reset */

/* ===== MAIN CONTENT & RESULTS INFO ===== */
.main-content {
    flex: 1; 
}

.results-info {
    margin-bottom: 25px;
    padding: 15px 0;
    border-bottom: 1px solid #ecf0f1;
}

.results-info p {
    color: #555;
    font-size: 1rem;
    margin: 0;
}

.results-info strong {
    color: #2c3e50;
}

/* ===== PRODUCT LIST & ITEM ===== */
.product-list {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px; 
}

.product-item {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

/* ===== PRODUCT THUMB ===== */
.product-thumb {
    position: relative;
    overflow: hidden;
    height: 250px;
}

.product-thumb-link {
    display: block;
    height: 100%;
    text-decoration: none;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-item:hover .product-image {
    transform: scale(1.05);
}

/* ===== PRODUCT BADGE & WISHLIST ===== */
.product-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-new {
    background: #e74c3c;
    color: white;
}

.badge-hot {
    background: #f39c12;
    color: white;
}

.product-wishlist {
    position: absolute;
    top: 10px;
    right: 10px;
}

.wishlist-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    color: #7f8c8d;
    text-decoration: none;
    transition: all 0.3s ease;
}

.wishlist-link:hover {
    background: #e74c3c;
    color: white;
    transform: scale(1.1);
}

/* ===== PRODUCT INFO ===== */
.product-info {
    padding: 20px;
    text-align: center;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
    line-height: 1.4;
}

.product-name a {
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-name a:hover {
    color: #3498db;
}

.product-code {
    color: #e74c3c;
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 10px;
    text-transform: uppercase;
}

.product-details {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 15px;
    font-size: 0.9rem;
    color: #7f8c8d;
}

.product-size,
.product-type {
    background: #ecf0f1;
    padding: 4px 8px;
    border-radius: 4px;
}

.product-price {
    margin-bottom: 15px;
}

.price-old {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin: 0;
}

.price-current {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 5px 0 0;
}

.price-label {
    color: #7f8c8d;
    font-weight: 500;
}

.price-amount {
    color: #921817;
}

/* ===== ADD TO CART BUTTON ===== */
.add-to-cart-form {
    opacity: 0;
    transform: translateY(15px);
    transition: all 0.3s ease;
    margin-top: 15px;
}

.product-item:hover .add-to-cart-form {
    opacity: 1;
    transform: translateY(0);
}

.add-to-cart-btn {
    width: 100%;
    background: #921817;
    color: #fff;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
    opacity: 0.75;
}

/* ===== NO PRODUCTS ===== */
.no-products {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.no-products-icon {
    font-size: 4rem;
    color: #bdc3c7;
    margin-bottom: 20px;
}

.no-products-title {
    color: #2c3e50;
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.no-products-text {
    color: #7f8c8d;
    margin-bottom: 20px;
}

.no-products-link {
    display: inline-block;
    background: #3498db;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.no-products-link:hover {
    background: #2980b9;
    transform: translateY(-2px);
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 992px) {
    .main-layout {
        flex-direction: column;
        gap: 20px;
    }
    .sidebar {
        flex: none;
        max-width: none;
    }
    .sidebar-content {
        position: static;
        max-height: none;
    }
    .product-list {
        grid-template-columns: repeat(3, 1fr); 
        gap: 20px;
    }
    .page-title {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .container {
        padding: 0 15px;
    }
    .main-layout {
        gap: 15px;
    }
    .sidebar-content {
        padding: 20px;
        border-radius: 12px;
    }
    .sidebar-title {
        font-size: 1.3rem;
        margin-bottom: 20px;
        border-bottom: 3px solid #3498db;
    }
    .filter-form {
        gap: 28px;
    }
    .filter-input,
    .filter-select {
        padding: 12px 16px;
        font-size: 0.9rem;
    }
    .price-range {
        flex-direction: column;
        gap: 8px;
    }
    .price-input:first-child {
        border-radius: 12px;
        border-right: 2px solid #e1e8ed;
    }
    .price-input:last-child {
        border-radius: 12px;
        border-left: 2px solid #e1e8ed;
    }
    .price-separator {
        display: none;
    }
    .filter-submit-btn {
        padding: 14px 20px;
        font-size: 0.95rem;
    }
    .product-list {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    .product-thumb {
        height: 200px;
    }
    .product-info {
        padding: 15px;
    }
    .page-title {
        font-size: 1.8rem;
    }
}

@media (max-width: 480px) {
    .product-list {
        gap: 10px;
    }
    .product-item {
        border-radius: 8px;
    }
    .product-info {
        padding: 12px;
    }
    .filter-input,
    .filter-select {
        padding: 10px 12px;
    }
}
</style>

<?php require_once 'layout/footer.php' ?>