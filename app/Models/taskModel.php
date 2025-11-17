<?php

namespace App\Models;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class taskModel extends Model
{
    public function GetAllTasksById($userId) {
        $result = DB::table('tasks')->get()->where('userId', '=', $userId);

        return $result;
    }

    public function CreateNewTask($data) {
        DB::table('tasks')->insert([
            [
                 'userId'       => $data['userId']
                ,'title'        => $data['title']
                ,'description'  => $data['description']
            ]
        ]);
    }
    
}
