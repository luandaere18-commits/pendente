<!DOCTYPE html>
<html lang="pt-AO" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'MC-COMERCIAL — Centro de Formação Profissional em Angola. Cursos certificados, formação de qualidade.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MC-COMERCIAL — Centro de Formação Profissional')</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    @stack('head')

    <style>
        /* Subtle geometric squares pattern on all public pages */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                url("data:image/svg+xml,%3Csvg width='80' height='80' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='10' y='10' width='25' height='25' rx='3' fill='none' stroke='rgba(30,64,175,0.04)' stroke-width='1'/%3E%3Crect x='50' y='45' width='15' height='15' rx='2' fill='rgba(30,64,175,0.02)'/%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0v60M0 30h60' stroke='rgba(30,64,175,0.02)' stroke-width='0.5'/%3E%3C/svg%3E");
            opacity: 0.7;
        }
        body > * { position: relative; z-index: 1; }

        [x-cloak] { display: none !important; }
        h1, h2, h3, .font-heading { font-family: 'Sora', 'Inter', system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased"
      x-data="{
          mobileMenu: false,
          scrolled: false,
          showScrollTop: false,
          init() {
              const onScroll = () => {
                  this.scrolled = window.scrollY > 40;
                  this.showScrollTop = window.scrollY > 600;
              };
              window.addEventListener('scroll', onScroll, { passive: true });
              onScroll();

              // Scroll reveal — observe all .reveal, .reveal-left, .reveal-right, .reveal-scale
              const revealClasses = ['.reveal', '.reveal-left', '.reveal-right', '.reveal-scale'];
              const obs = new IntersectionObserver((entries) => {
                  entries.forEach(e => {
                      if (e.isIntersecting) { e.target.classList.add('revealed'); obs.unobserve(e.target); }
                  });
              }, { threshold: 0.06, rootMargin: '0px 0px -60px 0px' });

              const observeAll = () => {
                  revealClasses.forEach(cls => {
                      document.querySelectorAll(cls + ':not(.revealed)').forEach(el => obs.observe(el));
                  });
              };
              observeAll();
              this.$nextTick(() => observeAll());
          }
      }"
      x-cloak
>
    @include('partials.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp')
    @include('partials.pre-inscricao-modal')

    {{-- Toast Container --}}
    <div id="toast-container" class="fixed top-5 right-5 z-[200] space-y-3 pointer-events-none"></div>

    {{-- Scroll to Top --}}
    <button
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        x-show="showScrollTop"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 translate-y-3"
        class="fixed bottom-28 right-6 z-50 w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-600 to-brand-700 text-white flex items-center justify-center shadow-xl hover:shadow-2xl hover:scale-110 transition-all duration-300 group"
        aria-label="Voltar ao topo"
    >
        <i data-lucide="arrow-up" class="w-5 h-5 group-hover:-translate-y-0.5 transition-transform"></i>
    </button>

    {{-- Toast JS --}}
    <script>
    function showToast(msg, type = 'success') {
        const c = document.getElementById('toast-container');
        const t = document.createElement('div');
        const colors = { success: 'bg-emerald-600', error: 'bg-red-600', info: 'bg-blue-600' };
        const icons = { success: 'check-circle-2', error: 'alert-circle', info: 'info' };
        t.className = `pointer-events-auto flex items-center gap-3 px-5 py-4 rounded-2xl text-sm font-medium text-white shadow-2xl ${colors[type] || colors.info} animate-fade-up backdrop-blur-sm`;
        t.innerHTML = `<i data-lucide="${icons[type]}" class="w-5 h-5 shrink-0"></i><span>${msg}</span>`;
        c.appendChild(t);
        lucide.createIcons({ nodes: [t] });
        setTimeout(() => { t.style.opacity='0'; t.style.transform='translateX(16px)'; t.style.transition='all .4s'; setTimeout(() => t.remove(), 400); }, 4000);
    }
    </script>

    {{-- Init Lucide --}}
    <script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>

    {{-- Counter Animation --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const counters = document.querySelectorAll('[data-counter]');
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    const el = e.target;
                    const target = parseInt(el.dataset.counter);
                    const duration = 2000;
                    const start = performance.now();
                    const step = (now) => {
                        const progress = Math.min((now - start) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        el.textContent = Math.floor(eased * target);
                        if (progress < 1) requestAnimationFrame(step);
                        else el.textContent = target;
                    };
                    requestAnimationFrame(step);
                    obs.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(c => obs.observe(c));
    });
    </script>

    @stack('scripts')
</body>
</html>
