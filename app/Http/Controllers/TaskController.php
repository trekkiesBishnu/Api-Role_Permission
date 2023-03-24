<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TaskRepositoryInterface;
use App\Http\Controllers\Api\ValidatorController;

class TaskController extends Controller
{
    protected $task;
    public function __construct(TaskRepositoryInterface $task)
    {
        $this->task = $task;
    }

    public function index(){
       $tasks= $this->task->all();
       return response()->json(['message'=>$tasks]);
    }

    public function store(Request $request){
        $data=$request->all();
        $rules=[
            'user_id'=>'required|integer',
            'category_id'=>'required|integer',
            'name'=>'required|string',
            'description'=>'required|string',
            'endDate'=>'required|date',
            'status'=>'nullable',
            'image'=>'nullable'

        ];
        $data['user_id']=Auth::id();
        $validate=$this->validate_data($data,$rules);
        if($validate['response']){
          $tasks=  $this->task->store($data);
            return response()->json(['message'=>$tasks]);
        }
        else{
            return response()->json(['message'=>$validate]);
        }

    }

    public function show($id){
      $task=  $this->task->show($id);
        return response()->json(['message'=>$task]);
    }

    public function update(Request $request){
        $data=$request->all();
        $rules=[
            'user_id'=>'required|integer',
            'category_id'=>'required|integer',
            'name'=>'required|string',
            'description'=>'required|string',
            'endDate'=>'required|date',
            'status'=>'nullable',
            'image'=>'nullable'

        ];
        $data['user_id']=Auth::id();
        $validate=$this->validate_data($data,$rules);
        if($validate['response']){
            $task=$this->task->update($data);
            
            return response()->json(['message'=>$task]);
        }
        else{
            return response()->json(['message'=>$validate]);
        }
    }

    public function delete($id){
      $task=  $this->task->destroy($id);
        return response()->json(['message'=>$task]) ;
    }
    public function validate_data($data,$rules){
        $validated_ctr=new ValidatorController();
        return $validated_ctr->validator($data,$rules);
    }
}
