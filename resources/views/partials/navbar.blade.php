{{-- Navegação principal --}}
<nav class="sticky top-0 z-50 transition-all duration-300 bg-card/95 backdrop-blur-md border-b border-border/50"
     :class="scrolled ? 'shadow-lg' : 'shadow-sm'">
    <div class="container mx-auto flex items-center justify-between px-4 py-3">

        {{-- Logo --}}
        <a href="{{ route('site.home') }}" class="flex items-center gap-2.5 hover:opacity-90 transition-opacity group">
            <div class="w-10 h-10 rounded-xl bg-white border border-border/60 flex items-center justify-center shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all duration-200">
                <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL Logo" class="h-8 w-8 object-contain" loading="eager"
                     onerror="this.parentElement.innerHTML='<span class=\'text-primary font-black text-sm\'>MC</span>'">
            </div>
            <div class="hidden sm:block">
                <span class="text-lg font-extrabold text-foreground leading-none block">MC-COMERCIAL</span>
                <span class="text-[10px] text-muted-foreground font-medium uppercase tracking-widest">Centro de Formação</span>
            </div>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden lg:flex items-center gap-1">
            @php
                $navLinks = [
                    ['label' => 'Home',       'route' => 'site.home',      'icon' => 'home'],
                    ['label' => 'Centros',    'route' => 'site.centros',   'icon' => 'building-2'],
                    ['label' => 'Turmas',     'route' => 'site.cursos',    'icon' => 'book-open'],
                    ['label' => 'Serviços',   'route' => 'site.servicos',  'icon' => 'briefcase'],
                    ['label' => 'Loja',       'route' => 'site.loja',      'icon' => 'shopping-bag'],
                    ['label' => 'Sobre Nós',  'route' => 'site.sobre',     'icon' => 'users'],
                    ['label' => 'Contactos',  'route' => 'site.contactos', 'icon' => 'mail'],
                ];
            @endphp
            @foreach($navLinks as $link)
                @php $isActive = request()->routeIs($link['route']); @endphp
                <a href="{{ route($link['route']) }}"
                   class="relative px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 group
                          {{ $isActive ? 'text-primary' : 'text-muted-foreground hover:text-foreground' }}">
                    {{ $link['label'] }}
                    <span class="absolute bottom-0.5 left-3 right-3 h-0.5 rounded-full bg-primary transition-all duration-300
                                 {{ $isActive ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-0 group-hover:opacity-60 group-hover:scale-x-100' }}">
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Login CTA + Mobile Toggle --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('login') }}"
               class="hidden lg:inline-flex items-center justify-center rounded-lg text-sm font-semibold bg-primary text-primary-foreground h-9 px-5 hover:bg-primary/90 active:scale-95 transition-all duration-200 shadow-sm hover:shadow-md">
                <i data-lucide="log-in" class="w-4 h-4 mr-1.5"></i>
                Entrar
            </a>
            <button class="lg:hidden p-2 rounded-lg hover:bg-muted transition-colors" @click="mobileMenu = !mobileMenu" aria-label="Menu">
                <i x-show="!mobileMenu" data-lucide="menu" class="w-5 h-5"></i>
                <i x-show="mobileMenu" x-cloak data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenu"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden border-t border-border bg-card/98 backdrop-blur-md px-4 py-4"
         x-cloak>
        <div class="space-y-1">
            @foreach($navLinks as $link)
                @php $isActive = request()->routeIs($link['route']); @endphp
                <a href="{{ route($link['route']) }}"
                   @click="mobileMenu = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200
                          {{ $isActive ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                    <i data-lucide="{{ $link['icon'] }}" class="w-4 h-4 shrink-0"></i>
                    {{ $link['label'] }}
                    @if($isActive)
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-primary"></span>
                    @endif
                </a>
            @endforeach
        </div>
        <div class="mt-4 pt-4 border-t border-border">
            <a href="{{ route('login') }}"
               class="flex items-center justify-center gap-2 rounded-xl text-sm font-semibold bg-primary text-primary-foreground h-11 hover:bg-primary/90 transition-colors">
                <i data-lucide="log-in" class="w-4 h-4"></i>Entrar
            </a>
        </div>
    </div>
</nav>
