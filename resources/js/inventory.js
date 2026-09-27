const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const statusFilter = document.getElementById('statusFilter');
const inventoryBody = document.getElementById('inventoryBody');
const noResults = document.getElementById('noResults');

function filterInventory() {
    const search = searchInput.value.toLowerCase().trim();
    const category = categoryFilter.value;
    const status = statusFilter.value;

    const rows = inventoryBody.querySelectorAll('.inventory-row');

    let visibleCount = 0;

    rows.forEach(row => {
        const item = row.dataset.item;
        const rowCategory = row.dataset.category;
        const rowStatus = row.dataset.status;

        const matchesSearch = item.includes(search);

        const matchesCategory =
            category === 'all' ||
            rowCategory === category;

        const matchesStatus =
            status === 'all' ||
            rowStatus === status;

        const visible =
            matchesSearch &&
            matchesCategory &&
            matchesStatus;

        row.style.display = visible ? '' : 'none';

        if (visible) {
            visibleCount++;
        }
    });

    noResults.classList.toggle(
        'hidden',
        visibleCount !== 0
    );
}

if (searchInput) {
    searchInput.addEventListener(
        'input',
        filterInventory
    );
}

if (categoryFilter) {
    categoryFilter.addEventListener(
        'change',
        filterInventory
    );
}

if (statusFilter) {
    statusFilter.addEventListener(
        'change',
        filterInventory
    );
}

const sortableHeaders =
    document.querySelectorAll('.sortable');

sortableHeaders.forEach(header => {

    header.addEventListener('click', function () {

        const sortType = this.dataset.sort;

        const rows = Array.from(
            inventoryBody.querySelectorAll('.inventory-row')
        );

        const currentDirection =
            this.dataset.direction || 'asc';

        const newDirection =
            currentDirection === 'asc'
                ? 'desc'
                : 'asc';

        sortableHeaders.forEach(item => {

            item.dataset.direction = '';

            const icon =
                item.querySelector('.sort-icon');

            if (icon) {
                icon.textContent = '';
            }

        });

        this.dataset.direction = newDirection;

        const icon =
            this.querySelector('.sort-icon');

        if (icon) {
            icon.textContent =
                newDirection === 'asc'
                    ? ' ↑'
                    : ' ↓';
        }

        rows.sort((a, b) => {

            let valueA;
            let valueB;

            if (
                sortType === 'display' ||
                sortType === 'stock' ||
                sortType === 'total' ||
                sortType === 'expiry'
            ) {
                valueA =
                    Number(a.dataset[sortType]);

                valueB =
                    Number(b.dataset[sortType]);
            } else {
                valueA =
                    a.dataset[sortType];

                valueB =
                    b.dataset[sortType];
            }

            if (valueA < valueB) {
                return newDirection === 'asc'
                    ? -1
                    : 1;
            }

            if (valueA > valueB) {
                return newDirection === 'asc'
                    ? 1
                    : -1;
            }

            return 0;
        });

        rows.forEach(row => {
            inventoryBody.appendChild(row);
        });

    });

});