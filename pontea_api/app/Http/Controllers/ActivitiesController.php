<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Http\Requests\StoreActivitiesRequest;
use App\Http\Requests\UpdateActivitiesRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class ActivitiesController extends Controller
{
       /**
     * Retrieve all activities with related information.
     *
     * @group Activities
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * Retrieves a list of all activities along with their related information,
     * including age groups, areas, levels, and the user who created each activity.
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 1,
     *             "created_by": {
     *                 "id": 1,
     *                 "name": "John Doe",
     *                 "email": "john@example.com",
     *                 "created_at": "2023-09-01T12:34:56Z",
     *                 "updated_at": "2023-09-01T12:34:56Z"
     *             },
     *             "area": {
     *                 "id": 1,
     *                 "title": "Science"
     *             },
     *             "age_group": {
     *                 "id": 2,
     *                 "title": "Ages 5-8"
     *             },
     *             "level": {
     *                 "id": 3,
     *                 "title": "Intermediate"
     *             },
     *             "title": "Fun Science Experiment",
     *             "description": "A simple and fun science experiment for kids.",
     *             "media_path_1": "https://example.com/media/experiment.jpg",
     *             "media_path_2": null,
     *             "media_path_3": null,
     *             "media_path_4": null,
     *             "created_at": "2023-09-02T10:15:30Z",
     *             "updated_at": "2023-09-02T10:15:30Z"
     *         },
     *         {
     *             "id": 2,
     *             "created_by": {
     *                 "id": 2,
     *                 "name": "Alice Smith",
     *                 "email": "alice@example.com",
     *                 "created_at": "2023-09-01T13:45:00Z",
     *                 "updated_at": "2023-09-01T13:45:00Z"
     *             },
     *             "area": {
     *                 "id": 2,
     *                 "title": "Art"
     *             },
     *             "age_group": {
     *                 "id": 1,
     *                 "title": "Ages 3-5"
     *             },
     *             "level": {
     *                 "id": 2,
     *                 "title": "Beginner"
     *             },
     *             "title": "Creative Painting",
     *             "description": "Learn creative painting techniques for beginners.",
     *             "media_path_1": "https://example.com/media/painting.jpg",
     *             "media_path_2": null,
     *             "media_path_3": null,
     *             "media_path_4": null,
     *             "created_at": "2023-09-02T11:30:45Z",
     *             "updated_at": "2023-09-02T11:30:45Z"
     *             "note": 3.5
     *
     *         }
     *         // ... (other activity objects)
     *     ]
     * }
     * */
    public function index()
    {
        // Recuperar todas as atividades
        $activities = Activity::with('ageGroup', 'area', 'level', 'createdByUser')->get();

         // Calculate the average rating for each activity
            foreach ($activities as $activity) {
                $activity->note = $activity->comments->avg('note');
            }

        return response()->json(['data' => $activities]);
    }

        /**
     * Filter activities based on request parameters.
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * @group Activities
     *
     * This function allows you to filter activities based on various criteria, including text in the title or description,
     * age group, area, level, created by user, and the presence of multimedia resources or visual instructions.
     *
     * @queryParam text string The text to search in the title or description of the activity (optional).
     * @queryParam age_group_id integer The ID of the age group to filter activities by a specific age group (optional).
     * @queryParam area_id integer The ID of the area to filter activities by a specific area (optional).
     * @queryParam level_id integer The ID of the level to filter activities by a specific level (optional).
     * @queryParam created_by integer The ID of the user who created the activity to filter activities created by a specific user (optional).
     * @queryParam has_multimedia_resources boolean Defines whether the activity should have multimedia resources (true) or not (false) (optional).
     * @queryParam has_visual_instructions boolean Defines whether the activity should have visual instructions (true) or not (false) (optional).
     *
     * @response {
     *     "data": [
     *         {
     *             "id": 1,
     *             "created_by": {
     *                 "id": 1,
     *                 "name": "John Doe",
     *                 "email": "john@example.com",
     *                 "created_at": "2023-09-01T12:34:56Z",
     *                 "updated_at": "2023-09-01T12:34:56Z"
     *             },
     *             "area": {
     *                 "id": 1,
     *                 "title": "Science"
     *             },
     *             "age_group": {
     *                 "id": 2,
     *                 "title": "Ages 5-8"
     *             },
     *             "level": {
     *                 "id": 3,
     *                 "title": "Intermediate"
     *             },
     *             "title": "Sample Activity",
     *             "description": "Description of the sample activity.",
     *             "media_path_1": "media/activity1.jpg",
     *             "media_path_2": null,
     *             "media_path_3": null,
     *             "media_path_4": null,
     *             "has_multimedia_resources": true,
     *             "has_visual_instructions": false,
     *             "created_at": "2023-09-02T10:15:30Z",
     *             "updated_at": "2023-09-02T10:15:30Z"
     *             "note": 3.5
     *         },
     *         {
     *             "id": 2,
     *             "created_by": {
     *                 "id": 2,
     *                 "name": "Alice Smith",
     *                 "email": "alice@example.com",
     *                 "created_at": "2023-09-01T13:45:00Z",
     *                 "updated_at": "2023-09-01T13:45:00Z"
     *             },
     *             "area": {
     *                 "id": 2,
     *                 "title": "Art"
     *             },
     *             "age_group": {
     *                 "id": 1,
     *                 "title": "Ages 3-5"
     *             },
     *             "level": {
     *                 "id": 2,
     *                 "title": "Beginner"
     *             },
     *             "title": "Another Activity",
     *             "description": "Description of another activity.",
     *             "media_path_1": null,
     *             "media_path_2": null,
     *             "media_path_3": null,
     *             "media_path_4": null,
     *             "has_multimedia_resources": false,
     *             "has_visual_instructions": true,
     *             "created_at": "2023-09-02T11:30:45Z",
     *             "updated_at": "2023-09-02T11:30:45Z"
     *             "note": 3.5
     *         }
     *         // ... other activities that match the filtering criteria
     *     ]
     * }
     */
    public function filter(Request $request)
    {
        // Inicializar a consulta com todas as atividades
        $query = Activity::query()->with('ageGroup', 'area', 'level', 'createdByUser', 'comments');

        // Filtros com base nos parâmetros da solicitação
        if ($request->has('text')) {
            $text = $request->input('text');
            $query->where(function ($q) use ($text) {
                $q->where('title', 'like', "%$text%")
                ->orWhere('description', 'like', "%$text%");
            });
        }

        if ($request->has('age_group_id')) {
            $query->where('age_group_id', $request->input('age_group_id'));
        }

        if ($request->has('area_id')) {
            $query->where('area_id', $request->input('area'));
        }

        if ($request->has('level_id')) {
            $query->where('level_id', $request->input('level'));
        }

        if ($request->has('created_by')) {
            $query->where('created_by', $request->input('createdByUser'));
        }

        if ($request->has('has_multimedia_resources')) {
            $query->where('has_multimedia_resources', $request->input('has_multimedia_resources'));
        }

        if ($request->has('has_visual_instructions')) {
            $query->where('has_visual_instructions', $request->input('has_visual_instructions'));
        }

        // Executar a consulta e retornar os resultados
        $filteredActivities = $query->get();

        // Calculate the average rating (note) for each activity
        foreach ($filteredActivities as $activity) {
            $activity->note = $activity->comments->avg('note');
        }

        return response()->json(['data' => $filteredActivities]);
    }

    /**
     * Retrieve a specific activity with related information and similar activities.
     *
     * @group Activities
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * Retrieves a specific activity by its ID along with all related information, including age group, area, level,
     * the user who created it, comments, questions, and calculates the average rating based on comments received.
     *
     * @urlParam id int required The ID of the activity.
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "created_by": {
     *             "id": 1,
     *             "name": "John Doe",
     *             "email": "john@example.com",
     *             "created_at": "2023-09-01T12:34:56Z",
     *             "updated_at": "2023-09-01T12:34:56Z"
     *         },
     *         "area": {
     *             "id": 1,
     *             "title": "Science"
     *         },
     *         "age_group": {
     *             "id": 2,
     *             "title": "Ages 5-8"
     *         },
     *         "level": {
     *             "id": 3,
     *             "title": "Intermediate"
     *         },
     *         "title": "Fun Science Experiment",
     *         "description": "A simple and fun science experiment for kids.",
     *         "media_path_1": "https://example.com/media/experiment.jpg",
     *         "media_path_2": null,
     *         "media_path_3": null,
     *         "media_path_4": null,
     *         "created_at": "2023-09-02T10:15:30Z",
     *         "updated_at": "2023-09-02T10:15:30Z",
     *         "note": 4.2, // The calculated average rating based on comments
     *         "comments": [
     *             {
     *                 "id": 1,
     *                 "user_id": 2,
     *                 "activity_id": 1,
     *                 "note": 4.5,
     *                 "created_at": "2023-09-03T14:30:00Z",
     *                 "updated_at": "2023-09-03T14:30:00Z"
     *             },
     *             // ... (other comment objects)
     *         ],
     *         "questions": [
     *             {
     *                 "id": 1,
     *                 "activity_id": 1,
     *                 "question": "Can I use household items for this experiment?",
     *                 "created_at": "2023-09-03T14:30:00Z",
     *                 "updated_at": "2023-09-03T14:30:00Z"
     *             },
     *             // ... (other question objects)
     *         ]
     *     },
     *     "similar_activities": [
     *         {
     *             "id": 2,
     *             "created_by": {
     *                 "id": 2,
     *                 "name": "Alice Smith",
     *                 "email": "alice@example.com",
     *                 "created_at": "2023-09-01T13:45:00Z",
     *                 "updated_at": "2023-09-01T13:45:00Z"
     *             },
     *             "area": {
     *                 "id": 2,
     *                 "title": "Art"
     *             },
     *             "age_group": {
     *                 "id": 1,
     *                 "title": "Ages 3-5"
     *             },
     *             "level": {
     *                 "id": 2,
     *                 "title": "Beginner"
     *             },
     *             "title": "Creative Painting",
     *             "description": "Learn creative painting techniques for beginners.",
     *             "media_path_1": "https://example.com/media/painting.jpg",
     *             "media_path_2": null,
     *             "media_path_3": null,
     *             "media_path_4": null,
     *             "created_at": "2023-09-02T11:30:45Z",
     *             "updated_at": "2023-09-02T11:30:45Z",
     *             "note": 3.8 // The calculated average rating based on comments
     *         },
     *         // ... (other similar activity objects)
     *     ]
     * }
     * }
     */

    public function show(int $id)
    {
        // Recuperar a atividade pelo ID com as relações carregadas
        $activity = Activity::with('ageGroup', 'area', 'level', 'createdByUser', 'comments', 'questions')->find($id);

        if (!$activity) {
            return response()->json(['message' => 'Atividade não encontrada'], 404);
        }

        // Calculate the average rating for the activity
        $activity->note = $activity->comments->avg('note');

        // Recuperar atividades semelhantes
        $similarActivities = $this->getSimilarActivities($activity);

        return response()->json([
            'data' => $activity,
            'similar_activities' => $similarActivities,
        ]);
    }

    /**
     * Obtém uma lista de atividades semelhantes com base nas relações.
     */
    private function getSimilarActivities(Activity $activity, int $limit = 5): array
    {
        $similarActivities = Activity::where('id', '!=', $activity->id)
        ->Where('area_id', $activity->area_id)
        ->orWhere('level_id', $activity->level_id)
        ->orWhere('age_group_id', $activity->age_group_id)
        ->limit($limit)
        ->get()
        ->toArray();

        return $similarActivities;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivitiesRequest $request, Activities $activities)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activities $activities)
    {
        //
    }
}
