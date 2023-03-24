<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface {
    public function all(){
        return Category::all();
    }
    public function store($data){
        return Category::create($data);
    }
    public function show($id){
        return Category::find($id);
         
    }
    public function update($data){
        return  Category::find($data['id'])->update($data);
    }   

    public function destroy($id){
        $category= Category::find($id);
        if($category){
            $category->delete();
          
        }
        else{
            return null;
        }
       
    }
}