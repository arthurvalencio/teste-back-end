<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface {
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function search($keyword);
    public function imageSearch($bool);
}
