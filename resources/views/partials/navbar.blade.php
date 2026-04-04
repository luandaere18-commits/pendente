{{-- ═══════════════════════════════════════
     NAVBAR — Blue & White with Login
     ═══════════════════════════════════════ --}}
<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="scrolled ? 'py-2' : 'py-4'">
    <nav class="container-wide">
        <div class="flex items-center justify-between rounded-2xl px-5 py-3 transition-all duration-300"
             :class="scrolled
                ? 'bg-white/95 backdrop-blur-xl shadow-lg border border-blue-100/60'
                : 'bg-white/70 backdrop-blur-md border border-transparent'">

            {{-- Logo --}}
            <a href="{{ route('site.home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center shadow-sm
                            group-hover:scale-105 transition-transform duration-200">
                    <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL"
                         class="h-7 w-7 object-contain"
                         onerror="this.parentElement.innerHTML='<span class=\'text-white font-black text-sm\'>MC</span>'">
                </div>
                <div class="hidden sm:block leading-tight">
                    <span class="text-base font-bold text-slate-900 block tracking-tight">MC-COMERCIAL</span>
                    <span class="text-[10px] text-brand-600 font-medium uppercase tracking-widest">Formação Profissional</span>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center gap-1">
                @php
                    $links = [
                        ['label' => 'Início',     'route' => 'site.home',     'icon' => 'home'],
                        ['label' => 'Centros',     'route' => 'site.centros',  'icon' => 'map-pin'],
                        ['label' => 'Turmas',      'route' => 'site.cursos',   'icon' => 'graduation-cap'],
                        ['label' => 'Serviços',    'route' => 'site.servicos', 'icon' => 'briefcase'],
                        ['label' => 'Loja',        'route' => 'site.loja',     'icon' => 'shopping-bag'],
                        ['label' => 'Sobre',       'route' => 'site.sobre',    'icon' => 'users'],
                        ['label' => 'Contactos',   'route' => 'site.contactos','icon' => 'mail'],
                    ];
                @endphp
                @foreach($links as $link)
                    <a href="{{ route($link['route']) }}"
                       class="relative px-3.5 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              {{ request()->routeIs($link['route']) || request()->routeIs($link['route'].'.*')
                                 ? 'text-brand-700 bg-brand-50'
                                 : 'text-slate-600 hover:text-brand-700 hover:bg-brand-50/50' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- Desktop CTA + Login --}}
            <div class="hidden lg:flex items-center gap-3">
                <a href="{{ route('login') }}" class="btn-ghost btn-sm">
                    <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                    Entrar
                </a>
                <a href="{{ route('site.contactos') }}" class="btn-primary btn-sm">
                    <i data-lucide="phone" class="w-3.5 h-3.5"></i>
                    Contacte-nos
                </a>
            </div>

            {{-- Mobile Toggle --}}
            <button @click="mobileMenu = !mobileMenu"
                    class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center hover:bg-brand-50 transition-colors"
                    :aria-expanded="mobileMenu"
                    aria-label="Menu">
                <i x-show="!mobileMenu" data-lucide="menu" class="w-5 h-5 text-slate-700"></i>
                <i x-show="mobileMenu" data-lucide="x" class="w-5 h-5 text-slate-700" x-cloak></i>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenu"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.outside="mobileMenu = false"
             class="lg:hidden mt-2 rounded-2xl bg-white/95 backdrop-blur-xl border border-blue-100 shadow-xl p-4 space-y-1"
             x-cloak>
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}"
                   @click="mobileMenu = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs($link['route']) ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:bg-brand-50' }}">
                    <i data-lucide="{{ $link['icon'] }}" class="w-4 h-4"></i>
                    {{ $link['label'] }}
                </a>
            @endforeach
            <div class="pt-3 border-t border-slate-200 space-y-2">
                <a href="{{ route('login') }}" class="btn-secondary w-full justify-center">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Entrar
                </a>
                <a href="{{ route('site.contactos') }}" class="btn-primary w-full justify-center">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                    Contacte-nos
                </a>
            </div>
        </div>
    </nav>
</header>

{{-- Spacer for fixed nav --}}
<div class="h-20"></div>
