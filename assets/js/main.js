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
