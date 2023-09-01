<?php

namespace App\Http\Controllers;

use App\Models\AgeGroup;
use App\Http\Requests\StoreAgeGroupRequest;
use App\Http\Requests\UpdateAgeGroupRequest;

class AgeGroupController extends Controller
{
    /**
     * Display a listing of age groups.
     *
     * @group Age Groups
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * Retrieves a list of all age groups.
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 1,
     *             "title": "Ages 3-5"
     *         },
     *         {
     *             "id": 2,
     *             "title": "Ages 5-8"
     *         },
     *         // ... (other age group objects)
     *     ]
     * }
     */
    public function index()
    {
        // Retrieve a list of all age groups
        $ageGroups = AgeGroup::all();

        return response()->json(['data' => $ageGroups]);
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
    public function store(StoreAgeGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AgeGroup $ageGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgeGroup $ageGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgeGroupRequest $request, AgeGroup $ageGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgeGroup $ageGroup)
    {
        //
    }
}
