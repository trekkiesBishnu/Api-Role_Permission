<?php
namespace App\Repositories;
interface CategoryRepositoryInterface {
    public function all();
    public function store($data);
    public function show($id);
    public function update($data);
    public function destroy($id);
}