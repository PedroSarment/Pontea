<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;

class TeacherController  extends Controller
{
     /**
     * Retrieve all teachers with their average rating.
     *
     * @group Teachers
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * Retrieves a list of all teachers who are users with 'is_teacher' set to true,
     * along with their average rating based on comments received on activities they created.
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 1,
     *             "name": "John Doe",
     *             "email": "john@example.com",
     *             "created_at": "2023-09-01T12:34:56Z",
     *             "updated_at": "2023-09-01T12:34:56Z",
     *             "note": 4.5,
     *             "countActivities": 2
     *         },
     *         {
     *             "id": 2,
     *             "name": "Alice Smith",
     *             "email": "alice@example.com",
     *             "created_at": "2023-09-01T13:45:00Z",
     *             "updated_at": "2023-09-01T13:45:00Z",
     *             "note": 3.8,
     *             "countActivities": 2
     *         }
     *         // ... (other teacher objects)
     *     ]
     * }
     */
    public function index()
    {
        $teachers = User::where('is_teacher', true)->get();

        // Calculate the average rating for each teacher based on comments received on activities they created
        foreach ($teachers as $teacher) {
            $averageRating = DB::table('comments')
                ->join('activities', 'comments.activity_id', '=', 'activities.id')
                ->where('activities.created_by', $teacher->id)
                ->avg('comments.note');

            // Set the note attribute for each teacher
            $teacher->note = $averageRating ? $averageRating : 0;
            $teacher->countActivities = Activity::where('created_by', $teacher->id)->get()->count();
        }

        return response()->json(['data' => $teachers]);
    }

    /**
     * Retrieve a specific teacher and their created activities.
     *
     * @group Teachers
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * Retrieves a specific teacher by their ID along with all the information about the teacher,
     * including their created activities.
     *
     * @urlParam id int required The ID of the teacher.
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "created_at": "2023-09-01T12:34:56Z",
     *         "updated_at": "2023-09-01T12:34:56Z",
     *         "note": 4.5,
     *         "created_activities": [
     *             {
     *                 "id": 1,
     *                 "title": "Sample Activity 1",
     *                 "description": "Description of Sample Activity 1.",
     *                 "media_path_1": "media/activity1.jpg",
     *                 "media_path_2": null,
     *                 "media_path_3": null,
     *                 "media_path_4": null,
     *                 "has_multimedia_resources": true,
     *                 "has_visual_instructions": false,
     *                 "created_at": "2023-09-01T12:00:00Z",
     *                 "updated_at": "2023-09-01T12:30:00Z",
     *                 "note": 4.2
     *             },
     *             {
     *                 "id": 2,
     *                 "title": "Sample Activity 2",
     *                 "description": "Description of Sample Activity 2.",
     *                 "media_path_1": "media/activity2.jpg",
     *                 "media_path_2": null,
     *                 "media_path_3": null,
     *                 "media_path_4": null,
     *                 "has_multimedia_resources": true,
     *                 "has_visual_instructions": false,
     *                 "created_at": "2023-09-02T10:00:00Z",
     *                 "updated_at": "2023-09-02T10:30:00Z",
     *                 "note": 4.7
     *             }
     *             // ... (other activity objects created by the teacher)
     *         ]
     *     }
     * }
     */

    public function show(int $id)
    {
        // Retrieve the specific teacher by ID
        $teacher = User::find($id);

        if (!$teacher || !$teacher->is_teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        // Calculate the average rating for the teacher based on comments received on activities they created
        $averageRating = $this->calculateAverageRatingForTeacher($teacher);

        // Get all activities created by the teacher
        $createdActivities = $teacher->createdActivities;

        // Add the average rating to the teacher object
        $teacher->note = $averageRating;

        // Prepare the response data
        $responseData = [
            'id' => $teacher->id,
            'name' => $teacher->name,
            'email' => $teacher->email,
            'created_at' => $teacher->created_at,
            'updated_at' => $teacher->updated_at,
            'note' => $teacher->note,
            'created_activities' => $createdActivities,
        ];

        return response()->json(['data' => $responseData]);
    }

    /**
     * Turn a user into a teacher.
     *
     * @group Teachers
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * This function allows you to update a user's status to become a teacher.
     *
     * @response 200 {
     *     "user": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "is_teacher": true,
     *         "created_at": "2023-09-01T12:34:56Z",
     *         "updated_at": "2023-09-01T12:36:24Z"
     *     },
     *     "message": "User is now a teacher"
     * }
     *
     * @authenticated
     */
    public function turnUserIntoTeacher()
    {
        $user = session('user');

        $user->is_teacher = true;

        $user->save();

        return response()->json(['user' => $user, 'message' => 'User is now a teacher'], 200);
    }

    /**
     * Calculate the average rating for a teacher based on comments received on activities they created.
     *
     * @param \App\Models\User $teacher
     * @return float|null
     */
    private function calculateAverageRatingForTeacher(User $teacher)
    {
        $averageRating = $teacher->createdActivities()->leftJoin('comments', 'activities.id', '=', 'comments.activity_id')
            ->avg('comments.note');

        return round($averageRating, 2); // Round to 2 decimal places
    }

}
