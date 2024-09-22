<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\Category;

class ProductRepository implements ProductRepositoryInterface {
    protected $model;

    public function __construct(Product $product) {
        $this->model = $product;
    }

    public function getAll() {
        return $this->model->all();
    }

    public function find($id) {
        return $this->model->findOrFail($id);
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function update($id, $data) {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete($id) {
        $product = $this->find($id);
        return $product->delete();
    }

    public function search($keyword)
    {
        $products = $this->model
            ->join('categories', 'products.category', '=', 'categories.id')
            ->where('products.name', 'like', '%' . $keyword . '%')
            ->orWhere('categories.name', 'like', '%' . $keyword . '%')
            ->select('products.*')
            ->get();

        foreach ($products as $product) {
            $category = Category::find($product['category']);

            $product['category'] = $category->name;
        }

        return $products;
    }

    public function imageSearch($bool)
    {
        if ($bool) {
            $products = $this->model
                ->whereNotNull('image_url')
                ->where('image_url', '!=', '')
                ->get();
        } else {
            $products = $this->model
                ->where(function ($query) {
                    $query->whereNull('image_url')
                        ->orWhere('image_url', '=', '');
                })
                ->get();
        }

        foreach ($products as $product) {
            $category = Category::find($product['category']);

            $product['category'] = $category->name;
        }

        return $products;
    }
}
