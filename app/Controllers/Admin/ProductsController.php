<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductsController extends BaseController
{
    private ProductModel $productModel;
    private CategoryModel $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $category = (int) ($this->request->getGet('category') ?? 0);

        $builder = $this->productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left');

        if ($search) {
            $builder->like('products.name', $search);
        }
        if ($category) {
            $builder->where('products.category_id', $category);
        }

        $products = $builder->orderBy('products.id', 'DESC')->findAll();

        $data = [
            'title' => 'Products — Admin',
            'products' => $products,
            'categories' => $this->categoryModel->getActive(),
            'search' => $search,
        ];

        return view('admin/partials/admin_header', $data)
            . view('admin/products', $data)
            . view('admin/partials/admin_footer');
    }

    public function get(int $id)
    {
        $product = $this->productModel->find($id);
        return $this->response->setJSON($product ?: ['error' => 'Not found']);
    }

    public function store()
    {
        $post = $this->request->getPost();
        $slug = $this->productModel->generateSlug($post['name']);

        $imageUrl = 'assets/images/products/placeholder.jpg';
        $file = $this->request->getFile('image');

        // ✅ FIXED: allowed arrays defined properly
        $allowedMime = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $mime = $file->getMimeType();
            $ext = strtolower($file->getExtension());

            if (!in_array($mime, $allowedMime) || !in_array($ext, $allowedExt)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Images only (jpg, jpeg, png, webp, gif).'
                ]);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'assets/images/products/', $newName);
            $imageUrl = 'assets/images/products/' . $newName;
        }

        $this->productModel->insert([
            'name' => $post['name'],
            'slug' => $slug,
            'category_id' => $post['category_id'],
            'price' => $post['price'],
            'original_price' => $post['original_price'] ?: null,
            'stock' => $post['stock'],
            'unit' => $post['unit'],
            'image_url' => $imageUrl,
            'description' => $post['description'],
            'is_featured' => isset($post['is_featured']) ? 1 : 0,
            'is_on_sale' => isset($post['is_on_sale']) ? 1 : 0,
            'discount_percent' => $post['discount_percent'] ?? 0,
            'is_active' => 1,
        ]);

        $this->categoryModel->updateProductCount((int) $post['category_id']);
        return $this->response->setJSON(['success' => true, 'message' => 'Product added!']);
    }

    public function update(int $id)
    {
        $post = $this->request->getPost();
        $product = $this->productModel->find($id);

        if (!$product) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not found.']);
        }

        $imageUrl = $product['image_url'];
        $file = $this->request->getFile('image');

        // ✅ FIXED again (same fix applied here)
        $allowedMime = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $mime = $file->getMimeType();
            $ext = strtolower($file->getExtension());

            if (!in_array($mime, $allowedMime) || !in_array($ext, $allowedExt)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Images only (jpg, jpeg, png, webp, gif).'
                ]);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'assets/images/products/', $newName);
            $imageUrl = 'assets/images/products/' . $newName;
        }

        $this->productModel->update($id, [
            'name' => $post['name'],
            'category_id' => $post['category_id'],
            'price' => $post['price'],
            'original_price' => $post['original_price'] ?: null,
            'stock' => $post['stock'],
            'unit' => $post['unit'],
            'image_url' => $imageUrl,
            'description' => $post['description'],
            'is_featured' => isset($post['is_featured']) ? 1 : 0,
            'is_on_sale' => isset($post['is_on_sale']) ? 1 : 0,
            'discount_percent' => $post['discount_percent'] ?? 0,
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Product updated!']);
    }

    public function delete(int $id)
    {
        $this->productModel->update($id, ['is_active' => 0]);
        return $this->response->setJSON(['success' => true, 'message' => 'Product deleted.']);
    }
}

