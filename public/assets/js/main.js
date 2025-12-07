/**
* Template Name: TheEvent
* Template URL: https://bootstrapmade.com/theevent-conference-event-bootstrap-template/
* Updated: Aug 07 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle - Improved and Fixed
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');
  const mobileNavCloseBtn = document.querySelector('.mobile-nav-close');
  const navmenu = document.querySelector('#navmenu');
  const navmenuUl = navmenu ? navmenu.querySelector('ul') : null;
  const body = document.querySelector('body');

  function mobileNavToogle() {
    if (!body || !navmenuUl) return;
    
    const isActive = body.classList.contains('mobile-nav-active');
    
    if (isActive) {
      // Close menu
      body.classList.remove('mobile-nav-active');
      navmenuUl.classList.remove('mobile-nav-active');
      if (mobileNavToggleBtn) {
        mobileNavToggleBtn.classList.remove('bi-x');
        mobileNavToggleBtn.classList.add('bi-list');
      }
    } else {
      // Open menu
      body.classList.add('mobile-nav-active');
      navmenuUl.classList.add('mobile-nav-active');
      if (mobileNavToggleBtn) {
        mobileNavToggleBtn.classList.remove('bi-list');
        mobileNavToggleBtn.classList.add('bi-x');
      }
    }
  }

  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      mobileNavToogle();
    });
  }

  // Close button handler
  if (mobileNavCloseBtn) {
    mobileNavCloseBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      if (body && body.classList.contains('mobile-nav-active')) {
        mobileNavToogle();
      }
    });
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  if (navmenu) {
    navmenu.querySelectorAll('a').forEach(navmenuLink => {
      navmenuLink.addEventListener('click', () => {
        if (body && body.classList.contains('mobile-nav-active')) {
          mobileNavToogle();
        }
      });
    });
  }

  /**
   * Close mobile nav when clicking on overlay
   */
  if (navmenu && navmenuUl) {
    // Close when clicking on the overlay (navmenu background, not the ul)
    navmenu.addEventListener('click', (e) => {
      if (body && body.classList.contains('mobile-nav-active')) {
        // Check if click is on navmenu but not on ul or its children
        if (e.target === navmenu || (!navmenuUl.contains(e.target) && e.target !== navmenuUl)) {
          mobileNavToogle();
        }
      }
    });
    
    // Prevent closing when clicking inside the menu
    navmenuUl.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }

  /**
   * Close mobile nav on window resize (if resized to desktop)
   */
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      if (window.innerWidth > 1199) {
        if (body && body.classList.contains('mobile-nav-active')) {
          if (navmenuUl && navmenuUl.classList.contains('mobile-nav-active')) {
            mobileNavToogle();
          }
        }
      }
    }, 250);
  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener('load', function(e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: 'smooth'
          });
        }, 100);
      }
    }
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navmenuScrollspy);
  document.addEventListener('scroll', navmenuScrollspy);

  /**
   * Animate on Scroll - Modern Intersection Observer
   */
  const animateOnScroll = () => {
    const elements = document.querySelectorAll('.animate-on-scroll, .section-title, .speakers .member, .buy-tickets .pricing-item, .hotels .card, .venue .venue-gallery, .schedule .schedule-item');
    
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animated');
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    elements.forEach(element => {
      observer.observe(element);
    });
  };

  // Initialize animations on load
  window.addEventListener('load', animateOnScroll);
  document.addEventListener('DOMContentLoaded', animateOnScroll);

  /**
   * Add stagger animation delays to elements
   */
  const addStaggerAnimation = () => {
    // Speakers
    const members = document.querySelectorAll('.speakers .member');
    members.forEach((member, index) => {
      member.style.animationDelay = `${index * 0.1}s`;
    });

    // Pricing items
    const pricingItems = document.querySelectorAll('.buy-tickets .pricing-item');
    pricingItems.forEach((item, index) => {
      item.style.animationDelay = `${index * 0.2 + 0.1}s`;
    });

    // Hotel cards
    const hotelCards = document.querySelectorAll('.hotels .card');
    hotelCards.forEach((card, index) => {
      card.style.animationDelay = `${index * 0.15}s`;
    });

    // Schedule items
    const scheduleItems = document.querySelectorAll('.schedule .schedule-item');
    scheduleItems.forEach((item, index) => {
      item.style.animationDelay = `${index * 0.1}s`;
    });

    // Gallery items
    const galleryItems = document.querySelectorAll('.venue .venue-gallery');
    galleryItems.forEach((item, index) => {
      item.style.animationDelay = `${index * 0.1}s`;
    });
  };

  window.addEventListener('load', addStaggerAnimation);
  document.addEventListener('DOMContentLoaded', addStaggerAnimation);

})();