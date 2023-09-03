<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use App\Http\Requests\StoreShoppingCartRequest;
use App\Http\Requests\UpdateShoppingCartRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Display a listing of the resource.
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     * @group Shopping Cart
     *
     * Retrieve a list of all items in the shopping cart for the authenticated user.
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 1,
     *             "user_id": 1,
     *             "activity_id": 5,
     *             "created_at": "2023-09-01 12:00:00",
     *             "updated_at": "2023-09-01 12:00:00",
     *             "activity": {
     *                 "id": 5,
     *                 "title": "Sample Activity",
     *                 "price": 10.0
     *             }
     *         },
     *         // ... (other shopping cart items)
     *     ],
     *     "total": 50.0
     * }
     */
    public function index(Request $request)
    {
        // Recupere o ID do usuário do POST
        $user = session('user');

        // Encontre todas as atividades no carrinho de compras do usuário
        $shoppingCarts = ShoppingCart::where('user_id', $user->id)->with('activity')->get();

        // Calcule o total somando os preços das atividades no carrinho
        $total = $shoppingCarts->sum(function ($item) {
            return $item->activity->price;
        });

        return response()->json(['data' => $shoppingCarts, 'total' => $total]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @group Shopping Cart

     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * Add an activity to the shopping cart for the authenticated user.
     *
     * @bodyParam activity_id int required The ID of the activity to add to the shopping cart.
     *
     * @response 200 {
     *     "message": "Item added to the shopping cart"
     * }
     *
     * @response 409 {
     *     "message": "Item already exists in the shopping cart"
     * }
     */
    public function store(StoreShoppingCartRequest $request)
    {
        Validator::make($request->all(), [
            'activity_id' => ['required'],
        ])->validate();

        // Obtenha o ID da atividade e do usuário do POST
        $activityId = $request->input('activity_id');
        $user = session('user');

        // Verifique se o item já está no carrinho do usuário
        $existingCartItem = ShoppingCart::where('user_id', $user->id)->where('activity_id', $activityId)->first();

        if ($existingCartItem) {
            return response()->json(['message' => 'Item already exists in the shopping cart']);
        }

        // Crie um novo registro no carrinho de compras
        ShoppingCart::create([
            'user_id' => $user->id,
            'activity_id' => $activityId,
        ]);

        return response()->json(['message' => 'Item added to the shopping cart']);
    }

    /**
     * Remove all shopping cart items with a specific activity for a user.
     *
     * @group Shopping Cart
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * Remove all items with a specific activity from the shopping cart for the authenticated user.
     *
     * @bodyParam activity_id int required The ID of the activity to remove from the shopping cart.
     *
     * @response 200 {
     *     "message": "All items with the specified activity removed from the shopping cart"
     * }
     */
    public function remove(Request $request)
    {
        Validator::make($request->all(), [
            'activity_id' => ['required'],
        ])->validate();
        // Obtenha o ID da atividade e do usuário do POST
        $user = session('user');
        $activityId = $request->input('activity_id');

        // Deleta todos os registros no carrinho de compras com a atividade específica e ID do usuário
        ShoppingCart::where('user_id', $user->id)->where('activity_id', $activityId)->delete();

        return response()->json(['message' => 'All items with the specified activity removed from the shopping cart']);
    }

    /**
     * Remove all shopping cart items for a user.
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * @group Shopping Cart
     *
     * Remove all items from the shopping cart for the authenticated user.
     *
     * @response 200 {
     *     "message": "All items removed from the shopping cart"
     * }
     */
    public function destroy(Request $request)
    {
        // Recupere o ID do usuário do POST
        $user = session('user');

        // Deleta todos os registros no carrinho de compras do usuário
        ShoppingCart::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'All items removed from the shopping cart']);
    }
}
