<?php

class ProductController
{
    public $modelSanPham;

    public function __construct()
    {
        $this->modelSanPham = new SanPham();
    }

    /**
     * Hiển thị danh sách sản phẩm với support cho search và filter
     */
    public function index()
    {
        // Lấy từ khóa tìm kiếm từ GET
        $searchKeyword = trim($_GET['search'] ?? '');
        
        // Lấy giá tối thiểu và tối đa từ GET
        $minPrice = isset($_GET['min_price']) && !empty($_GET['min_price']) ? intval($_GET['min_price']) : 0;
        $maxPrice = isset($_GET['max_price']) && !empty($_GET['max_price']) ? intval($_GET['max_price']) : 999999999;
        
        // Lấy loại sản phẩm từ GET
        $productType = trim($_GET['type'] ?? '');

        // Nếu có từ khóa tìm kiếm hoặc filter, gọi hàm search
        if (!empty($searchKeyword) || !empty($productType) || ($minPrice > 0 || $maxPrice < 999999999)) {
            $listSanPham = $this->modelSanPham->searchProducts(
                $searchKeyword,
                $minPrice,
                $maxPrice,
                $productType
            );
        } else {
            // Nếu không có filter, lấy toàn bộ sản phẩm
            $listSanPham = $this->modelSanPham->getAllSanPham();
        }

        // Lấy danh sách các loại sản phẩm duy nhất từ database để hiển thị filter
        $productTypes = $this->modelSanPham->getProductTypes();

        $listSanPham = $this->modelSanPham->getAllSanPham();
        function calcDiscountPercent($originalPrice, $salePrice)
        {
            if ($originalPrice <= 0 || $salePrice >= $originalPrice) {
                return 0;
            }

            return round((($originalPrice - $salePrice) / $originalPrice) * 100);
        }

        require_once './views/sanPham.php';
    }
}
