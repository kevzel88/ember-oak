/**
 * Ember & Oak WordPress Theme — main.js
 * Vanilla JS, no jQuery dependency.
 */

document.addEventListener('DOMContentLoaded', function () {

  /* =========================================================
   * 1. Mobile Navigation
   * ========================================================= */
  (function initMobileNav() {
    var toggle = document.getElementById('menu-toggle');
    var nav    = document.querySelector('.site-nav') || document.querySelector('nav');

    if (!toggle || !nav) return;

    function openMenu() {
      nav.classList.add('is-open');
      toggle.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
      nav.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
    }

    toggle.addEventListener('click', function () {
      var isOpen = nav.classList.contains('is-open');
      isOpen ? closeMenu() : openMenu();
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!nav.contains(e.target) && !toggle.contains(e.target)) {
        closeMenu();
      }
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' || e.keyCode === 27) {
        closeMenu();
        toggle.focus();
      }
    });
  }());


  /* =========================================================
   * 2. Sticky Header
   * ========================================================= */
  (function initStickyHeader() {
    var header = document.querySelector('.site-header');
    if (!header) return;

    function onScroll() {
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // run once on load
  }());


  /* =========================================================
   * 3. Smooth Scroll
   * ========================================================= */
  (function initSmoothScroll() {
    var header = document.querySelector('.site-header');

    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        var hash = link.getAttribute('href');
        if (!hash || hash === '#') return;

        var target = document.querySelector(hash);
        if (!target) return;

        e.preventDefault();

        var headerHeight = header ? header.offsetHeight : 0;
        var targetTop    = target.getBoundingClientRect().top + window.scrollY - headerHeight;

        window.scrollTo({ top: targetTop, behavior: 'smooth' });
      });
    });
  }());


  /* =========================================================
   * 4. Blend Weight Selector
   * ========================================================= */
  (function initWeightSelector() {
    document.querySelectorAll('.weight-selector').forEach(function (selector) {
      var buttons      = selector.querySelectorAll('button');
      var priceDisplay = selector.closest('[data-weight-container]')
                         ? selector.closest('[data-weight-container]').querySelector('.blend-price')
                         : document.querySelector('.blend-price');

      buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
          buttons.forEach(function (b) {
            b.classList.remove('is-selected');
            b.setAttribute('aria-pressed', 'false');
          });

          btn.classList.add('is-selected');
          btn.setAttribute('aria-pressed', 'true');

          var price = btn.getAttribute('data-price');
          if (price && priceDisplay) {
            priceDisplay.textContent = price;
          }
        });
      });

      // Initialise first button as selected if none already are
      var alreadySelected = selector.querySelector('.is-selected');
      if (!alreadySelected && buttons.length) {
        buttons[0].classList.add('is-selected');
        buttons[0].setAttribute('aria-pressed', 'true');
        var initialPrice = buttons[0].getAttribute('data-price');
        if (initialPrice && priceDisplay) {
          priceDisplay.textContent = initialPrice;
        }
      }
    });
  }());


  /* =========================================================
   * 5. Brew Guide Tabs
   * ========================================================= */
  (function initBrewTabs() {
    document.querySelectorAll('.brew-tabs').forEach(function (tabContainer) {
      var tabs   = tabContainer.querySelectorAll('[role="tab"]');
      var panels = [];

      tabs.forEach(function (tab) {
        var panelId = tab.getAttribute('aria-controls');
        if (panelId) {
          var panel = document.getElementById(panelId);
          if (panel) panels.push(panel);
        }
      });

      function activateTab(selectedTab) {
        tabs.forEach(function (tab) {
          tab.setAttribute('aria-selected', 'false');
          tab.classList.remove('is-active');
        });

        panels.forEach(function (panel) {
          panel.hidden = true;
          panel.classList.remove('is-active');
        });

        selectedTab.setAttribute('aria-selected', 'true');
        selectedTab.classList.add('is-active');

        var panelId = selectedTab.getAttribute('aria-controls');
        if (panelId) {
          var activePanel = document.getElementById(panelId);
          if (activePanel) {
            activePanel.hidden = false;
            activePanel.classList.add('is-active');
          }
        }
      }

      tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
          activateTab(tab);
        });

        tab.addEventListener('keydown', function (e) {
          var idx = Array.prototype.indexOf.call(tabs, tab);
          if (e.key === 'ArrowRight' || e.keyCode === 39) {
            e.preventDefault();
            tabs[(idx + 1) % tabs.length].focus();
            activateTab(tabs[(idx + 1) % tabs.length]);
          } else if (e.key === 'ArrowLeft' || e.keyCode === 37) {
            e.preventDefault();
            tabs[(idx - 1 + tabs.length) % tabs.length].focus();
            activateTab(tabs[(idx - 1 + tabs.length) % tabs.length]);
          }
        });
      });

      // Activate first tab by default
      if (tabs.length) activateTab(tabs[0]);
    });
  }());


  /* =========================================================
   * 6. Blend Archive Filter
   * ========================================================= */
  (function initBlendFilter() {
    var filterContainer = document.querySelector('.blend-filters');
    if (!filterContainer) return;

    var filterButtons = filterContainer.querySelectorAll('[data-filter]');
    var blendCards    = document.querySelectorAll('.blend-card');

    if (!filterButtons.length || !blendCards.length) return;

    function showCard(card) {
      card.style.opacity  = '0';
      card.style.transform = 'scale(0.95)';
      card.style.display  = '';
      // Force reflow
      void card.offsetWidth;
      card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
      card.style.opacity    = '1';
      card.style.transform  = 'scale(1)';
    }

    function hideCard(card) {
      card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
      card.style.opacity    = '0';
      card.style.transform  = 'scale(0.95)';
      setTimeout(function () {
        card.style.display = 'none';
      }, 300);
    }

    filterButtons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        filterButtons.forEach(function (b) {
          b.classList.remove('is-active');
          b.setAttribute('aria-pressed', 'false');
        });

        btn.classList.add('is-active');
        btn.setAttribute('aria-pressed', 'true');

        var filter = btn.getAttribute('data-filter');

        blendCards.forEach(function (card) {
          if (filter === 'all') {
            showCard(card);
          } else {
            var badge = card.querySelector('.roast-badge');
            var roast = badge ? badge.getAttribute('data-roast') : null;
            if (roast === filter) {
              showCard(card);
            } else {
              hideCard(card);
            }
          }
        });
      });
    });

    // Activate "All" button by default
    var allBtn = filterContainer.querySelector('[data-filter="all"]');
    if (allBtn) {
      allBtn.classList.add('is-active');
      allBtn.setAttribute('aria-pressed', 'true');
    }
  }());


  /* =========================================================
   * 7. FAQ Accordion
   * ========================================================= */
  (function initFaqAccordion() {
    var faqItems = document.querySelectorAll('.faq-item');
    if (!faqItems.length) return;

    faqItems.forEach(function (item) {
      var details = item.querySelector('details');
      var summary = item.querySelector('summary');

      if (!details || !summary) return;

      // Smooth animation using max-height trick on the content
      var content = details.querySelector('.faq-answer') || details.querySelector('p') || null;

      summary.addEventListener('click', function (e) {
        e.preventDefault();

        var isOpen = details.hasAttribute('open');

        // Close all others
        faqItems.forEach(function (otherItem) {
          var otherDetails = otherItem.querySelector('details');
          if (otherDetails && otherDetails !== details && otherDetails.hasAttribute('open')) {
            animateClose(otherDetails);
          }
        });

        if (isOpen) {
          animateClose(details);
        } else {
          animateOpen(details);
        }
      });
    });

    function animateOpen(details) {
      details.setAttribute('open', '');
      var inner = details.querySelector('.faq-answer') || getDetailsContent(details);
      if (inner) {
        inner.style.overflow  = 'hidden';
        inner.style.maxHeight = '0';
        inner.style.transition = 'max-height 0.35s ease';
        void inner.offsetWidth;
        inner.style.maxHeight = inner.scrollHeight + 'px';
        inner.addEventListener('transitionend', function handler() {
          inner.style.maxHeight = '';
          inner.removeEventListener('transitionend', handler);
        });
      }
    }

    function animateClose(details) {
      var inner = details.querySelector('.faq-answer') || getDetailsContent(details);
      if (inner) {
        inner.style.overflow   = 'hidden';
        inner.style.maxHeight  = inner.scrollHeight + 'px';
        inner.style.transition = 'max-height 0.35s ease';
        void inner.offsetWidth;
        inner.style.maxHeight = '0';
        inner.addEventListener('transitionend', function handler() {
          details.removeAttribute('open');
          inner.style.maxHeight = '';
          inner.removeEventListener('transitionend', handler);
        });
      } else {
        details.removeAttribute('open');
      }
    }

    function getDetailsContent(details) {
      // Return the first non-summary child element
      var children = details.children;
      for (var i = 0; i < children.length; i++) {
        if (children[i].tagName.toLowerCase() !== 'summary') {
          return children[i];
        }
      }
      return null;
    }
  }());


  /* =========================================================
   * 8. Scroll Animations (IntersectionObserver)
   * ========================================================= */
  (function initScrollAnimations() {
    if (!('IntersectionObserver' in window)) return;

    var selectors = [
      '[data-animate]',
      '.blend-card',
      '.team-member',
      '.process-step',
      '.testimonial-card',
      '.stat-item'
    ];

    var elements = document.querySelectorAll(selectors.join(', '));
    if (!elements.length) return;

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.12,
      rootMargin: '0px 0px -40px 0px'
    });

    elements.forEach(function (el) {
      observer.observe(el);
    });
  }());


  /* =========================================================
   * 9. Contact Form Validation
   * ========================================================= */
  (function initContactForm() {
    var form = document.querySelector('.contact-form, #contact-form, form.wpcf7-form');
    if (!form) return;

    function showError(field, message) {
      clearError(field);
      var error = document.createElement('span');
      error.className   = 'field-error';
      error.textContent = message;
      error.setAttribute('role', 'alert');
      error.style.color     = '#c0392b';
      error.style.fontSize  = '0.85em';
      error.style.display   = 'block';
      error.style.marginTop = '4px';
      field.parentNode.appendChild(error);
      field.setAttribute('aria-invalid', 'true');
      field.classList.add('has-error');
    }

    function clearError(field) {
      var existing = field.parentNode.querySelector('.field-error');
      if (existing) existing.remove();
      field.removeAttribute('aria-invalid');
      field.classList.remove('has-error');
    }

    function isValidEmail(value) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    function validateField(field) {
      clearError(field);
      var value = field.value.trim();

      if (field.required && !value) {
        showError(field, 'This field is required.');
        return false;
      }

      if (field.type === 'email' && value && !isValidEmail(value)) {
        showError(field, 'Please enter a valid email address.');
        return false;
      }

      return true;
    }

    // Live validation on blur
    form.querySelectorAll('input, textarea, select').forEach(function (field) {
      field.addEventListener('blur', function () {
        validateField(field);
      });
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var fields  = form.querySelectorAll('input, textarea, select');
      var isValid = true;

      fields.forEach(function (field) {
        if (!validateField(field)) isValid = false;
      });

      if (!isValid) return;

      // Show success notice
      var existing = form.querySelector('.form-success');
      if (existing) existing.remove();

      var success = document.createElement('div');
      success.className   = 'form-success';
      success.textContent = 'Thank you! Your message has been sent. We will be in touch shortly.';
      success.setAttribute('role', 'status');
      success.style.padding      = '16px';
      success.style.background   = '#e8f5e9';
      success.style.color        = '#2e7d32';
      success.style.borderRadius = '4px';
      success.style.marginTop    = '16px';

      form.appendChild(success);
      form.reset();
      success.focus();
    });
  }());


  /* =========================================================
   * 10. Testimonials Slider (mobile < 768px)
   * ========================================================= */
  (function initTestimonialSlider() {
    var container = document.querySelector('.testimonials-slider, .testimonials-grid');
    if (!container) return;

    var cards = container.querySelectorAll('.testimonial-card');
    if (cards.length < 2) return;

    // Only activate below 768px
    var MOBILE_BP = 768;
    var sliderActive = false;
    var startX = 0;
    var scrollLeftStart = 0;
    var isDragging = false;
    var dotsWrapper = null;

    function buildSlider() {
      container.style.display        = 'flex';
      container.style.overflowX      = 'scroll';
      container.style.scrollSnapType = 'x mandatory';
      container.style.webkitOverflowScrolling = 'touch';
      container.style.scrollbarWidth = 'none';
      container.style.cursor         = 'grab';

      cards.forEach(function (card) {
        card.style.flex            = '0 0 85%';
        card.style.scrollSnapAlign = 'start';
        card.style.marginRight     = '16px';
      });

      // Build dot indicators
      dotsWrapper = document.createElement('div');
      dotsWrapper.className   = 'slider-dots';
      dotsWrapper.style.textAlign  = 'center';
      dotsWrapper.style.marginTop  = '16px';

      for (var i = 0; i < cards.length; i++) {
        var dot = document.createElement('button');
        dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
        dot.style.display      = 'inline-block';
        dot.style.width        = '10px';
        dot.style.height       = '10px';
        dot.style.borderRadius = '50%';
        dot.style.border       = 'none';
        dot.style.margin       = '0 4px';
        dot.style.padding      = '0';
        dot.style.background   = '#ccc';
        dot.style.cursor       = 'pointer';

        (function (index) {
          dot.addEventListener('click', function () {
            var card = cards[index];
            container.scrollTo({ left: card.offsetLeft, behavior: 'smooth' });
          });
        }(i));

        dotsWrapper.appendChild(dot);
      }

      container.parentNode.insertBefore(dotsWrapper, container.nextSibling);
      updateDots();

      // Touch/drag events
      container.addEventListener('mousedown', onMouseDown);
      container.addEventListener('touchstart', onTouchStart, { passive: true });
      container.addEventListener('scroll', updateDots, { passive: true });

      sliderActive = true;
    }

    function destroySlider() {
      container.style.display        = '';
      container.style.overflowX      = '';
      container.style.scrollSnapType = '';
      container.style.cursor         = '';

      cards.forEach(function (card) {
        card.style.flex            = '';
        card.style.scrollSnapAlign = '';
        card.style.marginRight     = '';
      });

      if (dotsWrapper) {
        dotsWrapper.remove();
        dotsWrapper = null;
      }

      container.removeEventListener('mousedown', onMouseDown);
      container.removeEventListener('touchstart', onTouchStart);
      container.removeEventListener('scroll', updateDots);

      sliderActive = false;
    }

    function updateDots() {
      if (!dotsWrapper) return;
      var dots = dotsWrapper.querySelectorAll('button');
      var scrollLeft = container.scrollLeft;
      var width      = container.offsetWidth;
      var activeIdx  = Math.round(scrollLeft / width);

      dots.forEach(function (dot, i) {
        dot.style.background = i === activeIdx ? '#3d2b1f' : '#ccc';
      });
    }

    // Mouse drag support
    function onMouseDown(e) {
      isDragging = true;
      startX = e.pageX - container.offsetLeft;
      scrollLeftStart = container.scrollLeft;
      container.style.cursor = 'grabbing';
      document.addEventListener('mousemove', onMouseMove);
      document.addEventListener('mouseup', onMouseUp);
    }

    function onMouseMove(e) {
      if (!isDragging) return;
      e.preventDefault();
      var x    = e.pageX - container.offsetLeft;
      var walk = (x - startX) * 1.5;
      container.scrollLeft = scrollLeftStart - walk;
    }

    function onMouseUp() {
      isDragging = false;
      container.style.cursor = 'grab';
      document.removeEventListener('mousemove', onMouseMove);
      document.removeEventListener('mouseup', onMouseUp);
    }

    // Touch swipe
    var touchStartX = 0;
    var touchScrollLeft = 0;

    function onTouchStart(e) {
      touchStartX    = e.touches[0].clientX;
      touchScrollLeft = container.scrollLeft;
      container.addEventListener('touchmove', onTouchMove, { passive: true });
      container.addEventListener('touchend', onTouchEnd);
    }

    function onTouchMove(e) {
      var diff = touchStartX - e.touches[0].clientX;
      container.scrollLeft = touchScrollLeft + diff;
    }

    function onTouchEnd() {
      container.removeEventListener('touchmove', onTouchMove);
      container.removeEventListener('touchend', onTouchEnd);
    }

    function checkBreakpoint() {
      var isMobile = window.innerWidth < MOBILE_BP;
      if (isMobile && !sliderActive) {
        buildSlider();
      } else if (!isMobile && sliderActive) {
        destroySlider();
      }
    }

    checkBreakpoint();

    var resizeTimer;
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(checkBreakpoint, 200);
    });
  }());

}); // end DOMContentLoaded
