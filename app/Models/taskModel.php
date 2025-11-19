<?php

namespace App\Models;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class taskModel extends Model
{
    public function GetAllTasksById($userId) {
        $result = DB::table('tasks')
                        ->get()
                        ->where('userId', '=', $userId);

        return $result;
    }

    public function GetTaskInfoById($id) {
        $result = DB::table('tasks')
                        ->get()
                        ->where('id', '=', $id)
                        ->first();

        return $result;
    }

    public function CreateNewTask($data) {
        DB::table('tasks')->insert([
                 'userId'       => $data['userId']
                ,'title'        => $data['title']
                ,'description'  => $data['description']
        ]);
    } 

    public function SoftDelete($id) {
        DB::table('tasks')->where('id', $id)->update(['isActive' => 0]);
    }

    public function DeleteTask($id) {
        DB::table('category_task')->where('taskId', $id)->delete();
        DB::table('tasks')->where('id', $id)->delete();
    }

    public function MarkTaskAsDone($id) {
        DB::table('tasks')->where('id', $id)->update(['Done' => 1]);
    }
    
    public function UpdateTask($id, $newData) {
        DB::table('tasks')
                ->where('id', $id)
                ->update(
                    [
                        
                             'title'        => $newData['title']
                            ,'description'  => $newData['description']
                    ]
                );
    }   

    public function AddTaskToCategory($data) {
        DB::table('category_task')->insert([
                 'categoryId' => $data['categoryId']
                ,'taskId'     => $data['taskId']
        ]);
    }
}
