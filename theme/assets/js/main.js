/**
 * Winnica Lumen — front-end interactions.
 * Vanilla JS, no build step, no dependencies.
 */
(function () {
  "use strict";

  /* ---------- Sticky / shrinking header ---------- */
  var header = document.querySelector(".site-header");

  function onScroll() {
    if (!header) return;
    header.classList.toggle("is-scrolled", window.scrollY > 12);
  }

  if (header) {
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
  }

  /* ---------- Mobile nav toggle ---------- */
  var navToggle = document.querySelector(".nav-toggle");
  var mainNav = document.querySelector(".main-nav");

  if (navToggle && mainNav) {
    navToggle.addEventListener("click", function () {
      var isOpen = mainNav.classList.toggle("is-open");
      navToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    mainNav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        mainNav.classList.remove("is-open");
        navToggle.setAttribute("aria-expanded", "false");
      });
    });
  }

  /* ---------- Scroll-reveal via IntersectionObserver ---------- */
  var revealTargets = document.querySelectorAll(".reveal");

  if (revealTargets.length) {
    if ("IntersectionObserver" in window) {
      var observer = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              entry.target.classList.add("is-visible");
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.15, rootMargin: "0px 0px -60px 0px" }
      );

      revealTargets.forEach(function (el) {
        observer.observe(el);
      });
    } else {
      // No IntersectionObserver support: show everything immediately.
      revealTargets.forEach(function (el) {
        el.classList.add("is-visible");
      });
    }
  }

  /* ---------- Contact form: progressive-enhancement validation ----------
   * The form still works with plain HTML POST + PHP validation
   * (see inc/contact-form.php) if JavaScript is disabled. This layer
   * only gives faster, friendlier feedback when JS is available.
   */
  var form = document.querySelector("[data-contact-form]");

  if (form) {
    var rules = {
      name: function (v) {
        return v.trim().length >= 2;
      },
      email: function (v) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim());
      },
      message: function (v) {
        return v.trim().length >= 10;
      },
    };

    function setError(field, message) {
      var wrapper = field.closest(".form-field");
      if (!wrapper) return;
      var errorEl = wrapper.querySelector(".form-error");
      if (message) {
        wrapper.classList.add("has-error");
        if (errorEl) errorEl.textContent = message;
      } else {
        wrapper.classList.remove("has-error");
        if (errorEl) errorEl.textContent = "";
      }
    }

    form.addEventListener("submit", function (event) {
      var valid = true;

      Object.keys(rules).forEach(function (name) {
        var field = form.querySelector('[name="' + name + '"]');
        if (!field) return;

        if (!rules[name](field.value)) {
          valid = false;
          setError(field, field.dataset.errorMessage || "To pole wymaga poprawienia.");
        } else {
          setError(field, "");
        }
      });

      // Honeypot: if filled in, silently treat as spam and stop.
      var honeypot = form.querySelector('[name="website_url"]');
      if (honeypot && honeypot.value) {
        valid = false;
      }

      if (!valid) {
        event.preventDefault();
      }
    });
  }
})();
