<?php

namespace App\Services;
use App\Models\Party;

/**
 * Class PartyService.
 */
class PartyService
{
    /**
     * Get all parties.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllParties()
    {
        return Party::all();
    }
    /**
     * Get a party by ID.
     *
     * @param string $id
     * @return \App\Models\Party|null
     */
    public function getPartyById($id)
    {
        return Party::find($id);
    }

    /**
     * Create a new party.
     *
     * @param array $data
     * @return \App\Models\Party
     */
    public function createParty(array $data)
    {
        return Party::create($data);
    }

    /**
     * Update an existing party.
     *
     * @param \App\Models\Party $party
     * @param array $data
     * @return \App\Models\Party
     */
    public function updateParty(Party $party, array $data)
    {
        $party->update($data);
        return $party;
    }

    /**
     * Delete a party.
     *
     * @param \App\Models\Party $party
     * @return bool
     */
    public function deleteParty(Party $party)
    {
        return $party->delete();
    }
}
