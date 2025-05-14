<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderNoteRequest;
use App\Services\OrderNoteService;

class OrderNoteController extends Controller
{
    protected $orderNoteService;

    public function __construct(OrderNoteService $orderNoteService)
    {
        $this->orderNoteService = $orderNoteService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderNotes = $this->orderNoteService->getAll();
        return response()->json([
            'status' => 'success',
            'OrderNotes' => $orderNotes,
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderNoteRequest $request)
    {
        $validatedData = $request->validated();

        $orderNote = $this->orderNoteService->create([
            'order_note_id' => uniqid(),
            'note' => $validatedData['note'],
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $orderNote,
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $orderNote = $this->orderNoteService->findById($id);

        if (!$orderNote) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order note not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $orderNote,
        ]);
    }

    // get by order id
    public function getByOrderNoteId($orderNoteId)
    {
        $orderNotes = $this->orderNoteService->getByOrderNoteId($orderNoteId);

        if ($orderNotes->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No order notes found for this order',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $orderNotes,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(OrderNoteRequest $request, $id)
    {
        $validatedData = $request->validated();

        $orderNote = $this->orderNoteService->findById($id);

        if (!$orderNote) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order note not found',
            ], 404);
        }

        $orderNote->update([
            'note' => $validatedData['note'],
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $orderNote,
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $orderNote = $this->orderNoteService->findById($id);

        if (!$orderNote) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order note not found',
            ], 404);
        }

        $this->orderNoteService->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Order note deleted successfully',
        ]);
    }
}
