<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ValidatorController;
use App\Repositories\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo) {
        $this->categoryRepo= $categoryRepo;
    }

    public function index(){
            $category= $this->categoryRepo->all();
            return response()->json(['data'=>$category]);
    }

    public function store(Request $request){
    
        $data=$request->all();
        $rules=[
            'name'=>'required',
            'description'=>'required'
        ];
        $validate= $this->validate_data($data,$rules);
        if($validate['response']){
            $category=$this->categoryRepo->store($data);
            return response()->json(['data'=>$category,'message'=>'Category Added Successfully']);
        }
        else{
            return response()->json(['data'=>$validate]);
        }
       
    }
    public function show($id){
       $category= $this->categoryRepo->show($id);
    //    dd($category);
       return response()->json(['data'=>$category]);
    }

    public function update(Request $request){
        $data=$request->all();
        $rules=[
            'name'=>'required',
            'description'=>'required'
        ];
        $validate= $this->validate_data($data,$rules);
        // dd($validate['response']);
        if($validate['response']){
            $category=$this->categoryRepo->update($data);
            return response()->json(['data'=>$category,'message'=>'Category Updated Successfully']);
        }
        else{
            return response()->json(['data'=>$validate]);
        }
    }

        public function destroy($id){
           
            $category=$this->categoryRepo->destroy($id);
            if($category){
                return response()->json(['message'=>'Category Deleted Successfully']);
            }
            else{
                return response()->json(['data'=>'Category Id Not Found']);
            }
        }
        



    public function validate_data($data , $rules){
        $common_ctrl = new ValidatorController();
        return $common_ctrl->validator($data,$rules);
    }

 }
                