// This file contains JavaScript code for handling user interactions on the login page.

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        if (validateForm(username, password)) {
            // Proceed with form submission (e.g., send data to server)
            console.log('Form submitted:', { username, password });
        } else {
            alert('Please fill in both fields.');
        }
    });

    function validateForm(username, password) {
        return username.trim() !== '' && password.trim() !== '';
    }
});