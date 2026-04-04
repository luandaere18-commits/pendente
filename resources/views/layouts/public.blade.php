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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    @stack('head')
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

              // Scroll reveal
              const obs = new IntersectionObserver((entries) => {
                  entries.forEach(e => {
                      if (e.isIntersecting) { e.target.classList.add('revealed'); obs.unobserve(e.target); }
                  });
              }, { threshold: 0.06, rootMargin: '0px 0px -60px 0px' });
              document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
              this.$nextTick(() => document.querySelectorAll('.reveal:not(.revealed)').forEach(el => obs.observe(el)));
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

    {{-- Toast --}}
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
        class="fixed bottom-28 right-6 z-50 w-11 h-11 rounded-xl bg-brand-700 text-white flex items-center justify-center shadow-lg hover:bg-brand-800 hover:scale-110 transition-all duration-200"
        aria-label="Voltar ao topo"
    >
        <i data-lucide="arrow-up" class="w-4 h-4"></i>
    </button>

    {{-- Toast JS --}}
    <script>
    function showToast(msg, type = 'success') {
        const c = document.getElementById('toast-container');
        const t = document.createElement('div');
        const colors = { success: 'bg-emerald-600', error: 'bg-red-600', info: 'bg-blue-600' };
        const icons = { success: 'check-circle-2', error: 'alert-circle', info: 'info' };
        t.className = `pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-white shadow-lg ${colors[type] || colors.info} animate-fade-up`;
        t.innerHTML = `<i data-lucide="${icons[type]}" class="w-4 h-4 shrink-0"></i><span>${msg}</span>`;
        c.appendChild(t);
        lucide.createIcons({ nodes: [t] });
        setTimeout(() => { t.style.opacity='0'; t.style.transform='translateX(16px)'; t.style.transition='all .3s'; setTimeout(() => t.remove(), 300); }, 4000);
    }
    </script>

    {{-- Init Lucide --}}
    <script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>

    @stack('scripts')
</body>
</html>
