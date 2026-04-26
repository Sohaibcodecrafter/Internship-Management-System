/* ==============================================
   IMS MAIN JS — Validation + UI Interactions
   ============================================== */

// ---- CLIENT-SIDE FORM VALIDATION ----
document.addEventListener('DOMContentLoaded', () => {

    // Login form validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            let valid = true;
            const username = document.getElementById('username');
            const password = document.getElementById('password');

            clearErrors();

            if (!username.value.trim()) {
                showError('err-username', 'Username is required.');
                username.classList.add('input-error');
                valid = false;
            }
            if (password.value.length < 6) {
                showError('err-password', 'Password must be at least 6 characters.');
                password.classList.add('input-error');
                valid = false;
            }
            if (!valid) e.preventDefault();
        });
    }

    // Generic form validation for Add/Edit forms
    document.querySelectorAll('[data-validate="true"]').forEach(form => {
        form.addEventListener('submit', (e) => {
            let valid = true;
            clearErrors();
            form.querySelectorAll('[required]').forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('input-error');
                    const errSpan = document.getElementById('err-' + field.name);
                    if (errSpan) showError('err-' + field.name, `${field.placeholder || field.name} is required.`);
                    valid = false;
                }
                if (field.type === 'email' && field.value && !field.value.includes('@')) {
                    showError('err-' + field.name, 'Enter a valid email address.');
                    valid = false;
                }
                if (field.name === 'gpa') {
                    const v = parseFloat(field.value);
                    if (isNaN(v) || v < 0 || v > 4) {
                        showError('err-gpa', 'GPA must be between 0.00 and 4.00.');
                        valid = false;
                    }
                }
            });
            if (!valid) e.preventDefault();
        });
    });

    // ---- SEARCH DEBOUNCE ----
    const searchInputs = document.querySelectorAll('.live-search');
    searchInputs.forEach(input => {
        let timer;
        input.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                input.closest('form').submit();
            }, 400);
        });
    });

    // ---- CLEAR INPUT ERRORS ON FOCUS ----
    document.querySelectorAll('.input-field, .select-field').forEach(el => {
        el.addEventListener('focus', () => el.classList.remove('input-error'));
    });
});

function showError(id, msg) {
    const el = document.getElementById(id);
    if (el) el.textContent = msg;
}

function clearErrors() {
    document.querySelectorAll('.error-msg').forEach(e => e.textContent = '');
    document.querySelectorAll('.input-error').forEach(e => e.classList.remove('input-error'));
}

// ---- CONFIRM DELETE ----
function confirmDelete(msg) {
    return confirm(msg || 'Are you sure you want to delete this record? This cannot be undone.');
}

// ═══════════════════════════════════════════════════
// IMS SIDEBAR + THEME UPGRADE — appended, do not edit above
// ═══════════════════════════════════════════════════

const IMSSidebar = (() => {
    const STORAGE_KEY = 'ims_sidebar_collapsed';
    const sidebar     = document.getElementById('ims-sidebar');
    const layout      = document.getElementById('ims-layout');

    function apply(collapsed) {
        if (!sidebar) return;
        sidebar.classList.toggle('ims-sidebar--collapsed', collapsed);
        layout && layout.classList.toggle('ims-layout--collapsed', collapsed);
        localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
    }

    function toggle() {
        const isCollapsed = sidebar.classList.contains('ims-sidebar--collapsed');
        apply(!isCollapsed);
    }

    function mobileToggle() {
        if (!sidebar) return;
        sidebar.classList.toggle('ims-sidebar--mobile-open');
        const overlay = document.getElementById('ims-overlay');
        if (overlay) overlay.classList.toggle('ims-overlay--active');
    }

    function init() {
        const saved = localStorage.getItem(STORAGE_KEY) === '1';
        apply(saved);

        // Close mobile sidebar on outside click
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 &&
                sidebar &&
                !sidebar.contains(e.target) &&
                !document.getElementById('ims-hamburger')?.contains(e.target) &&
                !document.getElementById('ims-mobile-toggle')?.contains(e.target)) {
                sidebar.classList.remove('ims-sidebar--mobile-open');
                const overlay = document.getElementById('ims-overlay');
                if (overlay) overlay.classList.remove('ims-overlay--active');
            }
        });
    }

    return { toggle, mobileToggle, init };
})();

const IMSTheme = (() => {
    const STORAGE_KEY = 'ims_theme';
    const btn         = document.getElementById('ims-theme-toggle');

    function apply(dark) {
        document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
        const moon = document.getElementById('ims-icon-moon');
        const sun  = document.getElementById('ims-icon-sun');
        if (moon) moon.style.display = dark ? 'none'  : 'block';
        if (sun)  sun.style.display  = dark ? 'block' : 'none';
        localStorage.setItem(STORAGE_KEY, dark ? 'dark' : 'light');
    }

    function toggle() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        apply(!isDark);
    }

    function init() {
        const saved = localStorage.getItem(STORAGE_KEY);
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        apply(saved ? saved === 'dark' : prefersDark);
    }

    return { toggle, init };
})();

// Auto-init when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    IMSSidebar.init();
    IMSTheme.init();
});
