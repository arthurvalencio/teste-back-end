<?php

namespace App\Services;

use App\Repositories\Eloquent\ProductRepository;
use App\Models\Category;

class ProductService {

    protected $productRepository;

    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function getAll() {
        $products = $this->productRepository->getAll();

        foreach ($products as $product) {
            $category = Category::find($product['category']);

            $product['category'] = $category->name;
        }

        return $products;
    }

    public function getById($id) {
        return $this->productRepository->find($id);
    }

    public function create($data) {
        $category = Category::firstOrCreate(['name' => $data['category']]);

        $product = [
            'name' => trim($data['name']),
            'price' => $data['price'],
            'description' => trim($data['description']),
            'category' => $category->id,
            'image_url' => isset($data['image']) ? trim($data['image']) : null
        ];
        return $this->productRepository->create($product);
    }

    public function update($id, $data) {
        $category = Category::firstOrCreate(['name' => $data['category']]);

        $product = [
            'name' => trim($data['name']),
            'price' => $data['price'],
            'description' => trim($data['description']),
            'category' => $category->id,
            'image_url' => isset($data['image']) ? trim($data['image']) : null
        ];
        return $this->productRepository->update($id, $product);
    }

    public function delete($id) {
        return $this->productRepository->delete($id);
    }

    public function search($keyword) {
        return $this->productRepository->search($keyword);
    }

    public function imageSearch($bool) {
        return $this->productRepository->imageSearch($bool);
    }
}
