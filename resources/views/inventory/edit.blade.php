<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite([
        'resources/css/app.css',
        'resources/js/darkMode.js',
        'resources/js/editInventory.js'
    ])

    <title>Edit {{ $inventory->item_name }}</title>
</head>

<body class="min-h-screen bg-gray-100 text-gray-800 transition-colors duration-200 dark:bg-slate-950 dark:text-slate-100">

    <div class="mx-auto max-w-5xl px-6 py-10">

        <div class="mb-8">

            <a
                href="{{ route('inventory.index') }}"
                class="text-sm text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
            >
                ← Back to Inventory
            </a>

            <h1 class="mt-3 text-3xl font-bold text-gray-800 dark:text-white">
                Edit Inventory Item
            </h1>

            <p class="mt-1 text-gray-500 dark:text-slate-400">
                Update {{ $inventory->item_name }}.
            </p>

        </div>

        @if ($errors->any())

            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-900/50 dark:bg-red-950/40">

                <ul class="space-y-1 text-sm text-red-600 dark:text-red-300">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('inventory.update', $inventory) }}"
            method="POST"
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-colors duration-200 dark:border-slate-800 dark:bg-slate-900"
        >

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-slate-300">
                        Item Name
                    </label>

                    <input
                        type="text"
                        name="item_name"
                        value="{{ old('item_name', $inventory->item_name) }}"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-blue-500 dark:focus:ring-blue-900/40"
                    >

                </div>

                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-slate-300">
                        In Display
                    </label>

                    <input
                        type="number"
                        id="in_display"
                        name="in_display"
                        value="{{ old('in_display', $inventory->in_display) }}"
                        min="0"
                        required
                        class="quantity-input w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-blue-500 dark:focus:ring-blue-900/40"
                    >

                </div>

                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-slate-300">
                        In Stock
                    </label>

                    <input
                        type="number"
                        id="in_stock"
                        name="in_stock"
                        value="{{ old('in_stock', $inventory->in_stock) }}"
                        min="0"
                        required
                        class="quantity-input w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-blue-500 dark:focus:ring-blue-900/40"
                    >

                </div>

                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-slate-300">
                        Total Quantity
                    </label>

                    <input
                        type="number"
                        id="total_quantity"
                        value="{{ old('in_display', $inventory->in_display) + old('in_stock', $inventory->in_stock) }}"
                        readonly
                        class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-4 py-3 font-semibold text-gray-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300"
                    >

                </div>

                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-slate-300">
                        Unit
                    </label>

                    <select
                        name="unit"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-blue-500 dark:focus:ring-blue-900/40"
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
                                @selected(old('unit', $inventory->unit) === $unit)
                            >
                                {{ $unit }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-slate-300">
                        Category
                    </label>

                    <select
                        name="category_id"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-blue-500 dark:focus:ring-blue-900/40"
                    >

                        <option value="">
                            Select Category
                        </option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id', $inventory->category_id) == $category->id)
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="mt-10">

                <div class="mb-4 flex items-center justify-between">

                    <div>

                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Expiry Batches
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-slate-400">
                            Update existing batches or add new ones.
                        </p>

                    </div>

                    <button
                        type="button"
                        id="add-batch"
                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
                    >
                        + Add Batch
                    </button>

                </div>

                <div
                    id="batch-container"
                    class="space-y-3"
                >

                    @foreach ($inventory->expiries as $index => $expiry)

                        <div class="batch-row grid grid-cols-1 items-end gap-3 md:grid-cols-[1fr_1fr_auto]">

                            <input
                                type="hidden"
                                name="batches[{{ $index }}][id]"
                                value="{{ $expiry->id }}"
                            >

                            <div>

                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-slate-300">
                                    Batch Number
                                </label>

                                <input
                                    type="text"
                                    name="batches[{{ $index }}][batch_number]"
                                    value="{{ $expiry->batch_number }}"
                                    required
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-blue-500 dark:focus:ring-blue-900/40"
                                >

                            </div>

                            <div>

                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-slate-300">
                                    Expiry Date
                                </label>

                                <input
                                    type="date"
                                    name="batches[{{ $index }}][expiry_date]"
                                    value="{{ $expiry->expiry_date->format('Y-m-d') }}"
                                    required
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-blue-500 dark:focus:ring-blue-900/40"
                                >

                            </div>

                            <button
                                type="button"
                                class="remove-batch h-[50px] rounded-lg bg-red-50 px-4 text-red-600 transition hover:bg-red-100 dark:bg-red-950/40 dark:text-red-300 dark:hover:bg-red-950/70"
                            >
                                Remove
                            </button>

                        </div>

                    @endforeach

                </div>

            </div>

            <div class="mt-10 flex justify-end gap-3 border-t border-gray-200 pt-6 dark:border-slate-800">

                <a
                    href="{{ route('inventory.index') }}"
                    class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
                >
                    Update Inventory Item
                </button>

            </div>

        </form>

    </div>

</body>

</html>