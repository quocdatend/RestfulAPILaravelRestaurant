<?php

namespace App\Services;

use App\Models\Invoice;
/**
 * Class InvoiceService.
 */
class InvoiceService
{
    // createInvoice
    public function createInvoice(array $data)
    {
        return Invoice::create($data);
    }
}
