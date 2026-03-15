{{-- Rodapé --}}
<footer class="bg-footer text-footer-foreground pt-16 pb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            {{-- Col 1 - Sobre --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL Logo" class="h-9 w-9 object-contain" loading="lazy">
                    <span class="text-lg font-bold text-primary-foreground">MC-COMERCIAL</span>
                </div>
                <p class="text-sm opacity-70 mb-4 leading-relaxed">
                    Centro de formação de qualidade com mais de 10 anos de experiência na preparação de profissionais qualificados para o mercado de trabalho.
                </p>
                <div class="flex gap-3">
                    @foreach(['facebook', 'instagram', 'linkedin', 'youtube'] as $social)
                        <a href="#" class="w-9 h-9 rounded-full bg-primary/20 flex items-center justify-center hover:bg-accent transition-colors">
                            <i data-lucide="{{ $social }}" class="w-4 h-4"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Col 2 - Links --}}
            <div>
                <h4 class="font-semibold text-primary-foreground mb-4">Links Rápidos</h4>
                <ul class="space-y-2 text-sm">
                    @php
                        $footerLinks = [
                            ['label' => 'Home', 'route' => 'site.home'],
                            ['label' => 'Centros', 'route' => 'site.centros'],
                            ['label' => 'Cursos', 'route' => 'site.cursos'],
                            ['label' => 'Sobre Nós', 'route' => 'site.sobre'],
                            ['label' => 'Contactos', 'route' => 'site.contactos'],
                        ];
                    @endphp
                    @foreach($footerLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 3 - Contactos --}}
            <div>
                <h4 class="font-semibold text-primary-foreground mb-4">Contactos</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <i data-lucide="phone" class="w-4 h-4 mt-0.5 shrink-0"></i>
                        <div>
                            <a href="tel:+244929643510" class="block opacity-70 hover:opacity-100">+244 929-643-510</a>
                            <a href="tel:+244928966002" class="block opacity-70 hover:opacity-100">+244 928-966-002</a>
                        </div>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="mail" class="w-4 h-4 shrink-0"></i>
                        <a href="mailto:mucuanha.chineva@gmail.com" class="opacity-70 hover:opacity-100">mucuanha.chineva@gmail.com</a>
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 mt-0.5 shrink-0"></i>
                        <span class="opacity-70">Rua A, Bairro 1º de Maio Nº 05, 1º Andar, Luanda-Viana</span>
                    </li>
                </ul>
            </div>

            {{-- Col 4 - Horário --}}
            <div>
                <h4 class="font-semibold text-primary-foreground mb-4">Horário</h4>
                <ul class="space-y-2 text-sm opacity-70">
                    <li>Segunda - Sexta: 8h00 - 18h00</li>
                    <li>Sábado: 9h00 - 16h00</li>
                    <li>Domingo: Encerrado</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-primary/20 pt-6 text-center text-sm opacity-60">
            &copy; {{ date('Y') }} MC-COMERCIAL. Todos os direitos reservados.
        </div>
    </div>
</footer>
