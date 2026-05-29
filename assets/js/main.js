/* Ember & Oak — main.js */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {

    // ── Mobile Nav ────────────────────────────────────────────────────────
    var toggle = document.getElementById('menu-toggle');
    var menu   = document.getElementById('primary-menu');
    if (toggle && menu) {
      toggle.addEventListener('click', function () {
        var open = menu.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
      document.addEventListener('click', function (e) {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
          menu.classList.remove('is-open');
          toggle.setAttribute('aria-expanded', 'false');
        }
      });
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
          menu.classList.remove('is-open');
          toggle.setAttribute('aria-expanded', 'false');
        }
      });
    }

    // ── Sticky Header ─────────────────────────────────────────────────────
    var header = document.getElementById('masthead');
    if (header) {
      window.addEventListener('scroll', function () {
        header.classList.toggle('is-scrolled', window.scrollY > 60);
      }, { passive: true });
    }

    // ── Brew Guide Tabs ───────────────────────────────────────────────────
    document.querySelectorAll('.brew-tabs__nav').forEach(function (nav) {
      var container = nav.closest('.brew-guides');
      if (!container) return;
      var btns   = nav.querySelectorAll('.brew-tab-btn');
      var panels = container.querySelectorAll('.brew-panel');
      btns.forEach(function (btn, i) {
        btn.addEventListener('click', function () {
          btns.forEach(function (b) { b.classList.remove('active'); });
          panels.forEach(function (p) { p.classList.remove('active'); });
          btn.classList.add('active');
          if (panels[i]) panels[i].classList.add('active');
        });
      });
      if (btns.length)   btns[0].classList.add('active');
      if (panels.length) panels[0].classList.add('active');
    });

    // ── Blend Archive Filter ──────────────────────────────────────────────
    var filterBtns = document.querySelectorAll('.filter-btn');
    var blendCards = document.querySelectorAll('.blend-card[data-roast]');
    if (filterBtns.length && blendCards.length) {
      filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
          filterBtns.forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
          var filter = btn.dataset.filter;
          blendCards.forEach(function (card) {
            var show = filter === 'all' || card.dataset.roast === filter;
            card.style.display = show ? '' : 'none';
          });
        });
      });
    }

    // ── Weight Selector ───────────────────────────────────────────────────
    document.querySelectorAll('.weight-selector').forEach(function (sel) {
      var btns = sel.querySelectorAll('.weight-btn');
      btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
          btns.forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
        });
      });
      if (btns.length) btns[0].classList.add('active');
    });

    // ── Scroll Animations ─────────────────────────────────────────────────
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            io.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
      document.querySelectorAll('[data-animate]').forEach(function (el) { io.observe(el); });
    } else {
      document.querySelectorAll('[data-animate]').forEach(function (el) { el.classList.add('is-visible'); });
    }

    // ── Contact Form Validation ───────────────────────────────────────────
    var contactForm = document.querySelector('.contact-form');
    if (contactForm) {
      contactForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var valid = true;
        contactForm.querySelectorAll('[required]').forEach(function (field) {
          var err = field.parentElement.querySelector('.field-error');
          if (!field.value.trim()) {
            valid = false;
            if (err) err.textContent = 'This field is required.';
            field.style.borderColor = '#c0392b';
          } else if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
            valid = false;
            if (err) err.textContent = 'Enter a valid email.';
            field.style.borderColor = '#c0392b';
          } else {
            if (err) err.textContent = '';
            field.style.borderColor = '';
          }
        });
        if (valid) {
          contactForm.innerHTML = '<div style="padding:2rem;text-align:center;background:var(--color-milk);border-radius:8px;"><h3>Message Sent!</h3><p>We\'ll reply within one business day.</p></div>';
        }
      });
    }

  });
})();
