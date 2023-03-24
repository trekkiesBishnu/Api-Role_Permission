<?php
namespace App\Repositories;

interface TaskRepositoryInterface
{ 
    public function all();
    public function store($data);
    public function show($id);
    public function update($data);
    public function destroy($id);
}
