<?php

namespace App\Http\Controllers;

use App\Models\purchase;
use App\Http\Requests\StorepurchaseRequest;
use App\Http\Requests\UpdatepurchaseRequest;
use Illuminate\Http\Request;
use App\Models\Activity;

class PurchaseController extends Controller
{
     /**
     * Purchase an activity.
     *
     * @group Purchase
     *
     * This endpoint allows a user to purchase an activity, either by making a direct payment or using their available credit balance.
     *
     * @authenticated
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * @bodyParam activity_id int required The ID of the activity to be purchased.
     * @bodyParam pontea_credit_payment bool Indicates whether the purchase should be made using available credit (true) or direct payment (false). Default is false.
     *
     * @response 200 {
     *     "message": "Purchase completed successfully."
     * }
     *
     * @response 400 {
     *     "message": "You have already purchased this activity"
     * }
     *
     * @response 400 {
     *     "message": "Insufficient credit to purchase this activity"
     * }
     *
     * @response 404 {
     *     "message": "Activity not found"
     * }
     */
    public function purchase(StorepurchaseRequest $request)
    {
        $user = session('user'); // Suponho que você já tenha o usuário logado na sessão.

        $activityId = $request->input('activity_id');

        // Obter a atividade com base no ID fornecido.
        $activity = Activity::findOrFail($activityId);

        // Verificar se a atividade já foi comprada pelo usuário.
        $hasPurchased = Purchase::where('bought_by', $user->id)
            ->where('activity_id', $activityId)
            ->exists();

        if ($hasPurchased) {
            return response()->json(['message' => 'You have already purchased this activity'], 400);
        }

        $isPaymentByCredit = $request->input('pontea_credit_payment', false);

        if ($isPaymentByCredit) {

            // Verificar se o usuário tem saldo suficiente para comprar a atividade.
            if ($user->credit < $activity->price) {

                return response()->json(['message' => 'Insufficient credit to purchase this activity'], 400);
            }

            // Deduzir o preço da atividade do saldo do usuário.
            $user->decrement('credit', $activity->price);

            // Adicionar o preço da atividade como saldo para o usuário que criou a atividade.
            $activityOwner = $activity->createdByUser;
            $activityOwner->increment('credit', $activity->price);
        }

        // Registrar a compra na tabela de compras.
        Purchase::create([
            'bought_by' => $user->id,
            'activity_id' => $activityId,
            'bought_at' => now(),
        ]);

        return response()->json(['message' => 'Compra concluída com sucesso.']);
    }
}
