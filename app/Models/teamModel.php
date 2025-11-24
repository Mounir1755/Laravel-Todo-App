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

            return $teamId;
        });
    }

    public function CheckUserEmail($data) {
        $result = DB::table('users')
            ->where('email', '=', $data['email'])
            ->value('id');

        return $result;
    }
    
    public function CheckUserInTeam($teamId, $userId) {
        $result = DB::table('team_user')
            ->where('teamId', '=', $teamId)
            ->where('userId', '=', $userId)
            ->first();

        return $result;
    }

    public function AddUsersToTeam($teamId, $userId) {
        DB::table('team_user')->insert([
            'teamId'    => $teamId,
            'userId'    => $userId
        ]);
    }

    public function GetAllTeams($userId) {
        $result = DB::table('team_user as tu')
            ->join('teams as t', 'tu.teamId', '=', 't.id')
            ->join('users as u', 'tu.userId', '=', 'u.id')
            ->where('tu.userId', $userId)
            ->select(
                't.id',
                't.title',
                't.description'
            )
            ->get();

        return $result;
    }
}
