    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

    <!-- footer area start -->
    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

    <!-- footer area start -->
    <footer class="footer-widget-area">
        <div class="footer-top section-padding" style="padding: 60px 0;">
            <div class="container">
                <div class="row">

                    <!-- Logo + giới thiệu -->
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <div class="widget-title">
                                <div class="widget-logo">
                                    <a href="<?= BASE_URL ?>">
                                        <img src="<?= BASE_ASSETS_IMG . 'logo/main-logo2-removebg.png' ?>" alt="Brand Logo">
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <p>Chúng tôi chuyên cung cấp các sản phẩm đồng hồ chất lượng, giá thành tốt.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Liên hệ -->
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <h6 class="widget-title">Liên hệ</h6>
                            <div class="widget-body">
                                <address class="contact-block">
                                    <ul>
                                        <li><i class="pe-7s-home"></i> 181 Xuân Thủy - Cầu Giấy - Hà Nội</li>
                                        <li><i class="pe-7s-mail"></i> <a href="mailto:watchhub@gmail.com">watchhub@gmail.com</a></li>
                                        <li><i class="pe-7s-call"></i> <a href="tel:0978665665">0978 665 665</a></li>
                                    </ul>
                                </address>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin -->
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <h6 class="widget-title">Thông tin</h6>
                            <div class="widget-body">
                                <ul class="info-list">
                                    <li><a href="#">Giới thiệu</a></li>
                                    <li><a href="#">Chính sách giao hàng</a></li>
                                    <li><a href="#">Chính sách bảo mật</a></li>
                                    <li><a href="#">Điều khoản & điều kiện</a></li>
                                    <li><a href="#">Liên hệ</a></li>
                                    <li><a href="#">Sơ đồ website</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Mạng xã hội -->
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <h6 class="widget-title">Theo dõi chúng tôi</h6>
                            <div class="widget-body social-link">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Newsletter -->
                <div class="row align-items-center mt-20">
                    <div class="col-md-6">
                        <div class="newsletter-wrapper">
                            <h6 class="widget-title-text">Đăng ký nhận tin</h6>
                            <form class="newsletter-inner" id="mc-form">
                                <input type="email" class="news-field" id="mc-email" autocomplete="off" placeholder="Nhập email của bạn">
                                <button class="news-btn" id="mc-submit">Đăng ký</button>
                            </form>

                            <div class="mailchimp-alerts">
                                <div class="mailchimp-submitting"></div>
                                <div class="mailchimp-success"></div>
                                <div class="mailchimp-error"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Thanh toán -->
                    <div class="col-md-6">
                        <div class="footer-payment">
                            <img src="assets/img/payment.png" alt="phương thức thanh toán">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="footer-copyright" bis_skin_checked="1">
            <p>© All rights reserved - Bản quyền thuộc về Công ty TNHH Phân phối đồng hồ cao cấp
                <strong> WATCH HUB</strong>
            </p>
        </div>
    </footer>
    <!-- footer area end -->
    <!-- footer area end -->

    <!-- JS
============================================ -->
    <script src="assets/js/cart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            <?php if (isset($_SESSION['openCart'])): ?>
                var btn = document.querySelector('.minicart-btn');
                if (btn) btn.click();
            <?php unset($_SESSION['openCart']);
            endif; ?>
        });
    </script>
    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <!-- jQuery JS -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
    <!-- slick Slider JS -->
    <script src="assets/js/plugins/slick.min.js"></script>
    <!-- Countdown JS -->
    <script src="assets/js/plugins/countdown.min.js"></script>
    <!-- Nice Select JS -->
    <script src="assets/js/plugins/nice-select.min.js"></script>
    <!-- jquery UI JS -->
    <script src="assets/js/plugins/jqueryui.min.js"></script>
    <!-- Image zoom JS -->
    <script src="assets/js/plugins/image-zoom.min.js"></script>
    <!-- Images loaded JS -->
    <script src="assets/js/plugins/imagesloaded.pkgd.min.js"></script>
    <!-- mail-chimp active js -->
    <script src="assets/js/plugins/ajaxchimp.js"></script>
    <!-- contact form dynamic js -->
    <script src="assets/js/plugins/ajax-mail.js"></script>
    <!-- google map api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfmCVTjRI007pC1Yk2o2d_EhgkjTsFVN8"></script>
    <!-- google map active js -->
    <script src="assets/js/plugins/google-map.js"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>
    <div id="launcher" onclick="toggleAI()" style="position:fixed; bottom:90px; right:30px; cursor:pointer; z-index:9999;">
        <img src="https://cdn-icons-png.flaticon.com/512/8943/8943377.png" width="60" style="filter: drop-shadow(0px 4px 10px rgba(0,0,0,0.3));">
    </div>

    <iframe id="ai-frame" src="/SP26_DUAN1/chat-plugin.php" style="display:none; position:fixed; bottom:160px; right:30px; width:350px; height:600px; border:none; box-shadow:0 5px 25px rgba(0,0,0,0.2); border-radius:15px; z-index:9999;"></iframe>

    <script>
        function toggleAI() {
            var f = document.getElementById("ai-frame");
            f.style.display = (f.style.display === "none") ? "block" : "none";
        }
    </script>
    </body>


    <!-- Mirrored from htmldemo.net/corano/corano/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Jun 2024 09:53:43 GMT -->

    </html>