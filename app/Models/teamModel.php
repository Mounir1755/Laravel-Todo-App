<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class teamModel extends Model
{
    public function CreateNewTeam($data, $userId)
    {
        DB::transaction(function () use ($data, $userId) {
            $teamId = DB::table('teams')->insertGetId([
                'title'       => $data['title'],
                'description' => $data['description']
            ]);

            DB::table('team_user')->insert([
                'teamId'    => $teamId,
                'userId'    => $userId
            ]);

            // return $teamId;
        });
    }


    public function LinkUserToTeam($teamId, $userId) {
        DB::table('team_user')->insert([
             'teamId'   => $teamId
            ,'userId'   => $userId
        ]);
    }

    public function GetAllTeams($userId) {
        $result = DB::table('team_user as tu')
            ->join('teams as t', 'tu.teamId', '=', 't.id')
            ->join('users as u', 'tu.userId', '=', 'u.id')
            ->where('tu.userId', $userId)
            ->select(
                't.title',
                't.description'
            )
            ->get();
            
        return $result;
    }
}
