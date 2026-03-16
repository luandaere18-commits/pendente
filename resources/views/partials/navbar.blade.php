{{-- Navegação principal — glass effect --}}
<nav class="sticky top-0 z-50 transition-all duration-500"
     :class="scrolled
        ? 'bg-card/90 backdrop-blur-xl shadow-lg border-b border-border/50'
        : 'bg-card/70 backdrop-blur-md border-b border-transparent'">
    <div class="container mx-auto flex items-center justify-between px-4 py-3">

        {{-- Logo --}}
        <a href="{{ route('site.home') }}" class="flex items-center gap-3 hover:opacity-90 transition-opacity group">
            <div class="w-11 h-11 rounded-xl bg-white border border-border/60 flex items-center justify-center shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all duration-300"
                 style="box-shadow: var(--shadow-sm);">
                <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL Logo" class="h-8 w-8 object-contain" loading="eager"
                     onerror="this.parentElement.innerHTML='<span class=\'text-primary font-black text-sm\'>MC</span>'">
            </div>
            <div class="hidden sm:block">
                <span class="text-lg font-extrabold text-foreground leading-none block tracking-tight">MC-COMERCIAL</span>
                <span class="text-[10px] text-muted-foreground font-medium uppercase tracking-[0.2em]">Centro de Formação</span>
            </div>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden lg:flex items-center gap-0.5">
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
                   class="relative px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-300 group
                          {{ $isActive ? 'text-primary bg-primary/5' : 'text-muted-foreground hover:text-foreground hover:bg-muted/50' }}">
                    {{ $link['label'] }}
                    <span class="absolute bottom-0 left-3.5 right-3.5 h-0.5 rounded-full transition-all duration-400
                                 {{ $isActive
                                    ? 'opacity-100 scale-x-100 bg-accent'
                                    : 'opacity-0 scale-x-0 bg-accent group-hover:opacity-50 group-hover:scale-x-100' }}"
                          style="transform-origin: left;">
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Login CTA + Mobile Toggle --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}"
               class="hidden lg:inline-flex btn-primary h-10 px-5 text-sm rounded-xl"
               style="box-shadow: var(--shadow-primary);">
                <i data-lucide="log-in" class="w-4 h-4 mr-1.5"></i>
                Entrar
            </a>

            {{-- Mobile Toggle --}}
            <button class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center hover:bg-muted transition-all duration-200"
                    @click="mobileMenu = !mobileMenu" aria-label="Menu">
                <i x-show="!mobileMenu" data-lucide="menu" class="w-5 h-5"></i>
                <i x-show="mobileMenu" data-lucide="x" class="w-5 h-5" style="display:none"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenu"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden border-t border-border bg-card/98 backdrop-blur-xl px-4 py-5"
         style="display:none">
        <div class="space-y-1">
            @foreach($navLinks as $link)
                @php $isActive = request()->routeIs($link['route']); @endphp
                <a href="{{ route($link['route']) }}"
                   @click="mobileMenu = false"
                   class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-medium transition-all duration-200
                          {{ $isActive ? 'bg-primary/8 text-primary' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                    <div class="w-8 h-8 rounded-lg {{ $isActive ? 'bg-primary/10' : 'bg-muted' }} flex items-center justify-center">
                        <i data-lucide="{{ $link['icon'] }}" class="w-4 h-4 shrink-0"></i>
                    </div>
                    {{ $link['label'] }}
                    @if($isActive)
                        <span class="ml-auto w-2 h-2 rounded-full bg-accent"></span>
                    @endif
                </a>
            @endforeach
        </div>
        <div class="mt-5 pt-5 border-t border-border">
            <a href="{{ route('login') }}"
               class="flex items-center justify-center gap-2 btn-primary w-full h-12 rounded-xl text-sm">
                <i data-lucide="log-in" class="w-4 h-4"></i>Entrar
            </a>
        </div>
    </div>
</nav>
