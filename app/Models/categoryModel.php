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

    public function CreateNewCategory($data) {
        DB::table('categories')->insert([
            [
                 'userId'               => $data['userId']
                ,'categoryTitle'        => $data['categoryTitle']
                ,'categoryDescription'  => $data['categoryDescription']
            ]
        ]);
    }
}
