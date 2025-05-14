<?php

namespace App\Services;

use App\Models\OrderNote;
/**
 * Class OrderNoteService.
 */
class OrderNoteService
{
    /**
     * @var OrderNote
     */
    protected $orderNote;

    /**
     * OrderNoteService constructor.
     *
     * @param OrderNote $orderNote
     */
    public function __construct(OrderNote $orderNote)
    {
        $this->orderNote = $orderNote;
    }

    /**
     * Create a new order note.
     *
     * @param array $data
     * @return OrderNote
     */
    public function create(array $data): OrderNote
    {
        return $this->orderNote->create($data);
    }

    /**
     * Get all order notes.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->orderNote->all();
    }
    /**
     * Find an order note by ID.
     *
     * @param string $id
     * @return OrderNote|null
     */
    public function findById(string $id): ?OrderNote
    {
        return $this->orderNote->find($id);
    }
    /**
     * Get order notes by order ID.
     *
     * @param string $orderId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByOrderNoteId(string $orderNoteId)
    {
        return $this->orderNote->where('order_note_id', $orderNoteId)->get();
    }
    /**
     * Update an order note.
     *
     * @param string $id
     * @param array $data
     * @return bool
     */
    public function update(string $id, array $data): bool
    {
        $orderNote = $this->findById($id);
        if ($orderNote) {
            return $orderNote->update($data);
        }
        return false;
    }
    /**
     * Delete an order note.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $orderNote = $this->findById($id);
        if ($orderNote) {
            return $orderNote->delete();
        }
        return false;
    }
}
