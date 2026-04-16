document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    
    // Auto focus ke username
    usernameInput.focus();
    
    // Enter key support
    document.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            form.submit();
        }
    });
    
    // Input validation
    form.addEventListener('submit', function(e) {
        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();
        
        if (username === '' || password === '') {
            e.preventDefault();
            alert('Mohon isi username dan password!');
            return false;
        }
    });
    
    // Shake animation on wrong login (optional)
    const alerts = document.querySelectorAll('.alert-danger');
    alerts.forEach(alert => {
        alert.addEventListener('click', function() {
            this.style.animation = 'shake 0.5s ease-in-out';
            setTimeout(() => {
                this.style.animation = '';
            }, 500);
        });
    });
});