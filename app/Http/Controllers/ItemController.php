<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:items',
            // قاعدة unique تخبر لارافيل بفحص جدول items وعمود sku للتأكد من عدم تكراره
            'sku'  => 'required|string|unique:items,sku',
        ], [
            // رسائل مخصصة باللغة العربية
            'name.unique' => 'عذراً، هذا المنتج موجود مسبقاً في قاعدة البيانات.',
            'sku.unique' => 'عذراً، هذا الكود موجود مسبقاً في قاعدة البيانات.',
            'name.required' => 'يجب إدخال اسم المادة.',
            'sku.required' => 'يجب إدخال كود المادة.',
        ]);

        auth()->user()->items()->create($request->only(['name', 'sku']));

        return redirect()->route('dashboard')->with('success', 'تم إضافة المادة بنجاح');
    }
    public function index()
    {
        // جلب المواد مع علاقة المستخدم لضمان ظهور "أضيفت بواسطة"
        $items = Item::with('user')->get();
        return view('items.index', compact('items'));
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('items.edit', compact('item'));
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('items.index')->with('success', 'تم حذف المادة بنجاح');
    }
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->update([
            'name' => $request->name,
            'sku' => $request->sku,
        ]);

        return redirect()->route('items.index')->with('success', 'تم تحديث بيانات المادة بنجاح');
    }
    public function show($id)
    {
        $item = Item::with('invoices')->findOrFail($id);
        return view('items.show', compact('item'));
    }
}