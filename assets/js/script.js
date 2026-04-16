document.addEventListener('DOMContentLoaded', function() {
    // ========== LOGIN PAGE ==========
    if (document.body.classList.contains('login-body')) {
        const form = document.getElementById('loginForm');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        
        // Auto focus
        usernameInput.focus();
        
        // Enter support
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                form?.submit();
            }
        });
        
        // Validation
        form?.addEventListener('submit', function(e) {
            const username = usernameInput.value.trim();
            const password = passwordInput.value.trim();
            
            if (!username || !password) {
                e.preventDefault();
                showAlert('Mohon isi username dan password!');
                return false;
            }
        });
        
        // Shake animation for alerts
        document.querySelectorAll('.alert-danger').forEach(alert => {
            alert.addEventListener('click', function() {
                this.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => this.style.animation = '', 500);
            });
        });
        
        return; // Exit for login page
    }

    // ========== DASHBOARD PAGE ==========
    
    // Sidebar toggle (mobile)
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const offcanvas = new bootstrap.Offcanvas(document.getElementById('sidebarOffcanvas'));
    
    sidebarToggle?.addEventListener('click', function() {
        sidebar?.classList.toggle('show');
        offcanvas?.show();
    });
    
    // Close sidebar on link click (mobile)
    document.querySelectorAll('.sidebar .nav-link, .offcanvas .nav-link').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                sidebar?.classList.remove('show');
                offcanvas?.hide();
            }
        });
    });
    
    // Dark mode toggle
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    
    themeToggle?.addEventListener('click', function() {
        if (html.getAttribute('data-bs-theme') === 'dark') {
            html.setAttribute('data-bs-theme', 'light');
            localStorage.setItem('theme', 'light');
            this.querySelector('i').className = 'fas fa-sun fs-6';
        } else {
            html.setAttribute('data-bs-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            this.querySelector('i').className = 'fas fa-moon fs-6';
        }
    });
    
    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', savedTheme);
    const toggleIcon = themeToggle?.querySelector('i');
    if (savedTheme === 'dark') {
        toggleIcon.className = 'fas fa-moon fs-6';
    }
    
    // Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Charts (demo data)
    initCharts();
    
    // Animate stats on scroll
    animateStats();
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});

// Charts initialization
function initCharts() {
    // Sales chart
    const salesCtx = document.getElementById('salesChart')?.getContext('2d');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales',
                    data: [120, 190, 300, 500, 200, 300],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } }
                }
            }
        });
    }
    
    // Orders pie chart
    const ordersCtx = document.getElementById('ordersChart')?.getContext('2d');
    if (ordersCtx) {
        new Chart(ordersCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [65, 28, 7],
                    backgroundColor: ['#43e97b', '#f093fb', '#ff6b6b']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
}

// Animate stats numbers
function animateStats() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const number = entry.target.querySelector('.stat-number');
                if (number) {
                    const target = parseInt(number.getAttribute('data-target'));
                    const increment = target / 100;
                    let current = 0;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            number.textContent = target.toLocaleString();
                            clearInterval(timer);
                        } else {
                            number.textContent = Math.floor(current).toLocaleString();
                        }
                    }, 20);
                }
            }
        });
    });
    
    document.querySelectorAll('.stat-card').forEach(card => observer.observe(card));
}

// Utility: Show alert
function showAlert(message) {
    const alertHtml = `
        <div class="alert alert-warning alert-dismissible fade show position-fixed" style="top: 1rem; right: 1rem; z-index: 1060; min-width: 300px;">
            <i class="fas fa-exclamation-triangle me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    // Auto remove after 5s
    setTimeout(() => {
        const alert = document.querySelector('.alert-warning');
        if (alert) alert.remove();
    }, 5000);
}

// Add shake animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
`;
document.head.appendChild(style);
