<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    protected $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function index() {
        $categories = $this->categoryService->getAll();
        return response()->json($categories);
    }

    public function show($id) {
        $category = $this->categoryService->getById($id);
        return response()->json($category);
    }

    public function store(Request $request) {
        $data = $request->all();
        $category = $this->categoryService->create($data);
        return response()->json($category, 201);
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        $category = $this->categoryService->update($id, $data);
        return response()->json($category);
    }

    public function destroy($id) {
        $this->categoryService->delete($id);
        return response()->json(null, 204);
    }

    public function search(Request $request) {
        $keyword = $request->input('s');
        if (!$keyword) {
            return $this::index();
        }
        $categories = $this->categoryService->search($keyword);
        return response()->json($categories);
    }
}
