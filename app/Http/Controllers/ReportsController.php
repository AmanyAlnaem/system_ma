<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;      
use App\Models\Invoice;    
use App\Models\InvoiceItem;

class ReportsController extends Controller
{
    public function itemLedger($id)
    {
        $item = Item::with(['invoiceItems.invoice'])->findOrFail($id);
        // جلب الحركات مرتبة حسب التاريخ لتعرض "حركة يومية"   
        $ledger = $item->invoiceItems->sortByDesc(fn($ii) => $ii->invoice->date);

        return view('reports.item_ledger', compact('item', 'ledger'));
    }
}
