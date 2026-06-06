<?php

namespace App\Controllers;

use App\Models\ProductModel;

class SearchController extends BaseController
{
    public function index()
    {
        $q = trim($this->request->getGet('q') ?? '');

        if (strlen($q) < 2) {
            return $this->response->setJSON(['products' => []]);
        }

        $productModel = new ProductModel();
        $products     = $productModel->search($q, 8);

        $results = array_map(fn($p) => [
            'id'        => $p['id'],
            'name'      => $p['name'],
            'price'     => number_format($p['price'], 0),
            'image_url' => $p['image_url'],
            'slug'      => $p['slug'],
        ], $products);

        return $this->response->setJSON(['products' => $results]);
    }
}