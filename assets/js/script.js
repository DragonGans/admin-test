document.addEventListener('DOMContentLoaded', function() {
    // Universal functions first
    function showAlert(message, type = 'success') {
        const types = { success: 'success', warning: 'warning', danger: 'danger', info: 'info' };
        const alertHtml = `
            <div class="alert alert-${types[type] || 'info'} alert-dismissible fade show position-fixed" style="top: 1rem; right: 1rem; z-index: 1060; min-width: 300px;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        setTimeout(() => document.querySelector('.alert')?.remove(), 5000);
    }

    function downloadCSV(filename, data) {
        const csv = 'data:text/csv;charset=utf-8,' + encodeURIComponent(data);
        const link = document.createElement('a');
        link.setAttribute('href', csv);
        link.setAttribute('download', filename);
        link.click();
    }

    function confirmAction(message, callback) {
        if (confirm(message)) callback();
    }

    // Login page
    if (document.body.classList.contains('login-body')) {
        const form = document.getElementById('loginForm');
        form?.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            if (!username || !document.getElementById('password').value.trim()) {
                e.preventDefault();
                showAlert('Please fill all fields!', 'warning');
            }
        });
        return;
    }

    // Theme system (global)
    const html = document.documentElement;
    const themeToggle = document.getElementById('themeToggle') || document.querySelector('.theme-toggle');
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', savedTheme);
    themeToggle?.querySelector('i').className = savedTheme === 'dark' ? 'fas fa-moon fs-6' : 'fas fa-sun fs-6';
    themeToggle?.addEventListener('click', () => {
        const newTheme = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        themeToggle.querySelector('i').className = newTheme === 'dark' ? 'fas fa-moon fs-6' : 'fas fa-sun fs-6';
        showAlert(`Theme changed to ${newTheme === 'dark' ? 'Dark' : 'Light'} mode`, 'success');
    });

    // Sidebar toggle
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar')?.classList.toggle('show');
        bootstrap.Offcanvas.getInstance(document.getElementById('sidebarOffcanvas'))?.show();
    });

    // Active nav highlighting
    const currentPage = window.location.pathname.split('/').pop() || 'dashboard.php';
    document.querySelectorAll('.nav-link[href]').forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }
    });

    // Notifications system
    document.querySelectorAll('[data-notif-id]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.notifId;
            this.remove();
            const badge = document.getElementById('notifBadge');
            let count = parseInt(badge.textContent) - 1;
            badge.textContent = count;
            badge.style.display = count > 0 ? '' : 'none';
            showAlert('Notification dismissed', 'info');
        });
    });

    // Search functionality (dashboard table + universal)
    const searchInput = document.querySelector('.topbar input[placeholder*="Search"]') || document.querySelector('#usersSearch, #productsSearch');
    const recentTable = document.querySelector('.table-container table');
    searchInput?.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        recentTable?.querySelectorAll('tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });

    // Export buttons
    document.querySelectorAll('[id*="export"], .btn-primary:has(i[class*="download"])').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            let filename = 'export.csv';
            let csvData = 'Name,Value\n';
            if (this.id.includes('users') || document.getElementById('usersTable')) {
                filename = 'users.csv';
                csvData = 'ID,Name,Email,Role,Status\nJohn Doe,john@example.com,Admin,Active\nJane Smith,jane@example.com,Editor,Active';
            } else if (this.id.includes('products')) {
                filename = 'products.csv';
                csvData = 'Name,Price,Stock,Status\niPhone 15 Pro,$999,25,In Stock';
            } else {
                // Dashboard stats
                csvData = 'Metric,Value\nUsers,1234\nOrders,567\nRevenue,$23456\nSales,128';
            }
            downloadCSV(filename, csvData);
            showAlert('Data exported successfully!', 'success');
        });
    });

    // View All modals and links
    document.querySelectorAll('a[href="#"]:not(.dropdown-item), .btn-outline-primary:not([data-bs-toggle])').forEach(link => {
        if (link.textContent.includes('View All') || link.textContent.includes('Export')) return;
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = window.location.pathname.split('/').pop();
            showAlert(`Loading all ${page.replace('.php', 's')}... (dummy data loaded)`, 'info');
            // Could open modal with dummy list here
        });
    });

    // Stats cards click to "drill down"
    document.querySelectorAll('.stat-card').forEach(card => {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function() {
            const metric = this.querySelector('.text-muted').textContent;
            showAlert(`${metric}: Detailed view (dummy analytics shown)`, 'info');
        });
    });

    // Table action buttons (universal for all pages)
    document.querySelectorAll('.view-detail, .edit-user, .delete-user, .view-product, .edit-product, .delete-product').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.className.includes('view') ? 'View' : this.className.includes('edit') ? 'Edit' : 'Delete';
            const id = this.dataset.id;
            if (action === 'Delete') {
                confirmAction(`Delete item ${id}?`, () => {
                    this.closest('tr').remove();
                    showAlert(`Item ${id} deleted (dummy)`, 'success');
                });
            } else {
                showAlert(`${action} item ${id} (dummy modal would open)`, 'info');
            }
        });
    });

    // Period selector (sales chart filter)
    document.querySelectorAll('select[style*="150px"]').forEach(select => {
        select.addEventListener('change', function() {
            showAlert(`Chart filtered to ${this.value} (dummy data refresh)`, 'info');
            // Could destroy/recreate chart here with different data
        });
    });

    // Charts and stats (existing + enhanced)
    initCharts();
    animateStats();

    // Tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));

    // Shake animation CSS
    if (!document.querySelector('#shake-style')) {
        const style = document.createElement('style');
        style.id = 'shake-style';
        style.textContent = `@keyframes shake {0%,100%{transform:translateX(0);}25%{transform:translateX(-5px);}75%{transform:translateX(5px);}}`;
        document.head.appendChild(style);
    }
});

// Existing chart/stats functions (unchanged)
function initCharts() {
    const salesCtx = document.getElementById('salesChart')?.getContext('2d');
    if (salesCtx) new Chart(salesCtx, {
        type: 'line', data: {labels:['Jan','Feb','Mar','Apr','May','Jun'], datasets:[{label:'Sales',data:[120,190,300,500,200,300],borderColor:'#667eea',backgroundColor:'rgba(102,126,234,0.1)',tension:0.4,fill:true}]},
        options: {responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}
    });
    const ordersCtx = document.getElementById('ordersChart')?.getContext('2d');
    if (ordersCtx) new Chart(ordersCtx, {type:'doughnut',data:{labels:['Completed','Pending','Cancelled'],datasets:[{data:[65,28,7],backgroundColor:['#43e97b','#f093fb','#ff6b6b']}]},options:{responsive:true}});
}

function animateStats() {
    const observerOptions = {threshold:0.5};
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const number = entry.target.querySelector('.stat-number');
                if (number) {
                    let target = parseInt(number.dataset.target), current = 0, increment = target / 100;
                    const timer = setInterval(() => {
                        current += increment;
                        number.textContent = current >= target ? target.toLocaleString() : Math.floor(current).toLocaleString();
                        if (current >= target) clearInterval(timer);
                    }, 20);
                }
            }
        });
    }, observerOptions);
    document.querySelectorAll('.stat-card').forEach(card => observer.observe(card));
}
