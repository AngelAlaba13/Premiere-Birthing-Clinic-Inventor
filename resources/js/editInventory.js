const displayInput = document.getElementById('in_display');
const stockInput = document.getElementById('in_stock');
const totalInput = document.getElementById('total_quantity');

function calculateTotal() {
    const display = Number(displayInput.value) || 0;
    const stock = Number(stockInput.value) || 0;

    totalInput.value = display + stock;
}

if (displayInput && stockInput && totalInput) {
    displayInput.addEventListener('input', calculateTotal);
    stockInput.addEventListener('input', calculateTotal);
}

const batchContainer = document.getElementById('batch-container');
const addBatchButton = document.getElementById('add-batch');

if (batchContainer && addBatchButton) {
    let batchIndex = batchContainer.querySelectorAll('.batch-row').length;

    addBatchButton.addEventListener('click', function () {
        const row = document.createElement('div');

        row.className =
            'batch-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-end';

        row.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Batch Number
                </label>

                <input
                    type="text"
                    name="batches[${batchIndex}][batch_number]"
                    placeholder="e.g. BATCH-002"
                    required
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-blue-500 dark:focus:ring-blue-900/40"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Expiry Date
                </label>

                <input
                    type="date"
                    name="batches[${batchIndex}][expiry_date]"
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
        `;

        batchContainer.appendChild(row);

        batchIndex++;
    });

    batchContainer.addEventListener('click', function (event) {
        if (!event.target.classList.contains('remove-batch')) {
            return;
        }

        const rows = batchContainer.querySelectorAll('.batch-row');

        if (rows.length <= 1) {
            return;
        }

        event.target.closest('.batch-row').remove();
    });
}