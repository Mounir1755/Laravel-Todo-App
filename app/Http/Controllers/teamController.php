<?php

namespace App\Http\Controllers;

use App\Models\teamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Exceptions\ReturnNewClassExecutionEndingException;

class teamController extends Controller
{

    private $teamModel;

    public function __construct()
    {
        $this->teamModel = new teamModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $teams = $this->teamModel->GetAllTeams($userId);

        // dd($teams);

        return view('team.index', [
            'title' => 'your teams',
            'teams' => $teams
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('team.create', [
            'title' => 'make'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        $teamId = $this->teamModel->CreateNewTeam($data, $userId);

        return redirect()->route('team.addUsersToTeam', [
            'teamId'      => $teamId,
            'teamName'    => $data['title'],
            'title'       => 'Invite team members.',
            'description' => 'Invite team members now or skip and add them later.'
        ]);
    }
    
    /**
     * Show the form for adding users to a team
     */
    public function addUsersToTeam(Request $request)
    {
        $teamId = $request->route('id');
        
        return view('team.addUsersToTeam', [
            'teamId'      => $teamId,
            'title'       => 'Invite team members.',
            'description' => 'Invite team members now or skip and add them later.'
        ]);
    }

    /**
     * Show the form for adding users to a team
     */
    public function addUserToTeam(Request $request)
    {
        $data = $request->validate([
            'email'  => 'required|string|max:255',
            'teamId' => 'required'
        ]);

        $userId = $this->teamModel->CheckUserEmail($data);

        $teamId = $data['teamId'];
        $userAlreadyInTeam = $this->teamModel->CheckUserInTeam($teamId, $userId);

        
        if($userAlreadyInTeam) {
            return redirect()->back()->with([
                'error' => 'this user is already invited to the team!'
            ]);
        }

        if(!$userId) {
            return redirect()->back()->with([
                'error' => 'this user is not registerd!'
            ]);
        }

        $this->teamModel->AddUsersToTeam($teamId, $userId);

        return redirect('team');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $teamId = $request->route('id');
        $tasks = $this->teamModel->GetAllTasks($teamId);
        // dd($tasks);
        return view('team.show', [
             'title'  => 'make a new task'
            ,'teamId' => $teamId
            ,'tasks'  => $tasks
        ]);
    }

    /**
     * Create a task
     */
    public function createTask(Request $request)
    {
        $teamId = $request->route('id');

        return view('team.createTask', [
            'teamId' => $teamId,
            'title' => 'add tasks'
        ]);
    }

        /**
     * Create a task
     */
    public function storeTask(Request $request)
    {
        $data = $request->validate([
            'teamId'        => 'required',
            'title'         => 'required|string|max:255',
            'description'   => 'required|string|max:255',
        ]);

        $userId = Auth::id();

        $this->teamModel->CreateNewTask($userId, $data);

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
