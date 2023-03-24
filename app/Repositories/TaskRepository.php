<?php
namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use App\Notifications\TaskNotify;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


class TaskRepository implements TaskRepositoryInterface
{ 
    public function all(){
        return Task::with('user','category','media')->latest()->get();
    }
    public function store($data){
        $category=Category::find($data['category_id']);
        if($category){
            $task= Task::create($data);
            if($data['image']){
                $task->addMedia($data['image'])->toMediaCollection('task_image');
            }
            
            
          //notification for Admin and superAdmin 
            // $user_role=Role::where('name','Admin')->orwhere('name','superAdmin')->get();
            $users=User::all();
            foreach ($users as $key => $user) {
                 if($user->hasRole(['Admin|superAdmin'])){
                    $data['message']="Added task ";
                    $data['name']=$task->name;
                    $data['description']=$task->description;
                    $data['user_id']=$task->user_id;
                    $data['category_id']=$task->category_id;
                    $data['status']=$task->status;
                     $email=$user->email;
                     Notification::route('mail', $email)->notify(new TaskNotify($data) );
                 }
             }
           
            return $task;
        }
        else{
            return "category id Not found";
        }
    }
    public function show($id){
       return $task=Task::where('id',$id)->with('category','user','media')->first();
    }

    public function update($data){
       
        $category=Category::find($data['category_id']);
        if($category){
            $task= Task::where('id',$data['id'])->first();
           
            if($task){
                $task->update($data);
                if($task->hasMedia('task_image')){
                    $task->clearMediaCollection('task_image');
                    $task->addMedia($data['image'])->toMediaCollection('task_image');
                }
                // dd( $task['status']);
                if($task['status']=="Acepted"){
                    $status=$task['status'];
                 
                }elseif ($task['status']=="Reject") {
                    $status=$task['status'];
                   
                }
                //for sending Admin And superAdmin only 
                $data['message']="update task ";
                $data['name']=$task->name;
                $data['description']=$task->description;
                $data['user_id']=$task->user_id;
                $data['category_id']=$task->category_id;
                $data['status']=$task->status;
                //$user_role=Role::where('name','Admin')->orwhere('name','superAdmin')->get();
                $users=User::role(['Admin','superAdmin'])->get();;
                foreach ($users as $key => $user) {
                    //  if($user->hasRole(['Admin|superAdmin'])){
    
                         $email=$user->email;
                         Notification::route('mail', $email)->notify(new TaskNotify($data) );
                    //  }
                 }

                return $task;
            }
        }
        else{
            return "Category Id Not Found!";
        }
    }

    public function destroy($id){
        $task=Task::find($id);
       if($task){
           $task->delete();
           return response()->json(['message' =>"Task deleted Successfully"]);
       }
       else{
           return "Id Already Deleted";
       }
        

       
    }
}
