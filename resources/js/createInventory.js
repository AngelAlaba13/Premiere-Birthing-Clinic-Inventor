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
    let batchIndex = Number(
        batchContainer.dataset.initialCount || 1
    );

    addBatchButton.addEventListener('click', function () {
        const row = document.createElement('div');

        row.className =
            'batch-row grid grid-cols-1 items-end gap-4 rounded-lg border border-slate-200 bg-slate-50 p-4 md:grid-cols-[1fr_1fr_auto] dark:border-slate-800 dark:bg-slate-950';

        row.innerHTML = `
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Batch Number
                </label>

                <input
                    type="text"
                    name="batches[${batchIndex}][batch_number]"
                    placeholder="e.g. BATCH-002"
                    required
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-blue-400 dark:focus:ring-blue-950"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Expiry Date
                </label>

                <input
                    type="date"
                    name="batches[${batchIndex}][expiry_date]"
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