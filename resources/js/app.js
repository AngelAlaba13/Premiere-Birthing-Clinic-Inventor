import './bootstrap';

const themeToggle = document.getElementById('themeToggle');
const themeLabel = document.getElementById('themeLabel');

function updateThemeLabel() {
    if (!themeLabel) {
        return;
    }

    const isDark =
        document.documentElement.classList.contains('dark');

    themeLabel.textContent =
        isDark
            ? 'Light Mode'
            : 'Dark Mode';
}

if (themeToggle) {
    updateThemeLabel();

    themeToggle.addEventListener('click', function () {

        const isDark =
            document.documentElement.classList.toggle('dark');

        localStorage.setItem(
            'theme',
            isDark ? 'dark' : 'light'
        );

        updateThemeLabel();

    });
}