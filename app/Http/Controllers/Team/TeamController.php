<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Team;

class TeamController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => Team::all(), 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        return Team::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Team::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        try {
            $team = Team::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->teamNotFound();
        }

        $team->update($request->all());

        return response()->json($team, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $team = Team::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->teamNotFound();
        }
        $team->delete();

        return response()->json([], 204);
    }
}
