// /admin/js/admin_script.js

// Example: Confirmation for delete actions
document.querySelectorAll('.btn-danger').forEach(button => {
    button.addEventListener('click', (event) => {
        if (!confirm('Are you sure you want to delete this item?')) {
            event.preventDefault();
        }
    });
});
