<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MC-COMERCIAL - Centro de Formação Profissional em Angola. Cursos, Produtos e Serviços.">
    <title>@yield('title', 'MC-COMERCIAL - Centro de Formação')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind (via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    @stack('styles')
</head>
<body class="bg-background text-foreground min-h-screen flex flex-col" x-data="{ mobileMenu: false }">

    @include('partials.topbar')
    @include('partials.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp')
    @include('partials.pre-inscricao-modal')

    {{-- Toast notifications --}}
    <div id="toast-container" class="fixed top-4 right-4 z-[100] space-y-2"></div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Simple toast function
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600';
            toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg text-sm animate-fade-in`;
            toast.textContent = message;
            container.appendChild(toast);
            setTimeout(() => { toast.remove(); }, 4000);
        }
    </script>

    @stack('scripts')
</body>
</html>
