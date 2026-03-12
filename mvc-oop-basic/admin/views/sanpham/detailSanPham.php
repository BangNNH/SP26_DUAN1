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
                    <h1>Chi tiết sản phẩm</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="col-12">
                            <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" class="product-image" style=" width: 450px; height: 450px;" alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            <!-- <div class="product-image-thumb active"><img src="../../dist/img/prod-1.jpg" alt="Product Image"></div> -->
                            <?php foreach ($listAnhSanPham as $key => $anhSP): ?>
                                <div class="product-image-thumb <?= $anhSP[$key] == 0 ? 'active' : '' ?>"><img src="<?= BASE_URL . $anhSP['link_hinh_anh'] ?>" alt="Product Image"></div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">Tên sản phẩm: <?= $sanPham['ten_san_pham'] ?></h3>
                        <hr>
                        <h4 class="mt-3">Giá tiền: <small><?= $sanPham['gia_san_pham'] ?></small></h4>
                        <h4 class="mt-3">Giá khuyến mãi: <small><?= $sanPham['gia_khuyen_mai'] ?></small></h4>
                        <h4 class="mt-3">Số lượng: <small><?= $sanPham['so_luong'] ?></small></h4>
                        <h4 class="mt-3">Lượt xem: <small><?= $sanPham['luot_xem'] ?></small></h4>
                        <h4 class="mt-3">Ngày nhập: <small><?= $sanPham['ngay_nhap'] ?></small></h4>
                        <h4 class="mt-3">Danh mục: <small><?= $sanPham['ten_danh_muc'] ?></small></h4>
                        <h4 class="mt-3">Trạng thái: <small><?= $sanPham['trang_thai'] == 1 ? "Còn hàng" : "Ngừng bán" ?></small></h4>
                        <h4 class="mt-3">Mô tả: <small><?= $sanPham['mo_ta'] ?></small></h4>

                    </div>
                </div>

                <ul class="nav nav-tabs row mt-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Bình luận sản phẩm</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table class="table table-stripe table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên người dùng</th>
                                    <th>Nội dung</th>
                                    <th>Ngày đăng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Hoài Băng</td>
                                    <td>xinh quá</td>
                                    <td>10/03/2026</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#"><button class="btn btn-warning">Ẩn</button></a>
                                            <a href="#"><button class="btn btn-danger">Xóa</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Hoài Băng</td>
                                    <td>xinh quá</td>
                                    <td>10/03/2026</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#"><button class="btn btn-warning">Ẩn</button></a>
                                            <a href="#"><button class="btn btn-danger">Xóa</button></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

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
<script>
    $(document).ready(function() {
        $('.product-image-thumb').on('click', function() {
            var $image_element = $(this).find('img')
            $('.product-image').prop('src', $image_element.attr('src'))
            $('.product-image-thumb.active').removeClass('active')
            $(this).addClass('active')
        })
    })
</script>

</html>