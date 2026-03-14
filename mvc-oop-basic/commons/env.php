<?php

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

// Đường dẫn đến client
define('BASE_URL', 'http://localhost/SP26_DuAn1/mvc-oop-basic/');
// Đường dẫn đến admin
define('BASE_URL_ADMIN', 'http://localhost/SP26_DuAn1/mvc-oop-basic/admin/');

define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'xuong_thu_cung');  // Tên database

define('PATH_ROOT', __DIR__ . '/../');
