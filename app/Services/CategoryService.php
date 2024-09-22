<?php

namespace App\Services;

use App\Repositories\Eloquent\CategoryRepository;

class CategoryService {

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll() {
        return $this->categoryRepository->getAll();
    }

    public function getById($id) {
        return $this->categoryRepository->find($id);
    }

    public function create($data) {
        $data['name'] = trim($data['name']);
        return $this->categoryRepository->create($data);
    }

    public function update($id, $data) {
        $data['name'] = trim($data['name']);
        return $this->categoryRepository->update($id, $data);
    }

    public function delete($id) {
        return $this->categoryRepository->delete($id);
    }

    public function search($keyword) {
        return $this->categoryRepository->search($keyword);
    }
}
