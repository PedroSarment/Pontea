<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;

class LevelController extends Controller
{
    /**
     * Display a listing of levels.
     *
     * @group Levels
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     * Retrieves a list of all levels.
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 1,
     *             "title": "Beginner"
     *         },
     *         {
     *             "id": 2,
     *             "title": "Intermediate"
     *         },
     *         // ... (other level objects)
     *     ]
     * }
     */
    public function index()
    {
        // Retrieve a list of all levels
        $levels = Level::all();

        return response()->json(['data' => $levels]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLevelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLevelRequest $request, Level $level)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level)
    {
        //
    }
}
