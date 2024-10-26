// /assets/js/script.js

// Example: Simple form validation
document.querySelector('form').addEventListener('submit', function(event) {
    const email = document.querySelector('input[type="email"]').value;
    if (!validateEmail(email)) {
        alert('Please enter a valid email address.');
        event.preventDefault(); // Prevent form submission
    }
});

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
