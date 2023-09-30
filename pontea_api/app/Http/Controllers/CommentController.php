<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @group Comments
     *
     * This function creates a new comment associated with a specific activity.
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * @bodyParam activity_id integer required The ID of the associated activity. Example: 1
     * @bodyParam text string required The text of the comment. Example: This activity is great!
     * @bodyParam note integer required The note for the activity, must be between 1 and 5. Example: 4
     *
     * @response 201 {
     *     "message": "Comment created successfully"
     * }
     *
     * @response 422 {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "activity_id": ["The activity_id field is required."],
     *         "text": ["The text field is required."],
     *         "note": ["The note field is required.", "The note field must be between 1 and 5."]
     *     }
     * }
     */
    public function store(StoreCommentRequest $request)
    {
        $user = session('user');
        $campos = $request->all();
        Validator::make($campos, [
            'activity_id' => ['required', 'integer'],
            'text' => ['required', 'string'],
            'note' => ['required', 'integer', 'between:1,5']
        ])->validate();

        Comment::create([
            'activity_id' => $campos['activity_id'],
            'text' => $campos['text'],
            'note' => $campos['note'],
            'created_by' => $user->id,
        ]);

        return response()->json(['message' => 'Comentário Criado com Sucesso!']);
    }
}
