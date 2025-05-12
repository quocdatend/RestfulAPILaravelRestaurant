<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartyRequest;
use App\Services\PartyService;

class PartyController extends Controller
{
    protected $partyService;
    public function __construct(PartyService $partyService)
    {
        $this->partyService = $partyService;
    }

    public function index()
    {
        $parties = $this->partyService->getAllParties();
        if ($parties->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No parties found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'parties' => $parties->map(function ($party) {
                return [
                    'id' => (string) $party->id,
                    'name' => $party->name
                ];
            })
        ]);
    }

    public function create(PartyRequest $request)
    {
        $validatedData = $request->validated();
        $party = $this->partyService->createParty([
            'id' => uniqid(),
            'name' => $validatedData['name'],
        ]);
        return response()->json([
            'status' => 'success',
            'party' => $party
        ]);
    }

    public function update(PartyRequest $request, $id)
    {
        $validatedData = $request->validated();

        $party = $this->partyService->getPartyById($id);
        if (!$party) {
            return response()->json([
                'status' => 'error',
                'message' => 'Party not found'
            ], 404);
        }
        $party = $this->partyService->updateParty($party, [
            'name' => $validatedData['name'],
        ]);
        return response()->json([
            'status' => 'success',
            'party' => $party
        ]);
    }

    public function getPartyById($id)
    {
        $party = $this->partyService->getPartyById($id);
        if (!$party) {
            return response()->json([
                'status' => 'error',
                'message' => 'Party not found q23e'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'party' => $party
        ]);
    }

    public function destroy($id)
    {
        $party = $this->partyService->getPartyById($id);
        if (!$party) {
            return response()->json([
                'status' => 'error',
                'message' => 'Party not found'
            ], 404);
        }
        $this->partyService->deleteParty($party);
        return response()->json([
            'status' => 'success',
            'message' => 'Party deleted successfully'
        ]);
    }
}
