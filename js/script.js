document.addEventListener('DOMContentLoaded', function () {

  // ── HEADER TOGGLES ─────────────────────────────
  const navbar  = document.querySelector('.header .navbar');
  const userBox = document.querySelector('.header .user-box');

  window.toggleMenu = function () {
    if (!navbar) return;
    navbar.classList.toggle('active');
    if (userBox) userBox.classList.remove('active');
  };

  window.toggleUser = function () {
    if (!userBox) return;
    userBox.classList.toggle('active');
    if (navbar) navbar.classList.remove('active');
  };

  document.addEventListener('click', function (e) {
    if (navbar && !e.target.closest('.header .navbar') && !e.target.closest('#menu-btn'))
      navbar.classList.remove('active');
    if (userBox && !e.target.closest('.header .user-box') && !e.target.closest('#user-btn'))
      userBox.classList.remove('active');
  });

  // ── SCROLL REVEAL ──────────────────────────────
  const reveals = document.querySelectorAll('.reveal');
  if (reveals.length && 'IntersectionObserver' in window) {
    const obs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    reveals.forEach(el => obs.observe(el));
  } else {
    reveals.forEach(el => el.classList.add('visible'));
  }

  // ── ANIMATED COUNTERS ──────────────────────────
  function animateCount(el) {
    const src  = el.textContent.trim();
    const match = src.match(/([\d.]+)/);
    if (!match) return;
    const target   = parseFloat(match[1]);
    const suffix   = src.replace(/[\d.]+/, '');
    const isFloat  = src.includes('.');
    const dur      = 1600;
    const fps      = 60;
    const steps    = dur / (1000 / fps);
    const inc      = target / steps;
    let current    = 0;
    const timer    = setInterval(() => {
      current += inc;
      if (current >= target) { current = target; clearInterval(timer); }
      el.textContent = isFloat ? current.toFixed(1) + suffix : Math.floor(current) + suffix;
    }, 1000 / fps);
  }

  const counters = document.querySelectorAll('.stat-num, .astat-num');
  if (counters.length && 'IntersectionObserver' in window) {
    const cObs = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) { animateCount(e.target); cObs.unobserve(e.target); }
      });
    }, { threshold: 0.5 });
    counters.forEach(el => cObs.observe(el));
  }

  // ── ACTIVE NAV LINK ────────────────────────────
  const page = window.location.pathname.split('/').pop();
  document.querySelectorAll('.header .navbar a').forEach(a => {
    if (a.getAttribute('href') === page) {
      a.style.color = 'var(--amber)';
      a.style.fontWeight = '700';
    }
  });

  // ── AUTO-DISMISS MESSAGES ──────────────────────
  document.querySelectorAll('.message').forEach(m => {
    setTimeout(() => {
      m.style.transition = 'opacity .4s ease, transform .4s ease';
      m.style.opacity = '0';
      m.style.transform = 'translateY(-100%)';
      setTimeout(() => m.remove(), 450);
    }, 4500);
  });

  // ── BACK-TO-TOP ────────────────────────────────
  const btt = document.createElement('button');
  btt.innerHTML = '<i class="fas fa-arrow-up"></i>';
  btt.id = 'back-to-top';
  btt.title = 'Back to top';
  btt.style.cssText = 'position:fixed;bottom:2.5rem;right:2.5rem;width:4.5rem;height:4.5rem;border-radius:50%;background:var(--amber);color:#fff;border:none;cursor:pointer;font-size:1.8rem;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 18px rgba(200,104,10,.4);opacity:0;transform:translateY(10px);transition:all .3s ease;z-index:9000';
  document.body.appendChild(btt);
  window.addEventListener('scroll', () => {
    if (window.scrollY > 400) { btt.style.opacity = '1'; btt.style.transform = 'translateY(0)'; }
    else { btt.style.opacity = '0'; btt.style.transform = 'translateY(10px)'; }
  });
  btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  // ── NEWSLETTER (prevent default, show confirm) ──
  const nlBtn = document.querySelector('.newsletter-form button');
  const nlInput = document.querySelector('.newsletter-form input');
  if (nlBtn && nlInput) {
    nlBtn.addEventListener('click', () => {
      const e = nlInput.value.trim();
      if (!e || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e)) {
        nlInput.style.outline = '2px solid #dc2626';
        nlInput.placeholder = 'Please enter a valid email';
        return;
      }
      nlInput.style.outline = '';
      nlBtn.innerHTML = '<i class="fas fa-check"></i> Subscribed!';
      nlBtn.style.background = 'var(--green)';
      nlInput.value = '';
      setTimeout(() => { nlBtn.innerHTML = '<i class="fas fa-arrow-right"></i> Subscribe'; nlBtn.style.background = ''; }, 3000);
    });
  }

});