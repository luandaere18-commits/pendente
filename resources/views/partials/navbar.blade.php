{{-- Navegação principal --}}
<nav class="sticky top-0 z-50 transition-all duration-300 bg-card shadow-sm" x-data="{ scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
     :class="{ 'shadow-lg': scrolled, 'shadow-sm': !scrolled }">
    <div class="container mx-auto flex items-center justify-between px-4 py-3">
        {{-- Logo --}}
        <a href="{{ route('site.home') }}" class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center">
                <i data-lucide="graduation-cap" class="w-6 h-6 text-primary-foreground"></i>
            </div>
            <span class="text-xl font-bold text-foreground">MC-COMERCIAL</span>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden lg:flex items-center gap-1">
            @php
                $navLinks = [
                    ['label' => 'Home', 'route' => 'site.home'],
                    ['label' => 'Centros', 'route' => 'site.centros'],
                    ['label' => 'Cursos', 'route' => 'site.cursos'],
                    ['label' => 'Serviços', 'route' => 'site.servicos'],
                    ['label' => 'Loja', 'route' => 'site.loja'],
                    ['label' => 'Sobre Nós', 'route' => 'site.sobre'],
                    ['label' => 'Contactos', 'route' => 'site.contactos'],
                ];
            @endphp
            @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs($link['route']) ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:text-foreground hover:bg-muted' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="hidden lg:block">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground h-9 px-4 hover:bg-primary/90 transition-colors">
                Login
            </a>
        </div>

        {{-- Mobile Toggle --}}
        <button class="lg:hidden p-2" @click="mobileMenu = !mobileMenu">
            <i x-show="!mobileMenu" data-lucide="menu" class="w-6 h-6"></i>
            <i x-show="mobileMenu" data-lucide="x" class="w-6 h-6" style="display:none"></i>
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenu" x-transition class="lg:hidden border-t bg-card px-4 pb-4 space-y-1" style="display:none">
        @foreach($navLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs($link['route']) ? 'bg-primary/10 text-primary' : 'text-muted-foreground' }}">
                {{ $link['label'] }}
            </a>
        @endforeach
        <a href="{{ route('login') }}" class="block w-full text-center rounded-md text-sm font-medium bg-primary text-primary-foreground h-9 leading-9 mt-2 hover:bg-primary/90">
            Login
        </a>
    </div>
</nav>
