<?php

namespace App\Http\Controllers;

use App\Models\teamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        dd($teams);

        return view('team.index', [
            'title' => 'teams'
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

        $this->teamModel->CreateNewTeam($data, $userId);

        return view('team.inviteUsersToTeam', [
            'teamName'    => $data['title'],
            'title'       => 'Invite team members.',
            'description' => 'Invite team members now or skip and add them later.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
