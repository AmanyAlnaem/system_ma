<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('invoice_items')
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->select('invoices.type', 'invoices.date', 'invoice_items.quantity', 'items.name as item_name');

        // 1. فلترة حسب المادة
        if ($request->filled('item_id')) {
            $query->where('items.id', $request->item_id);
        }

        // 2. فلترة حسب الفترة الزمنية
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('invoices.date', now()->today());
                    break;
                case 'week':
                    $query->whereBetween('invoices.date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('invoices.date', now()->month);
                    break;
                case 'quarter':
                    $query->whereBetween('invoices.date', [now()->startOfQuarter(), now()->endOfQuarter()]);
                    break;
                case 'half':
                    $query->whereBetween('invoices.date', [now()->startOfYear(), now()->addMonths(6)->endOfMonth()]);
                    break;
                case 'year':
                    $query->whereYear('invoices.date', now()->year);
                    break;
            }
        }

        // 3. فلترة من فترة إلى فترة (Custom Range)
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('invoices.date', [$request->from_date, $request->to_date]);
        }

        $stats = $query->get();
        $items = DB::table('items')->select('id', 'name')->get(); // لجلب قائمة المواد للفلتر

        return view('inventory.index', compact('stats', 'items'));
    }
}
