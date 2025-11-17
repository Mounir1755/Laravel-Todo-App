<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class taskModel extends Model
{
    public function GetAllTasks() {
        $result = DB::table('tasks')->get();

        return $result;
    }
}
