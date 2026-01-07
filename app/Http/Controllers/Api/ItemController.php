<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $items = Item::query()
            ->when($request->status, fn($q) => $q->where('status', $request->status)
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Items retrieved successfully',
            'data' => $items,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request): JsonResponse
    {
        $items = Item::create($request->validated());
        return response()->json([

            'message' => 'Items created successfully',
            'data' => $items,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item): JsonResponse
    {
        return response()->json([
            'message' => 'Item retrieved successfully',
            'data' => $item,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, Item $item): JsonResponse
    {
        $item->update($request->validated());

        return response()->json([
            'message' => 'Item updated successfully',
            'data' => $item,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item): JsonResponse
    {
        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully',
        ], 200);
    }
}
