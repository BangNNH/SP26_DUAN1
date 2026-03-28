<?php

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

// Đường dẫn đến client
define('BASE_URL', 'http://localhost/SP26_DuAn1/mvc-oop-basic/');
// Đường dẫn đến admin
define('BASE_URL_ADMIN', 'http://localhost/SP26_DuAn1/mvc-oop-basic/admin/');
// đường dẫn đến file assets
define('BASE_ASSETS', 'http://localhost/SP26_DuAn1/mvc-oop-basic/assets/');
// đường dẫn đến admin/assets
define('BASE_ASSETS_ADMIN', 'http://localhost/SP26_DuAn1/mvc-oop-basic/admin/assets/');

define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'watch_hub');  // Tên database

define('PATH_ROOT', __DIR__ . '/../');

define('BASE_ASSETS_IMG', BASE_URL . 'assets/img/');

define('PATH_ASSETS_IMG', PATH_ROOT . 'assets/img/');
