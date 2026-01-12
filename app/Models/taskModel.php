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

    public function GetTasksCountById($userId)
    {
        $teamTasks = DB::table('team_task')
            ->leftJoin('users as u', 'team_task.assignedTo', '=', 'u.id')
            ->where('team_task.assignedTo', $userId)
            ->select(
                'team_task.id as taskId'
            );

        $normalTasks = DB::table('tasks')
            ->leftJoin('users as u2', 'tasks.userId', '=', 'u2.id')
            ->where('tasks.userId', $userId)
            ->select(
                'tasks.id as taskId'
            );

        return $teamTasks->unionAll($normalTasks) // <- unionAll merges results from 2 into 1
                         ->count(); // <- counts amount of results
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

    public function RetreiveTask($id) {
        DB::table('tasks')->where('id', $id)->update(['isActive' => 1]);
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

    public function MarkAsDone($id)
    {
        $checkIfDone = DB::table('tasks')
                            ->where('id', $id)
                            ->value('done'); // < pakt alleen de waarde niet de hele kolom

        if ($checkIfDone == 0) {
            DB::table('tasks')
                ->where('id', $id)
                ->update(['done' => 1]);
        } elseif ($checkIfDone == 1) {
            DB::table('tasks')
                ->where('id', $id)
                ->update(['done' => 0]);
        } else {
            return 'Er is iets fout gegaan.';
        }
    }

    public function AddTaskToCategory($data) {
        DB::table('category_task')->insert([
                 'categoryId' => $data['categoryId']
                ,'taskId'     => $data['taskId']
        ]);
    }
}
