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
function animateCounter(el) { const target = parseFloat(el.getAttribute('data-counter-value')); const suffix = el.getAttribute('data-counter-suffix') || ''; const duration = 1800; const start = performance.now(); function update(now) { const elapsed = now - start; const progress = Math.min(elapsed / duration, 1); const eased = 1 - Math.pow(1 - progress, 3); const current = Math.round(eased * target); el.textContent = current + suffix; if (progress < 1) requestAnimationFrame(update); } requestAnimationFrame(update); } const grid = document.querySelector('.counter-grid'); if (grid) { const observer = new IntersectionObserver((entries) => { entries.forEach(entry => { if (entry.isIntersecting) { const counters = entry.target.querySelectorAll('[data-counter="true"]'); counters.forEach(animateCounter); observer.unobserve(entry.target); } }); }, { threshold: 0.3 }); observer.observe(grid); }
  

  // 6. Sticky engineering header — desktop/large only (992px and up)
  ScrollTrigger.matchMedia({
    "(min-width: 992px)": function() {
      ScrollTrigger.create({
        trigger: '.engineering-section',
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
  tabLinks.forEach((tab) => {
    tab.addEventListener('mouseenter', () => {
      hoverTimer = setTimeout(() => {
        tab.click();
      }, 150); // 150ms delay — adjust to taste
    });
    tab.addEventListener('mouseleave', () => {
      clearTimeout(hoverTimer);
    });
    tab.addEventListener('click', (e) => {
      e.preventDefault();
    });
  });

  // 10. Lenigraf content layer: preserve the template structure and imagery
  // while replacing its editorial copy with the company's real positioning.
  const setText = (selector, value, index = 0) => {
    const element = document.querySelectorAll(selector)[index];
    if (element) element.textContent = value;
  };

  const navLabels = ['Sobre a Lenigraf', 'Serviços', 'Aplicações', 'Trabalhos', 'Contato'];
  document.querySelectorAll('.nav-menu-item').forEach((item, index) => {
    if (navLabels[index]) item.textContent = navLabels[index];
  });
  document.querySelectorAll('.primary-button').forEach((button) => {
    button.textContent = 'Solicitar orçamento';
  });

  setText('.hero-heading', 'Acabamento que valoriza cada embalagem.');
  setText('.hero-description', 'Há mais de 30 anos, a LENIGRAF transforma projetos gráficos em embalagens prontas para impressionar, com precisão, agilidade e acabamento premium.');
  setText('.animation-text', 'Uma boa embalagem começa no acabamento. A LENIGRAF entrega cuidado, precisão e experiência para transformar cada projeto em um produto que comunica qualidade.');

  setText('.tabs-title', 'Soluções de acabamento para produtos que merecem destaque.');
  const tabTitles = ['01 Colagem de acetato', '02 Fechamento de cartuchos', '03 Acabamento premium', '04 Atendimento personalizado'];
  const tabDescriptions = [
    'Aplicação precisa de acetato em embalagens, com transparência, proteção e acabamento impecável.',
    'Fechamento e montagem de cartuchos com precisão, cuidado e padrão consistente em cada lote.',
    'Soluções completas para elevar a apresentação de produtos alimentícios, cosméticos e industriais.',
    'Uma equipe próxima para entender sua necessidade e entregar com agilidade, qualidade e segurança.'
  ];
  document.querySelectorAll('.heading-style-h4').forEach((item, index) => { if (tabTitles[index]) item.textContent = tabTitles[index]; });
  document.querySelectorAll('.faq-desc').forEach((item, index) => { if (tabDescriptions[index]) item.textContent = tabDescriptions[index]; });

  setText('.slider-heading', 'Acabamento gráfico para todos os tipos de produto.');
  setText('.slider-description', 'Da colagem de acetato ao fechamento de cartuchos, a LENIGRAF oferece soluções confiáveis para diferentes segmentos e necessidades de produção.');
  const serviceTitles = ['Embalagens personalizadas', 'Produtos farmacêuticos e cosméticos', 'Embalagens premium', 'Produtos industriais'];
  const serviceDescriptions = [
    'Embalagens com acabamento premium para produtos alimentícios, com proteção e apresentação impecável.',
    'Cuidado e precisão para produtos de higiene, beleza e farmacêuticos, mantendo o padrão de cada marca.',
    'Acabamento especializado para cosméticos e produtos de cuidados pessoais que pedem uma apresentação diferenciada.',
    'Soluções resistentes para produtos industriais e técnicos, com atenção aos detalhes e à durabilidade.'
  ];
  document.querySelectorAll('.slider-card-title').forEach((item, index) => { if (serviceTitles[index]) item.textContent = serviceTitles[index]; });
  document.querySelectorAll('.slider-card-desc').forEach((item, index) => { if (serviceDescriptions[index]) item.textContent = serviceDescriptions[index]; });

  setText('.cta-heading', 'Pronto para valorizar o seu produto?');
  setText('.cta-description', 'Fale com a LENIGRAF e descubra como um acabamento preciso pode transformar a apresentação da sua embalagem. Solicite um orçamento.');
  setText('.footer-tagline', 'Acabamentos gráficos desde 1994');
  setText('.footer-copyright', '© 2026 LENIGRAF SERVIÇOS DE ACABAMENTOS GRÁFICOS LTDA. Todos os direitos reservados.');

}); // ← this was missing — closes DOMContentLoaded
