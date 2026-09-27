<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite([
        'resources/css/app.css',
        'resources/js/darkMode.js',
        'resources/js/createInventory.js'
    ])

    <title>Add Inventory Item</title>
</head>

<body class="min-h-screen bg-[#f5f8fb] text-slate-800 transition-colors duration-200 dark:bg-slate-950 dark:text-slate-100">

    <div class="mx-auto max-w-5xl px-6 py-10">

        <div class="mb-8 flex items-start justify-between">

            <div>

                <a
                    href="{{ route('inventory.index') }}"
                    class="text-sm font-medium text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                >
                    ← Back to Inventory
                </a>

                <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">
                    Add Inventory Item
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Add a medicine or supply to your inventory.
                </p>

            </div>

        </div>

        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-900/50 dark:bg-red-950/30">

                <ul class="space-y-1 text-sm text-red-600 dark:text-red-400">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('inventory.store') }}"
            method="POST"
            class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900"
        >

            @csrf

            <div class="p-6">

                <div class="mb-8">

                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                        Item Information
                    </h2>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Enter the basic information for this inventory item.
                    </p>

                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div class="md:col-span-2">

                        <label
                            for="item_name"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Item Name
                        </label>

                        <input
                            type="text"
                            id="item_name"
                            name="item_name"
                            value="{{ old('item_name') }}"
                            placeholder="e.g. Paracetamol 500mg"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-blue-400 dark:focus:ring-blue-950"
                        >

                    </div>

                    <div>

                        <label
                            for="in_display"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            In Display
                        </label>

                        <input
                            type="number"
                            id="in_display"
                            name="in_display"
                            value="{{ old('in_display', 0) }}"
                            min="0"
                            required
                            class="quantity-input w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-950"
                        >

                    </div>

                    <div>

                        <label
                            for="in_stock"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            In Stock
                        </label>

                        <input
                            type="number"
                            id="in_stock"
                            name="in_stock"
                            value="{{ old('in_stock', 0) }}"
                            min="0"
                            required
                            class="quantity-input w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-950"
                        >

                    </div>

                    <div>

                        <label
                            for="total_quantity"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Total Quantity
                        </label>

                        <input
                            type="number"
                            id="total_quantity"
                            value="{{ old('in_display', 0) + old('in_stock', 0) }}"
                            readonly
                            class="w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-100 px-4 py-3 font-semibold text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300"
                        >

                    </div>

                    <div>

                        <label
                            for="unit"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Unit
                        </label>

                        <select
                            id="unit"
                            name="unit"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-950"
                        >

                            <option value="">Select Unit</option>

                            @foreach ([
                                'Tablet',
                                'Capsule',
                                'Vial',
                                'Ampoule',
                                'Bottle',
                                'Tube',
                                'Sachet',
                                'Pack',
                                'Piece',
                                'Box',
                                'pcs/box',
                                'Other'
                            ] as $unit)

                                <option
                                    value="{{ $unit }}"
                                    @selected(old('unit') === $unit)
                                >
                                    {{ $unit }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="md:col-span-2">

                        <label
                            for="category_id"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Category
                        </label>

                        <select
                            id="category_id"
                            name="category_id"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-950"
                        >

                            <option value="">Select Category</option>

                            @foreach ($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id') == $category->id)
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="mt-10 border-t border-slate-200 pt-8 dark:border-slate-800">

                    <div class="mb-5 flex items-center justify-between">

                        <div>

                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                                Expiry Batches
                            </h2>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Add every batch number and its corresponding expiry date.
                            </p>

                        </div>

                        <button
                            type="button"
                            id="add-batch"
                            class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700"
                        >
                            + Add Batch
                        </button>

                    </div>

                    <div
                        id="batch-container"
                        data-initial-count="{{ old('batches') ? count(old('batches')) : 1 }}"
                        class="space-y-4"
                    >

                        @if (old('batches'))

                            @foreach (old('batches') as $index => $batch)

                                <div class="batch-row grid grid-cols-1 items-end gap-4 rounded-lg border border-slate-200 bg-slate-50 p-4 md:grid-cols-[1fr_1fr_auto] dark:border-slate-800 dark:bg-slate-950">

                                    <div>

                                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                            Batch Number
                                        </label>

                                        <input
                                            type="text"
                                            name="batches[{{ $index }}][batch_number]"
                                            value="{{ $batch['batch_number'] ?? '' }}"
                                            placeholder="e.g. BATCH-001"
                                            required
                                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-950"
                                        >

                                    </div>

                                    <div>

                                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                            Expiry Date
                                        </label>

                                        <input
                                            type="date"
                                            name="batches[{{ $index }}][expiry_date]"
                                            value="{{ $batch['expiry_date'] ?? '' }}"
                                            required
                                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-950"
                                        >

                                    </div>

                                    <button
                                        type="button"
                                        class="remove-batch h-[50px] rounded-lg bg-red-50 px-4 text-sm font-medium text-red-600 transition hover:bg-red-100 dark:bg-red-950/30 dark:text-red-400 dark:hover:bg-red-950/50"
                                    >
                                        Remove
                                    </button>

                                </div>

                            @endforeach

                        @else

                            <div class="batch-row grid grid-cols-1 items-end gap-4 rounded-lg border border-slate-200 bg-slate-50 p-4 md:grid-cols-[1fr_1fr_auto] dark:border-slate-800 dark:bg-slate-950">

                                <div>

                                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Batch Number
                                    </label>

                                    <input
                                        type="text"
                                        name="batches[0][batch_number]"
                                        placeholder="e.g. BATCH-001"
                                        required
                                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-950"
                                    >

                                </div>

                                <div>

                                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Expiry Date
                                    </label>

                                    <input
                                        type="date"
                                        name="batches[0][expiry_date]"
                                        required
                                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-950"
                                    >

                                </div>

                                <button
                                    type="button"
                                    class="remove-batch h-[50px] rounded-lg bg-red-50 px-4 text-sm font-medium text-red-600 transition hover:bg-red-100 dark:bg-red-950/30 dark:text-red-400 dark:hover:bg-red-950/50"
                                >
                                    Remove
                                </button>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

            <div class="flex justify-end gap-3 border-t border-slate-200 px-6 py-5 dark:border-slate-800">

                <a
                    href="{{ route('inventory.index') }}"
                    class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700"
                >
                    Save Inventory Item
                </button>

            </div>

        </form>

    </div>

</body>

</html>