<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class categoryModel extends Model
{
    public function GetAllCategoriesById($userId) {
        $result = DB::table('categories')->get()->where('userId', '=', $userId);

        return $result;
    }

    public function GetAllCategoryInfoById($Id) {
        $result = DB::table('categories')
                        ->get()
                        ->where('id', '=', $Id)
                        ->first();

        return $result;
    }

    public function GetAllTasksByCategoryId($Id) {
        $result = DB::table('category_task as ct')
            ->join('categories as c', 'ct.categoryId', '=', 'c.id')
            ->join('tasks as t', 'ct.taskId', '=', 't.id')
            ->where('ct.categoryId', $Id)
            ->select(
                't.*',
                'c.categoryTitle',
                'c.categoryDescription'
            )
            ->get();

        return $result;
    }


    public function CreateNewCategory($data) {
        DB::table('categories')->insert([
                 'userId'               => $data['userId']
                ,'categoryTitle'        => $data['categoryTitle']
                ,'categoryDescription'  => $data['categoryDescription']
        ]);
    }
}
