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
                        <h4 class="mt-3">Trạng thái: <small><?= $sanPham['trang_thai'] == 1 ? "Còn hàng" : "Hết hàng" ?></small></h4>
                        <h4 class="mt-3">Mã code: <small><?= $sanPham['code'] ?></small></h4>
                        <h4 class="mt-3">Sản phẩm mới: <small><?= $sanPham['is_new'] == 1 ? 'Có' : 'Không' ?></small></h4>
                        <h4 class="mt-3">Sản phẩm hot: <small><?= $sanPham['is_hot'] == 1 ? 'Có' : 'Không' ?></h4>
                        <h4 class="mt-3">Giới tính: <small><?= $sanPham['gioi_tinh'] ?></small></h4>
                        <h4 class="mt-3">Loại máy: <small><?= $sanPham['loai_may'] ?></small></h4>
                        <h4 class="mt-3">Xuất xứ: <small><?= $sanPham['xuat_xu'] ?></small></h4>
                        <h4 class="mt-3">Kích thước: <small><?= $sanPham['kich_thuoc'] ?></small></h4>
                        <h4 class="mt-3">Chất liệu dây: <small><?= $sanPham['chat_lieu_day'] ?></small></h4>
                        <h4 class="mt-3">Chống nước: <small><?= $sanPham['chong_nuoc'] ?></small></h4>
                        <h4 class="mt-3">Mô tả: <small><?= $sanPham['mo_ta'] ?></small></h4>

                    </div>
                </div>


                <div class="col-12">
                    <hr>
                    <h2>Bình luận của sản phẩm</h2>
                    <div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Người Bình LuậN</th>
                                        <th>Nội Dung</th>
                                        <th>Ngày Bình LuậN</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($listBinhLuan as $key => $binhLuan) : ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td>
                                                <a target="_blank" href="<?= BASE_URL_ADMIN . '?act=chi-tiet-khach-hang&id_khach_hang=' . $binhLuan['tai_khoan_id'] ?>">
                                                    <?= $binhLuan['ho_ten'] ?>
                                                </a>
                                            </td>
                                            <td><?= $binhLuan['noi_dung'] ?></td>
                                            <td><?= $binhLuan['ngay_dang'] ?></td>
                                            <td><?= $binhLuan['trang_thai'] == 1 ? 'Hiển thị' : 'Bị Ẩn' ?></td>

                                            <td>
                                                <div class="btn-group">

                                                    <form action="<?= BASE_URL_ADMIN . '?act=update-trang-thai-binh-luan' ?>" method="POST">
                                                        <input type="hidden" name="id_binh_luan" value="<?= $binhLuan['id'] ?>">
                                                        <input type="hidden" name="name_view" value="detail_sanpham">
                                                        <button onclick="return confirm('Bạn có muốn ẩn bình luậN này không?')" class="btn btn-danger">
                                                            <?= $binhLuan['trang_thai'] == 1 ? 'Ẩn' : 'Bỏ ẩn' ?>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>

                            </table>
                        </div>
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