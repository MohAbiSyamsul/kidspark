// Kids Park - Admin JavaScript

// Auto-hide alert
const alertEl = document.querySelector('.alert');
if (alertEl) {
  setTimeout(() => {
    alertEl.style.opacity = '0';
    alertEl.style.transition = 'opacity 0.3s';
    setTimeout(() => alertEl.remove(), 300);
  }, 3500);
}

// Close modal on backdrop click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) {
      overlay.classList.remove('open');
    }
  });
});

// Confirm before form submit for delete
document.querySelectorAll('[data-confirm]').forEach(btn => {
  btn.addEventListener('click', (e) => {
    if (!confirm(btn.dataset.confirm)) e.preventDefault();
  });
});
