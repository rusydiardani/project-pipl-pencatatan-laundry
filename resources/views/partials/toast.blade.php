<!-- Toast Container -->
<div id="toast-container" class="toast-container"></div>

<script>
// Toast Notification System
const Toast = {
    show(message, type = 'info', title = '', duration = 4000) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        // Icon mapping
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-times-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };

        // Default titles
        const titles = {
            success: title || 'Berhasil!',
            error: title || 'Error!',
            warning: title || 'Peringatan!',
            info: title || 'Info'
        };

        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas ${icons[type]}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${titles[type]}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.classList.add('removing'); setTimeout(() => this.parentElement.remove(), 300)">
                <i class="fas fa-times"></i>
            </button>
        `;

        container.appendChild(toast);

        // Auto remove after duration
        setTimeout(() => {
            toast.classList.add('removing');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    },

    success(message, title = '') {
        this.show(message, 'success', title);
    },

    error(message, title = '') {
        this.show(message, 'error', title);
    },

    warning(message, title = '') {
        this.show(message, 'warning', title);
    },

    info(message, title = '') {
        this.show(message, 'info', title);
    }
};

// Auto-show Laravel session messages
document.addEventListener('DOMContentLoaded', function() {

    @if(session('success'))
        Toast.success({!! json_encode(session('success')) !!});
    @endif

    @if(session('error'))
        Toast.error({!! json_encode(session('error')) !!});
    @endif

    @if(session('warning'))
        Toast.warning({!! json_encode(session('warning')) !!});
    @endif

    @if(session('info'))
        Toast.info({!! json_encode(session('info')) !!});
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            Toast.error({!! json_encode($error) !!});
        @endforeach
    @endif
});

// Make Toast globally available
window.Toast = Toast;
</script>
