<!--////////////////// Header //////////////////-->
<?php include './views/layout/header.php' ?>
<!--//////////////////End Header //////////////////-->

<!--////////////////// Navbar //////////////////-->
<?php include './views/layout/navbar.php' ?>
<!--//////////////////End Navbar //////////////////-->

<!--////////////////// main sidebar container //////////////////-->
<?php include './views/layout/sidebar.php' ?>
<!--//////////////////End sidebar //////////////////-->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý danh sách sản phẩm</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <a href="<?= BASE_URL_ADMIN . '?act=form-them-san-pham' ?>">
                                <button class="btn btn-success">Thêm sản phẩm</button>
                            </a>
                        </div>
                        <?php if (!empty($_SESSION['success'])): ?>
                            <div class="alert alert-dismissible" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?= $_SESSION['success'] ?>
                            </div>
                        <?php
                            unset($_SESSION['success']);
                        endif; ?>
                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-dismissible" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?= $_SESSION['error'] ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Ảnh sản phẩm</th>
                                        <th>Giá tiền</th>
                                        <th>Số lượng</th>
                                        <th>Danh mục</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listSanPham as $key => $sanPham): ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= $sanPham['ten_san_pham'] ?></td>
                                            <td class="text-center">
                                                <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" style="width:100px" alt=""
                                                    onerror="this.onerror = null; this.src = 'https://weart.vn/wp-content/uploads/2025/06/chu-meo-cute-voi-bieu-cam-ngo-ngac-to-mo.jpg'">
                                            </td>
                                            <td><?= $sanPham['gia_san_pham'] ?></td>
                                            <td class="text-center"><?= $sanPham['so_luong'] ?></td>
                                            <td><?= $sanPham['ten_danh_muc'] ?></td>
                                            <td class="text-center"><?= $sanPham['trang_thai'] == 1 ? 'Còn hàng' : 'Hết hàng' ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center" style="gap: 6px;">
                                                    <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="<?= BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $sanPham['id'] ?>"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <a href="<?= BASE_URL_ADMIN . '?act=xoa-san-pham&id_san_pham=' . $sanPham['id'] ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Bạn có đồng ý xóa sản phẩm?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Ảnh sản phẩm</th>
                                        <th>Giá tiền</th>
                                        <th>Số lượng</th>
                                        <th>Danh mục</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!--////////////////// Footer //////////////////-->
<?php include './views/layout/footer.php' ?>
<!--//////////////////End Footer //////////////////-->

<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "order": [[0, "desc"]],
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
<!-- Code injected by live-server -->
</body>

</html>