// Auto-dismiss flash toasts after 4 seconds
document.addEventListener('DOMContentLoaded', () => {
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(t => {
        if (t.textContent.trim()) {
            t.style.display = 'block';
            setTimeout(() => {
                t.style.opacity = '0';
                t.style.transition = 'opacity 0.5s';
                setTimeout(() => { t.style.display = 'none'; }, 500);
            }, 4000);
        }
    });
});
