<?php 
// 1. Xử lý logic hiển thị icon và link sắp xếp
$current_sort = $_GET['sort'] ?? 'id';
$current_order = $_GET['order'] ?? 'desc';
$next_order = ($current_order == 'asc') ? 'desc' : 'asc';

// Lấy lại các giá trị filter để nối vào link sắp xếp (tránh mất lọc khi sort)
$san_pham_id = $_GET['san_pham_id'] ?? '';
$tu_ngay = $_GET['tu_ngay'] ?? '';
$den_ngay = $_GET['den_ngay'] ?? '';
$filter_params = "&san_pham_id=$san_pham_id&tu_ngay=$tu_ngay&den_ngay=$den_ngay";

// Hàm hiển thị icon mũi tên
function getSortIcon($column, $current_sort, $current_order) {
    if ($column !== $current_sort) return '<i class="fas fa-sort text-muted" style="font-size: 0.8rem;"></i>';
    return ($current_order == 'asc') ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>';
}
?>

<?php include './views/layout/header.php' ?>
<?php include './views/layout/navbar.php' ?>
<?php include './views/layout/sidebar.php' ?>

<style>
    body {
        font-size: 16px;
        color: #1f2937;
    }

    .page-title {
        font-size: 26px;
    }

    .card-main {
        border-radius: 16px;
        border: none;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.06);
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .divider {
        height: 1px;
        background: #e5e7eb;
        margin: 20px 0;
    }

    .info-grid p {
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
    }

    .info-grid span:first-child {
        color: #6b7280;
    }

    .info-grid span:last-child {
        font-weight: 500;
    }

    /* IMAGE */
    .image-wrapper {
        /* background: #f9fafb; */
        border-radius: 14px;
        position: relative;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        max-height: 420px;
        object-fit: contain;
        transition: all 0.4s ease;
    }

    .fade-out {
        opacity: 0;
        transform: translateX(-30px);
    }

    .fade-in {
        opacity: 0;
        transform: translateX(30px);
    }

    .thumb-list {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .thumb {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        object-fit: cover;
        cursor: pointer;
        transition: 0.25s;
    }

    .thumb:hover {
        transform: translateY(-3px);
    }

    .thumb.active {
        border: 1px solid #111;
    }

    /* PRICE */
    .price-main {
        font-size: 28px;
        color: #111;
    }

    .price-sale {
        font-size: 14px;
        color: #dc2626;
    }

    /* TABLE */
    .table thead {
        background: #f3f4f6;
    }

    .table tbody tr:hover {
        background: #fafafa;
    }

    .btn-action {
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý bình luận</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Bộ lọc tìm kiếm</h3>
                </div>
                <div class="card-body">
                    <form action="" method="GET">
                        <input type="hidden" name="act" value="quan-ly-binh-luan">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Sản phẩm:</label>
                                <select name="san_pham_id" class="form-control">
                                    <option value="">-- Tất cả sản phẩm --</option>
                                    <?php foreach ($listSanPham as $sp): ?>
                                        <option value="<?= $sp['id'] ?>" <?= ($san_pham_id == $sp['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($sp['ten_san_pham']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Từ ngày:</label>
                                <input type="date" name="tu_ngay" class="form-control" value="<?= $tu_ngay ?>">
                            </div>
                            <div class="col-md-3">
                                <label>Đến ngày:</label>
                                <input type="date" name="den_ngay" class="form-control" value="<?= $den_ngay ?>">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary mr-2">Lọc dữ liệu</button>
                                <a href="?act=quan-ly-binh-luan" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 80px;">
                                    <a href="?act=quan-ly-binh-luan&sort=id&order=<?= $next_order . $filter_params ?>" class="text-dark d-flex justify-content-between align-items-center">
                                        ID <?= getSortIcon('id', $current_sort, $current_order) ?>
                                    </a>
                                </th>
                                <th>Người bình luận</th>
                                <th>
                                    <a href="?act=quan-ly-binh-luan&sort=ten_san_pham&order=<?= $next_order . $filter_params ?>" class="text-dark d-flex justify-content-between align-items-center">
                                        Sản phẩm <?= getSortIcon('ten_san_pham', $current_sort, $current_order) ?>
                                    </a>
                                </th>
                                <th>Nội dung</th>
                                <th>Trạng thái</th>
                                <th style="width: 150px;">
                                    <a href="?act=quan-ly-binh-luan&sort=ngay_dang&order=<?= $next_order . $filter_params ?>" class="text-dark d-flex justify-content-between align-items-center">
                                        Ngày đăng <?= getSortIcon('ngay_dang', $current_sort, $current_order) ?>
                                    </a>
                                </th>
                                <th style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($listBinhLuan)): ?>
                                <?php foreach ($listBinhLuan as $bl): ?>
                                    <tr>
                                        <td class="text-center"><?= $bl['id'] ?></td>
                                        <td>
                                            <a href="?act=chi-tiet-khach-hang&id=<?= $bl['tai_khoan_id'] ?>" class="text-bold">
                                                <?= htmlspecialchars($bl['ho_ten']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="?act=chi-tiet-san-pham&id=<?= $bl['san_pham_id'] ?>">
                                                <?= htmlspecialchars($bl['ten_san_pham']) ?>
                                            </a>
                                        </td>
                                        <td><?= htmlspecialchars($bl['noi_dung']) ?></td>
                                        <td class="text-center">
                                            <?php if ($bl['trang_thai'] == 1): ?>
                                                <span class="badge badge-success">Hiển thị</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Ẩn</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"> <?= date("d/m/Y", strtotime($bl['ngay_dang'])) ?></td>
                                        <td class="text-center">
                                            <a href="?act=update-trang-thai-binh-luan&id_binh_luan=<?= $bl['id'] ?>&name_view=binh_luan" 
                                               class="btn btn-sm <?= ($bl['trang_thai'] == 1 ? 'btn-warning' : 'btn-success') ?>" 
                                               onclick="return confirm('Bạn có chắc chắn muốn <?= ($bl['trang_thai'] == 1 ? 'ẩn' : 'hiển thị lại') ?> bình luận này?')">
                                                <i class="fas <?= ($bl['trang_thai'] == 1 ? 'fa-eye-slash' : 'fa-eye') ?>"></i>
                                            </a>
                                            <a href="?act=xoa-binh-luan&id_binh_luan=<?= $bl['id'] ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn bình luận này?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không tìm thấy bình luận nào phù hợp.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include './views/layout/footer.php' ?>