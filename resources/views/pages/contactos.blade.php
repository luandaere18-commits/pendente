@extends('layouts.public')

@section('title', 'Contactos — MC-COMERCIAL')

@section('content')

{{-- Header --}}
<section class="relative pt-12 pb-16 bg-gradient-to-br from-brand-700 to-brand-900 text-white -mt-20 pt-32 overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="container-wide relative">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Contactos</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3">Entre em Contacto</h1>
        <p class="text-blue-100/70">Estamos prontos para ajudar. Envie-nos uma mensagem ou visite um dos nossos centros.</p>
    </div>
</section>

<section class="section-tight">
    <div class="container-wide">
        <div class="grid lg:grid-cols-5 gap-12">
            {{-- Contact Form --}}
            <div class="lg:col-span-3 reveal">
                <div class="card p-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i data-lucide="send" class="w-5 h-5 text-brand-600"></i>
                        Envie-nos uma mensagem
                    </h2>
                    <form method="POST" action="#" class="space-y-5">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="form-label">Nome <span class="text-red-500">*</span></label>
                                <input type="text" name="nome" class="form-input" placeholder="O seu nome" required>
                            </div>
                            <div>
                                <label class="form-label">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" class="form-input" placeholder="email@exemplo.com" required>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Telefone</label>
                            <input type="tel" name="telefone" class="form-input" placeholder="+244 9XX XXX XXX">
                        </div>
                        <div>
                            <label class="form-label">Assunto <span class="text-red-500">*</span></label>
                            <select name="assunto" class="form-input" required>
                                <option value="">Selecione um assunto</option>
                                <option value="informacoes">Informações sobre cursos</option>
                                <option value="inscricao">Inscrição</option>
                                <option value="empresarial">Formação empresarial</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Mensagem <span class="text-red-500">*</span></label>
                            <textarea name="mensagem" class="form-input h-32 resize-none" placeholder="Escreva a sua mensagem..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary btn-lg">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Enviar Mensagem
                        </button>
                    </form>
                </div>
            </div>

            {{-- Contact Info --}}
            <div class="lg:col-span-2 space-y-6 reveal">
                <div class="card p-6">
                    <h3 class="text-base font-bold text-slate-900 mb-5">Informações de Contacto</h3>
                    <div class="space-y-5">
                        @foreach([
                            ['icon' => 'mail',     'label' => 'Email',    'value' => 'mc-comercial@gmail.com', 'href' => 'mailto:mc-comercial@gmail.com'],
                            ['icon' => 'phone',    'label' => 'Telefone', 'value' => '+244 926 861 700',      'href' => 'tel:+244926861700'],
                            ['icon' => 'clock',    'label' => 'Horário',  'value' => 'Seg - Sex: 8h00 - 18h00', 'href' => null],
                        ] as $info)
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center shrink-0">
                                    <i data-lucide="{{ $info['icon'] }}" class="w-4 h-4 text-brand-600"></i>
                                </div>
                                <div>
                                    <span class="text-xs text-slate-400 block">{{ $info['label'] }}</span>
                                    @if($info['href'])
                                        <a href="{{ $info['href'] }}" class="text-sm font-medium text-slate-900 hover:text-brand-600 transition-colors">{{ $info['value'] }}</a>
                                    @else
                                        <span class="text-sm font-medium text-slate-900">{{ $info['value'] }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card p-6">
                    <h3 class="text-base font-bold text-slate-900 mb-4">Redes Sociais</h3>
                    <div class="flex gap-2">
                        @foreach([
                            ['icon' => 'facebook',  'href' => '#', 'label' => 'Facebook'],
                            ['icon' => 'instagram', 'href' => '#', 'label' => 'Instagram'],
                            ['icon' => 'linkedin',  'href' => '#', 'label' => 'LinkedIn'],
                        ] as $social)
                            <a href="{{ $social['href'] }}" aria-label="{{ $social['label'] }}"
                               class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-brand-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-200 hover:scale-110">
                                <i data-lucide="{{ $social['icon'] }}" class="w-4 h-4"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="card p-6 bg-brand-50 border-brand-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-[#25D366] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-5 h-5">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">WhatsApp</h4>
                            <p class="text-xs text-slate-500">Resposta rápida</p>
                        </div>
                    </div>
                    <a href="https://wa.me/244929643510" target="_blank" class="btn-primary w-full justify-center btn-sm">
                        Iniciar Conversa
                    </a>
                </div>

                {{-- Map --}}
                <div class="card p-2 overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125529.1950542!2d13.2!3d-8.84!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a51f15c36000001%3A0x3e34e0f5c6f7e7a8!2sLuanda%2C%20Angola!5e0!3m2!1spt-BR!2sao!4v1"
                        width="100%" height="200" style="border:0; border-radius: var(--radius-lg);"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
