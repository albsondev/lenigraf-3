!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);

document.addEventListener('DOMContentLoaded', () => {

  // 1. Register plugins
  gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

  // 2. ScrollSmoother
  const smoother = ScrollSmoother.create({
    wrapper: '#smooth-wrapper',
    content: '#smooth-content',
    smooth: 1.5,
    effects: true,
    normalizeScroll: true,
    smoothTouch: 0.1,
  });

  // 3. Swiper — marine engineering slider
  const engineeringSwiper = new Swiper('.marine-engineering', {
    slidesPerView: 1,
    spaceBetween: 24,
    navigation: {
      nextEl: '.slider-nav-next',
      prevEl: '.slider-nav-prev',
    },
    breakpoints: {
      1920: { slidesPerView: 3.3 },
      1440: { slidesPerView: 3 },
      991:  { slidesPerView: 2.6 },
      768:  { slidesPerView: 2 },
    },
  });

  // 4. Scroll-driven text color reveal
  const container = document.getElementById('animated-text');
  if (container) {
    const text = container.textContent.trim();
    container.innerHTML = '';
    text.split(' ').forEach((word, i, arr) => {
      const span = document.createElement('span');
      span.className = 'word';
      span.textContent = word + (i < arr.length - 1 ? ' ' : '');
      container.appendChild(span);
    });
    const wordEls = [...container.querySelectorAll('.word')];
    gsap.set(wordEls, { color: '#d0d0d0' });
    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: '#statement',
        start: 'top 40%',
        end: 'top 0%',
        scrub: 0.5,
      },
    });
    wordEls.forEach((w) => {
      tl.to(w, { color: '#111111', duration: 1, ease: 'none' }, '<0.2');
    });
  }

  

  // 5. Counter animation
  function animateCounter(element) {
    const target = Number.parseFloat(element.dataset.counterValue);
    const suffix = element.dataset.counterSuffix ?? '';
    const duration = 1800;
    const start = performance.now();

    function update(now) {
      const progress = Math.min((now - start) / duration, 1);
      const easedProgress = 1 - (1 - progress) ** 3;
      element.textContent = `${Math.round(easedProgress * target)}${suffix}`;

      if (progress < 1) requestAnimationFrame(update);
    }

    requestAnimationFrame(update);
  }

  const counterGrid = document.querySelector('.counter-grid');
  if (counterGrid) {
    const counterObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        entry.target
          .querySelectorAll('[data-counter="true"]')
          .forEach(animateCounter);
        counterObserver.unobserve(entry.target);
      });
    }, { threshold: 0.3 });

    counterObserver.observe(counterGrid);
  }
  

  // 6. Sticky engineering header — desktop/large only (992px and up)
  ScrollTrigger.matchMedia({
    "(min-width: 992px)": function() {
      ScrollTrigger.create({
        trigger: '.engineering-area',
        start: 'top top',
        end: 'bottom bottom',
        pin: '.engineering-header',
        pinSpacing: false,
        invalidateOnRefresh: true,
      });
    }
  });

  // 7. Refresh ScrollTrigger as lazy-loaded images come in
  const lazyImages = document.querySelectorAll('img[loading="lazy"]');
  lazyImages.forEach((img) => {
    if (img.complete) return;
    img.addEventListener('load', () => ScrollTrigger.refresh());
  });

  // 8. Final refresh once all assets + fonts are ready
  window.addEventListener('load', () => {
    ScrollTrigger.refresh();
  });
  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(() => ScrollTrigger.refresh());
  }

  // 9. Tab hover (no nested DOMContentLoaded needed)
  const tabLinks = document.querySelectorAll('.auto-tabs-menu .w-tab-link');
  let hoverTimer;
  const tabPanes = document.querySelectorAll('.auto-tabs-content-item');

  function activateTab(tab) {
    const tabName = tab.dataset.wTab;
    tabLinks.forEach((link) => link.classList.toggle('w--current', link === tab));
    tabPanes.forEach((pane) => {
      const isActive = pane.dataset.wTab === tabName;
      pane.classList.toggle('w--tab-active', isActive);
      pane.hidden = !isActive;
    });
  }

  tabLinks.forEach((tab) => {
    tab.addEventListener('mouseenter', () => {
      hoverTimer = setTimeout(() => {
        activateTab(tab);
      }, 150); // 150ms delay — adjust to taste
    });
    tab.addEventListener('mouseleave', () => {
      clearTimeout(hoverTimer);
    });
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      activateTab(tab);
    });
  });

  const initialTab = document.querySelector('.auto-tabs-menu .w--current') ?? tabLinks[0];
  if (initialTab) activateTab(initialTab);

  // Mobile navigation
  const navigation = document.querySelector('.navbar');
  const navigationButton = document.querySelector('.mobile-menu');
  const navigationMenu = document.querySelector('.nav-menu-warapper');
  if (navigation && navigationButton && navigationMenu) {
    navigationButton.setAttribute('aria-expanded', 'false');
    navigationButton.addEventListener('click', () => {
      const isOpen = navigation.classList.toggle('is-open');
      navigationButton.setAttribute('aria-expanded', String(isOpen));
      navigationMenu.classList.toggle('is-open', isOpen);
    });
    navigationMenu.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => {
        navigation.classList.remove('is-open');
        navigationMenu.classList.remove('is-open');
        navigationButton.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // Native form feedback
  document.querySelectorAll('.cta-form form').forEach((form) => {
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      const successMessage = form.parentElement.querySelector('.success-message');
      if (successMessage) successMessage.classList.add('is-visible');
      form.reset();
    });
  });

}); // ← this was missing — closes DOMContentLoaded
