<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:5|max:50',
        ]);

        $list = $request->user()->shoppingList()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $item = $list->items()->create($data);

        return (new ItemResource($item))->response()->setStatusCode(201);
    }

    public function update(Request $request, Item $item)
    {
        if ($item->shoppingList->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden',
            ], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|min:5|max:50',
        ]);

        $item->update($data);

        return new ItemResource($item);
    }

    public function destroy(Request $request, Item $item)
    {
        if ($item->shoppingList->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden',
            ], 403);
        }

        $item->delete();

        return response()->json(null, 204);
    }
}