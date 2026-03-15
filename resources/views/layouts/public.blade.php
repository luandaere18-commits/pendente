<!DOCTYPE html>
<html lang="pt-AO" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MC-COMERCIAL - Centro de Formação Profissional em Angola. Cursos, Produtos e Serviços.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MC-COMERCIAL - Centro de Formação')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind (via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    @stack('styles')
</head>
<body
    class="bg-background text-foreground min-h-screen flex flex-col antialiased"
    x-data="{
        mobileMenu: false,
        scrolled: false,
        showScrollTop: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 50;
                this.showScrollTop = window.scrollY > 400;
            }, { passive: true });
        }
    }"
>
    @include('partials.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp')
    @include('partials.pre-inscricao-modal')

    {{-- Toast container --}}
    <div id="toast-container" class="fixed top-4 right-4 z-[200] space-y-2 pointer-events-none"></div>

    {{-- Scroll to top --}}
    <button
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        x-show="showScrollTop"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-24 right-6 z-50 w-11 h-11 rounded-full bg-primary text-primary-foreground flex items-center justify-center shadow-lg hover:bg-primary/90 hover:scale-110 transition-all duration-200"
        aria-label="Voltar ao topo"
    >
        <i data-lucide="chevron-up" class="w-5 h-5"></i>
    </button>

    <script>
        lucide.createIcons();

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const colors = { success: 'bg-green-600', error: 'bg-red-600', info: 'bg-blue-600', warning: 'bg-amber-500' };
            toast.className = `${colors[type] || colors.success} text-white px-5 py-3 rounded-xl shadow-xl text-sm flex items-center gap-2 pointer-events-auto animate-slide-in`;
            const icons = { success: '✓', error: '✕', info: 'ℹ', warning: '⚠' };
            toast.innerHTML = `<span class="font-bold">${icons[type] || '✓'}</span> ${message}`;
            container.appendChild(toast);
            setTimeout(() => { toast.classList.add('animate-fade-out'); setTimeout(() => toast.remove(), 300); }, 4000);
        }

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) { entry.target.classList.add('revealed'); revealObserver.unobserve(entry.target); }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -50px 0px' });

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
            lucide.createIcons();
        });
    </script>

    @stack('scripts')
</body>
</html>
