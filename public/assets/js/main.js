// Kids Park - Main JavaScript

// Hamburger menu
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.navbar-nav');

if (hamburger) {
  hamburger.addEventListener('click', () => {
    navMenu.classList.toggle('open');
    hamburger.classList.toggle('active');
  });
}

// Close menu on link click
document.querySelectorAll('.navbar-nav a').forEach(link => {
  link.addEventListener('click', () => {
    navMenu.classList.remove('open');
  });
});

// Active nav on scroll
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.navbar-nav a');

window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(section => {
    const sectionTop = section.offsetTop - 100;
    if (window.scrollY >= sectionTop) {
      current = section.getAttribute('id');
    }
  });

  navLinks.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === '#' + current) {
      link.classList.add('active');
    }
  });
});

// Scroll fade-in animation
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      // Stagger children
      const children = entry.target.querySelectorAll('.fade-in');
      children.forEach((child, i) => {
        setTimeout(() => child.classList.add('visible'), i * 100);
      });
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
document.querySelectorAll('section').forEach(el => observer.observe(el));

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const target = document.querySelector(link.getAttribute('href'));
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

// Auto-hide alert
const alertEl = document.querySelector('.alert');
if (alertEl) {
  setTimeout(() => {
    alertEl.style.opacity = '0';
    alertEl.style.transform = 'translateY(-10px)';
    setTimeout(() => alertEl.remove(), 300);
  }, 3000);
}
