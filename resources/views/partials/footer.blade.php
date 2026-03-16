{{-- Rodapé --}}
<footer class="bg-footer text-footer-foreground pt-16 pb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 pointer-events-none">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-primary blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

            {{-- Col 1 - Sobre --}}
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center p-1.5 shadow-md">
                        <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL" class="h-full w-full object-contain"
                             onerror="this.parentElement.innerHTML='<span class=\'text-primary font-black text-base\'>MC</span>'">
                    </div>
                    <div>
                        <span class="text-base font-extrabold text-white block leading-tight">MC-COMERCIAL</span>
                        <span class="text-[10px] opacity-60 uppercase tracking-widest">Centro de Formação</span>
                    </div>
                </div>
                <p class="text-sm opacity-60 mb-6 leading-relaxed">
                    Centro de formação de qualidade com mais de 10 anos de experiência na preparação de profissionais qualificados para o mercado de trabalho angolano.
                </p>
                <div class="flex gap-2">
                    @foreach([
                        ['icon' => 'facebook',  'href' => '#'],
                        ['icon' => 'instagram', 'href' => '#'],
                        ['icon' => 'linkedin',  'href' => '#'],
                        ['icon' => 'youtube',   'href' => '#'],
                    ] as $social)
                        <a href="{{ $social['href'] }}"
                           class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-accent hover:scale-110 transition-all duration-200"
                           aria-label="{{ ucfirst($social['icon']) }}">
                            <i data-lucide="{{ $social['icon'] }}" class="w-4 h-4"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Col 2 - Links --}}
            <div>
                <h4 class="font-bold text-white mb-5 flex items-center gap-2">
                    <span class="w-1 h-4 bg-accent rounded-full"></span>
                    Links Rápidos
                </h4>
                <ul class="space-y-2.5 text-sm">
                    @php
                        $footerLinks = [
                            ['label' => 'Home',      'route' => 'site.home'],
                            ['label' => 'Centros',   'route' => 'site.centros'],
                            ['label' => 'Turmas',    'route' => 'site.cursos'],
                            ['label' => 'Serviços',  'route' => 'site.servicos'],
                            ['label' => 'Loja',      'route' => 'site.loja'],
                            ['label' => 'Sobre Nós', 'route' => 'site.sobre'],
                            ['label' => 'Contactos', 'route' => 'site.contactos'],
                        ];
                    @endphp
                    @foreach($footerLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}"
                               class="flex items-center gap-1.5 opacity-60 hover:opacity-100 hover:text-accent hover:translate-x-1 transition-all duration-200">
                                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 3 - Contactos --}}
            <div>
                <h4 class="font-bold text-white mb-5 flex items-center gap-2">
                    <span class="w-1 h-4 bg-accent rounded-full"></span>
                    Contactos
                </h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-accent/20 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-accent"></i>
                        </div>
                        <div>
                            <a href="tel:+244929643510" class="block opacity-70 hover:opacity-100 hover:text-accent transition-colors">+244 929-643-510</a>
                            <a href="tel:+244928966002" class="block opacity-70 hover:opacity-100 hover:text-accent transition-colors">+244 928-966-002</a>
                        </div>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-accent/20 flex items-center justify-center shrink-0">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-accent"></i>
                        </div>
                        <a href="mailto:mucuanha.chineva@gmail.com" class="opacity-70 hover:opacity-100 hover:text-accent transition-colors break-all">
                            mucuanha.chineva@gmail.com
                        </a>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-accent/20 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-accent"></i>
                        </div>
                        <span class="opacity-70 leading-relaxed">Rua A, Bairro 1º de Maio Nº 05, 1º Andar, Luanda-Viana</span>
                    </li>
                </ul>
            </div>

            {{-- Col 4 - Horário --}}
            <div>
                <h4 class="font-bold text-white mb-5 flex items-center gap-2">
                    <span class="w-1 h-4 bg-accent rounded-full"></span>
                    Horário
                </h4>
                <ul class="space-y-2.5 text-sm mb-6">
                    <li class="flex items-center justify-between py-2 border-b border-white/10">
                        <span class="opacity-60">Segunda - Sexta</span>
                        <span class="font-semibold text-white">8h00 - 18h00</span>
                    </li>
                    <li class="flex items-center justify-between py-2 border-b border-white/10">
                        <span class="opacity-60">Sábado</span>
                        <span class="font-semibold text-white">9h00 - 16h00</span>
                    </li>
                    <li class="flex items-center justify-between py-2">
                        <span class="opacity-60">Domingo</span>
                        <span class="text-destructive font-semibold">Encerrado</span>
                    </li>
                </ul>
                <a href="https://wa.me/244929643510?text=Ol%C3%A1%2C%20gostaria%20de%20saber%20mais%20sobre%20os%20cursos"
                   target="_blank" rel="noopener noreferrer"
                   class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:scale-105"
                   style="background-color: #25D366;">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    Contactar via WhatsApp
                </a>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm opacity-50">
            <span>&copy; {{ date('Y') }} MC-COMERCIAL. Todos os direitos reservados.</span>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:opacity-100 hover:text-accent transition-colors">Política de Privacidade</a>
                <a href="#" class="hover:opacity-100 hover:text-accent transition-colors">Termos de Uso</a>
            </div>
        </div>
    </div>
</footer>
