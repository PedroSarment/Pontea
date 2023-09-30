<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Support\Facades\Validator;


class QuestionController extends Controller
{
    /**
     * Store a newly created question.
     *
     * @group Questions
     *
     * This function creates a new question associated with a specific activity.
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * @bodyParam question string required The text of the question. Example: How does this experiment work?
     * @bodyParam activity_id integer required The ID of the associated activity. Example: 1
     *
     * @response 201 {
     *     "message": "Question created successfully"
     * }
     *
     * @response 422 {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "question": ["The question field is required."],
     *         "activity_id": ["The activity_id field is required."],
     *     }
     * }
     */
    public function store(StoreQuestionRequest $request)
    {
        $user = session('user');

        $campos = $request->all();

        Validator::make($campos, [
            'question' => ['required', 'string'],
            'activity_id' => ['required', 'integer'],
        ])->validate();

        Question::create([
            'question' => $campos['question'],
            'activity_id' => $campos['activity_id'],
            'response' => 'sem resposta',
            'likes' => 0,
            'created_by' => $user->id,
        ]);

        return response()->json(['message' => 'Pergunta Criada com Sucesso']);
    }

    /**
     * Respond to a question.
     *
     * @group Questions
     *
     * This function allows you to respond to a specific question.
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * @bodyParam question_id integer required The ID of the question to respond to. Example: 1
     * @bodyParam response string required The response to the question. Example: Here's how the experiment works...
     *
     * @response 200 {
     *     "message": "Question responded successfully"
     * }
     *
     * @response 404 {
     *     "message": "Question not found"
     * }
     *
     * @response 422 {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "question_id": ["The question_id field is required."],
     *         "response": ["The response field is required."],
     *     }
     * }
     */
    public function responds(StoreQuestionRequest $request)
    {
        $user = session('user');

        $campos = $request->all();

        Validator::make($campos, [
            'question_id' => ['required', 'integer'],
            'response' => ['required', 'string'],
        ])->validate();

        $question = Question::find($campos['question_id']);

        if(!$question){

            return response()->json(['message' => 'Não existe Pergunta com esse ID']);
        } else {

            $question->update([
                'response' => $campos['response'],
            ]);

            return response()->json(['message' => 'Pergunta Respondida com Sucesso']);
        }
    }

     /**
     * Like a question.
     *
     * @group Questions
     *
     * This function allows you to like a specific question.
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * @bodyParam question_id integer required The ID of the question to like. Example: 1
     *
     * @response 200 {
     *     "message": "Question liked successfully"
     * }
     *
     * @response 404 {
     *     "message": "Question not found"
     * }
     *
     * @response 422 {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "question_id": ["The question_id field is required."],
     *     }
     * }
     */
    public function like(StoreQuestionRequest $request)
    {
        $user = session('user');

        $campos = $request->all();

        Validator::make($campos, [
            'question_id' => ['required', 'integer'],
        ])->validate();

        $question = Question::find($campos['question_id']);

        if(!$question){

            return response()->json(['message' => 'Não existe Pergunta com esse ID']);
        } else {

            $question->update([
                'likes' => $question->likes + 1,
            ]);

            return response()->json(['message' => 'Pergunta Curtida com Sucesso']);
        }
    }

}
