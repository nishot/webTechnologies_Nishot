// assets/js/auth.js
document.addEventListener('DOMContentLoaded', () => {
    const tabLogin = document.getElementById('tab-login');
    const tabRegister = document.getElementById('tab-register');
    const fieldName = document.getElementById('field-name');
    const fieldRole = document.getElementById('field-role');
    const inputName = document.getElementById('input-name');
    const inputRole = document.getElementById('input-role');
    const actionInput = document.getElementById('action-input');
    const submitBtn = document.getElementById('submit-btn');
    const formTitle = document.getElementById('form-title');
    const formSubtitle = document.getElementById('form-subtitle');

    if (!tabLogin || !tabRegister) return;

    tabRegister.addEventListener('click', () => {
        tabRegister.className = "flex-1 py-2 text-sm font-bold rounded-lg transition-all bg-surface-container-lowest shadow-sm text-primary";
        tabLogin.className = "flex-1 py-2 text-sm font-bold rounded-lg transition-all text-on-surface-variant hover:text-on-surface";
        fieldName.classList.remove('hidden');
        fieldRole.classList.remove('hidden');
        actionInput.value = 'register';
        submitBtn.textContent = 'Create Account';
        formTitle.textContent = 'Create Your Account';
        formSubtitle.textContent = 'Join our community and start your impact today.';
        inputName.setAttribute('required', 'true');
        inputRole.setAttribute('required', 'true');
    });

    tabLogin.addEventListener('click', () => {
        tabLogin.className = "flex-1 py-2 text-sm font-bold rounded-lg transition-all bg-surface-container-lowest shadow-sm text-primary";
        tabRegister.className = "flex-1 py-2 text-sm font-bold rounded-lg transition-all text-on-surface-variant hover:text-on-surface";
        fieldName.classList.add('hidden');
        fieldRole.classList.add('hidden');
        actionInput.value = 'login';
        submitBtn.textContent = 'Sign In';
        formTitle.textContent = 'Welcome Back';
        formSubtitle.textContent = 'Please enter your details to continue your impact.';
        inputName.removeAttribute('required');
        inputRole.removeAttribute('required');
    });

    const actionData = document.getElementById('auth-action-data');
    if (actionData && actionData.dataset.action === 'login') {
        tabLogin.click();
    }
});
