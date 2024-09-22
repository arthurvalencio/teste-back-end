<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface {

    protected $model;

    public function __construct(Category $category) {
        $this->model = $category;
    }

    public function getAll() {
        return $this->model->all();
    }

    public function find($id) {
        return $this->model->findOrFail($id);
    }

    public function create(array $data) {
        return $this->model->create($data);
    }

    public function update($id, $data) {
        $category = $this->find($id);
        $category->update($data);
        return $category;
    }

    public function delete($id) {
        $category = $this->find($id);
        return $category->delete();
    }

    public function search($keyword)
    {
        return $this->model->where('name', 'like', '%' . $keyword . '%')->get();
    }
}
