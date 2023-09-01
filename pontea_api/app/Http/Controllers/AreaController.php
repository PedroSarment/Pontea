<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Area;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;

class AreaController extends Controller
{
    /**
     * Display a listing of areas with associated activities.
     *
     * @group Areas
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * Retrieves a list of all areas along with a count of activities in each area
     * and details of the activities including age groups, levels, and creators.
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 1,
     *             "title": "Science",
     *             "activities_count": 3,
     *             "activities": [
     *                 {
     *                     "id": 1,
     *                     "created_by": {
     *                         "id": 1,
     *                         "name": "John Doe",
     *                         "email": "john@example.com",
     *                         "created_at": "2023-09-01T12:34:56Z",
     *                         "updated_at": "2023-09-01T12:34:56Z"
     *                     },
     *                     "age_group": {
     *                         "id": 2,
     *                         "title": "Ages 5-8"
     *                     },
     *                     "level": {
     *                         "id": 3,
     *                         "title": "Intermediate"
     *                     },
     *                     "title": "Fun Science Experiment",
     *                     "description": "A simple and fun science experiment for kids.",
     *                     "media_path_1": "https://example.com/media/experiment.jpg",
     *                     "media_path_2": null,
     *                     "media_path_3": null,
     *                     "media_path_4": null,
     *                     "created_at": "2023-09-02T10:15:30Z",
     *                     "updated_at": "2023-09-02T10:15:30Z"
     *                 },
     *                 // ... (other activity objects in the Science area)
     *             ]
     *         },
     *         {
     *             "id": 2,
     *             "title": "Art",
     *             "activities_count": 2,
     *             "activities": [
     *                 {
     *                     "id": 2,
     *                     "created_by": {
     *                         "id": 2,
     *                         "name": "Alice Smith",
     *                         "email": "alice@example.com",
     *                         "created_at": "2023-09-01T13:45:00Z",
     *                         "updated_at": "2023-09-01T13:45:00Z"
     *                     },
     *                     "age_group": {
     *                         "id": 1,
     *                         "title": "Ages 3-5"
     *                     },
     *                     "level": {
     *                         "id": 2,
     *                         "title": "Beginner"
     *                     },
     *                     "title": "Creative Painting",
     *                     "description": "Learn creative painting techniques for beginners.",
     *                     "media_path_1": "https://example.com/media/painting.jpg",
     *                     "media_path_2": null,
     *                     "media_path_3": null,
     *                     "media_path_4": null,
     *                     "created_at": "2023-09-02T11:30:45Z",
     *                     "updated_at": "2023-09-02T11:30:45Z"
     *                 },
     *                 // ... (other activity objects in the Art area)
     *             ]
     *         },
     *         // ... (other area objects)
     *     ]
     * }
     */
    public function index()
    {
        // Recuperar todas as áreas com contagem de atividades
        $areas = Area::withCount('activities')->get();

        // Recuperar todas as atividades com os relacionamentos carregados
        $activities = Activity::with('ageGroup', 'area', 'level', 'createdByUser')->get();

        // Formatar os dados para inclusão das atividades em cada área
        $formattedAreas = [];
        foreach ($areas as $area) {
            $formattedArea = $area->toArray();
            $formattedArea['activities'] = $activities->where('area_id', $area->id)->toArray();
            $formattedAreas[] = $formattedArea;
        }

        return response()->json(['data' => $formattedAreas]);
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
    public function store(StoreAreaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAreaRequest $request, Area $area)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        //
    }
}
