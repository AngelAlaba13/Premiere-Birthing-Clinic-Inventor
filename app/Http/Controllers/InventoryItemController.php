<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = InventoryItem::with(['category', 'expiries'])
            ->latest()
            ->get();

        return view('inventory.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('inventory.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:255'],
            'in_display' => ['required', 'integer', 'min:0'],
            'in_stock' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:100'],
            'category_id' => ['required', 'exists:categories,id'],

            'batches' => ['required', 'array', 'min:1'],
            'batches.*.batch_number' => ['required', 'string', 'max:100'],
            'batches.*.expiry_date' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($validated) {
            $item = InventoryItem::create([
                'item_name' => $validated['item_name'],
                'in_display' => $validated['in_display'],
                'in_stock' => $validated['in_stock'],
                'unit' => $validated['unit'],
                'category_id' => $validated['category_id'],
            ]);

            foreach ($validated['batches'] as $batch) {
                $item->expiries()->create([
                    'batch_number' => $batch['batch_number'],
                    'expiry_date' => $batch['expiry_date'],
                ]);
            }
        });

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory item added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventory)
    {
        $inventory->load(['category', 'expiries']);

        return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventory)
    {
        $inventory->load('expiries');

        $categories = Category::orderBy('name')->get();

        return view('inventory.edit', compact('inventory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryItem $inventory)
    {
        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:255'],
            'in_display' => ['required', 'integer', 'min:0'],
            'in_stock' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:100'],
            'category_id' => ['required', 'exists:categories,id'],

            'batches' => ['required', 'array', 'min:1'],
            'batches.*.id' => ['nullable', 'integer', 'exists:inventory_expiries,id'],
            'batches.*.batch_number' => ['required', 'string', 'max:100'],
            'batches.*.expiry_date' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($validated, $inventory) {
            $inventory->update([
                'item_name' => $validated['item_name'],
                'in_display' => $validated['in_display'],
                'in_stock' => $validated['in_stock'],
                'unit' => $validated['unit'],
                'category_id' => $validated['category_id'],
            ]);

            $existingIds = [];

            foreach ($validated['batches'] as $batch) {
                if (!empty($batch['id'])) {
                    $expiry = $inventory->expiries()
                        ->where('id', $batch['id'])
                        ->firstOrFail();

                    $expiry->update([
                        'batch_number' => $batch['batch_number'],
                        'expiry_date' => $batch['expiry_date'],
                    ]);

                    $existingIds[] = $expiry->id;
                } else {
                    $expiry = $inventory->expiries()->create([
                        'batch_number' => $batch['batch_number'],
                        'expiry_date' => $batch['expiry_date'],
                    ]);

                    $existingIds[] = $expiry->id;
                }
            }

            $inventory->expiries()
                ->whereNotIn('id', $existingIds)
                ->delete();
        });

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventory)
    {
        $inventory->delete();

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory item deleted successfully.');
    }
}
