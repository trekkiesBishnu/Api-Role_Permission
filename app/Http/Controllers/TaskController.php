<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
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
       return response()->json(['data'=>$tasks]);
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
            return response()->json(['data'=>$tasks]);
        }
        else{
            return response()->json(['data'=>$validate]);
        }

    }

    public function show($id){
      $task=  $this->task->show($id);
        return response()->json(['data'=>$task]);
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
            
            return response()->json(['data'=>$task]);
        }
        else{
            return response()->json(['data'=>$validate]);
        }
    }

    public function delete($id){
      $task=  $this->task->destroy($id);
        return response()->json(['message'=>'Task deleted Successfully']) ;
    }
    public function validate_data($data,$rules){
        $validated_ctr=new ValidatorController();
        return $validated_ctr->validator($data,$rules);
    }
}
