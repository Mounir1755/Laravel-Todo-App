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
                'ownerId'     => $userId,
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

    public function GetAllTeamMembersPluck($teamId)
    {
        $members = DB::table('team_user as tu')
            ->join('teams as t', 'tu.teamId', '=', 't.id')
            ->join('users as u', 'tu.userId', '=', 'u.id')
            ->where('tu.teamId', $teamId)
            ->pluck('u.name');

        return $members;
    }

    public function GetAllTeamMembersSelect($teamId)
    {
        $members = DB::table('team_user as tu')
            ->join('teams as t', 'tu.teamId', '=', 't.id')
            ->join('users as u', 'tu.userId', '=', 'u.id')
            ->where('tu.teamId', $teamId)
            ->select(
                 'u.name'
                ,'u.id as userId'
            )
            ->get();

        return $members;
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

    public function GetAllTasks($teamId) {
        return DB::table('team_task as tts')
            ->join('teams as t',  'tts.teamId', '=', 't.id')
            ->join('users as u',  'tts.userId', '=', 'u.id')
            ->join('users as at', 'tts.assignedTo', '=', 'at.id')
            ->where('tts.teamId', $teamId)
            ->select(
                 'tts.id'
                ,'at.name         as assignedTo'
                ,'tts.title       as taskTitle'
                ,'tts.description as taskDescription'
                ,'tts.done'
                ,'tts.isActive'
            )
            ->get();
    }

    public function GetTaskById($Id) {
        return DB::table('team_task as tts')
            ->join('users as u',  'tts.userId',     '=', 'u.id')
            ->join('users as at', 'tts.assignedTo', '=', 'at.id')
            ->select(
                'tts.id',
                'at.name as assignedTo',
                'tts.title as taskTitle',
                'tts.description as taskDescription'
            )
            ->where('tts.id', $Id)
            ->first();
    }


    public function GetTeamName($teamId)
    {
        return DB::table('teams')
            ->where('id', $teamId)
            ->value('title');
    }

    public function CreateNewTask($userId, $data) {
        DB::table('team_task')->insert([
            'teamId'      => $data['teamId'],
            'userId'      => $userId,
            'assignedTo'  => $userId,  
            'title'       => $data['title'],
            'description' => $data['description']
        ]);
    }

    public function MarkAsDone($id)
    {
        $checkIfDone = DB::table('team_task')
                            ->where('id', $id)
                            ->value('done'); // < pakt alleen de waarde niet de hele kolom

        if ($checkIfDone == 0) {
            DB::table('team_task')
                ->where('id', $id)
                ->update(['done' => 1]);
        } elseif ($checkIfDone == 1) {
            DB::table('team_task')
                ->where('id', $id)
                ->update(['done' => 0]);
        } else {
            return 'Er is iets fout gegaan.';
        }
    }

    public function UpdateTask($data, $taskId) {
        DB::table('team_task')
            ->where('id', $taskId)
            ->update(
                [
                     'title' => $data['title']
                    ,'description' => $data['description']
                    ,'assignedTo' => $data['assignedTo']
                ]
            );
    } 
}
