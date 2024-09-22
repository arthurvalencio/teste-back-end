<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller {
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function index() {
        $products = $this->productService->getAll();
        return response()->json($products);
    }

    public function show($id) {
        $product = $this->productService->getById($id);
        return response()->json($product);
    }

    public function store(Request $request) {
        $data = $request->all();
        $product = $this->productService->create($data);
        return response()->json($product, 201);
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        $product = $this->productService->update($id, $data);
        return response()->json($product);
    }

    public function destroy($id) {
        $this->productService->delete($id);
        return response()->json(null, 204);
    }

    public function search(Request $request) {
        $keyword = $request->input('s');
        if (!$keyword) {
            return $this::index();
        }
        $products = $this->productService->search($keyword);
        return response()->json($products);
    }

    public function imageSearch(Request $request) {
        $keyword = $request->input('s');
        if (!is_bool(filter_var($keyword, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
            return response()->json(['error' => 'O parâmetro deve ser true ou false.'], 400);
        }
        $products = $this->productService->imageSearch(filter_var($keyword, FILTER_VALIDATE_BOOLEAN));
        return response()->json($products);
    }
}
