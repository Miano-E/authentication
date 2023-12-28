
const togglePassword = document.querySelector('#togglePassword');
const toggleconfirmPassword = document.querySelector('#toggleconfirmPassword');
const password = document.querySelector('#id_password');
const confirmPassword = document.querySelector('#id_confirm_password');
let isHidden = true; // Flag to track the password visibility

togglePassword.addEventListener('click', function (e) {
// Toggle the type attribute
const type = isHidden ? 'text' : 'password';
password.setAttribute('type', type);
isHidden = !isHidden;

// Toggle the eye icon using Font Awesome classes
if (isHidden) {
    togglePassword.classList.remove('fa-eye');
    togglePassword.classList.add('fa-eye-slash');
} else {
    togglePassword.classList.remove('fa-eye-slash');
    togglePassword.classList.add('fa-eye');
}
});

toggleconfirmPassword.addEventListener('click', function (e) {
// Toggle the type attribute for confirmPassword field
const type = isHidden ? 'text' : 'password';
confirmPassword.setAttribute('type', type);
isHidden = !isHidden;

// Toggle the eye icon using Font Awesome classes for confirmPassword
if (isHidden) {
    toggleconfirmPassword.classList.remove('fa-eye');
    toggleconfirmPassword.classList.add('fa-eye-slash');
} else {
    toggleconfirmPassword.classList.remove('fa-eye-slash');
    toggleconfirmPassword.classList.add('fa-eye');
}
});

password.addEventListener('input', function (e) {
// Show the icon when there's input in the password field
togglePassword.style.display = password.value.trim() !== '' ? 'inline' : 'none';
});

confirmPassword.addEventListener('input', function (e) {
// Show the icon when there's input in the confirmPassword field
toggleconfirmPassword.style.display = confirmPassword.value.trim() !== '' ? 'inline' : 'none';
});

// Initially, hide the icons
togglePassword.style.display = 'none';
toggleconfirmPassword.style.display = 'none';
