<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductController extends BaseController
{
    private ProductModel  $productModel;
    private CategoryModel $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function category(string $slug)
    {
        $category = $this->categoryModel->findBySlug($slug);
        if (! $category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $sort     = $this->request->getGet('sort') ?? 'default';
        $minPrice = (float)($this->request->getGet('min_price') ?? 0);
        $maxPrice = (float)($this->request->getGet('max_price') ?? 99999);

        $products = $this->productModel->getByCategory($category['id'], 20, $sort);

        // price filter
        if ($minPrice > 0 || $maxPrice < 99999) {
            $products = array_filter($products, function($p) use ($minPrice, $maxPrice) {
                return $p['price'] >= $minPrice && $p['price'] <= $maxPrice;
            });
        }

        $data = [
            'title'      => $category['name'] . ' — Amjad\'s Mart',
            'category'   => $category,
            'products'   => array_values($products),
            'categories' => $this->categoryModel->getActive(),
            'cartCount'  => $this->getCartCount(),
            'sort'       => $sort,
        ];

        return view('templates/header', $data)
             . view('products/category', $data)
             . view('templates/footer', $data);
    }

    public function detail(string $slug)
    {
        $product = $this->productModel->findBySlug($slug);
        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $related  = $this->productModel->getRelated($product['category_id'], $product['id'], 6);
        $category = $this->categoryModel->find($product['category_id']);

        $inWishlist = false;
        if ($userId = session()->get('user_id')) {
            $db = \Config\Database::connect();
            $inWishlist = (bool)$db->table('wishlist')
                ->where('user_id', $userId)
                ->where('product_id', $product['id'])
                ->countAllResults();
        }

        $data = [
            'title'      => $product['name'] . ' — Amjad\'s Mart',
            'product'    => $product,
            'related'    => $related,
            'category'   => $category,
            'inWishlist' => $inWishlist,
            'categories' => $this->categoryModel->getActive(),
            'cartCount'  => $this->getCartCount(),
        ];

        return view('templates/header', $data)
             . view('products/detail', $data)
             . view('templates/footer', $data);
    }

    private function getCartCount(): int
    {
        if (! session()->get('user_id')) return 0;
        $cartModel = new \App\Models\CartModel();
        return $cartModel->getCount(session()->get('user_id'));
    }
}