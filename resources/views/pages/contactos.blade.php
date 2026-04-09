@extends('layouts.public')

@section('title', 'Contactos — MC-COMERCIAL')

@section('content')

{{-- Header with Image --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="{{ asset('images/fundo_imagem.jpg') }}" alt="Contactos">
    </div>
    <div class="container-wide">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4 reveal">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Contactos</span>
        </nav>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 font-heading reveal">Contacte-nos</h1>
        <p class="text-blue-100/60 max-w-lg reveal">Estamos aqui para ajudar. Entre em contacto connosco.</p>
    </div>
</section>

{{-- Contact Info + Form --}}
<section class="section bg-white">
    <div class="container-wide">
        <div class="grid lg:grid-cols-5 gap-12">
            {{-- Contact Info --}}
            <div class="lg:col-span-2 reveal-left">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 font-heading">Informações de Contacto</h2>
                <div class="space-y-6">
                    @foreach([
                        ['icon' => 'map-pin', 'title' => 'Morada', 'lines' => ['Luanda, Angola', 'Rua Principal, Nº 123']],
                        ['icon' => 'phone', 'title' => 'Telefone', 'lines' => ['+244 923 000 000', '+244 912 000 000']],
                        ['icon' => 'mail', 'title' => 'Email', 'lines' => ['info@mc-comercial.co.ao', 'formacao@mc-comercial.co.ao']],
                        ['icon' => 'clock', 'title' => 'Horário', 'lines' => ['Seg — Sex: 08:00 — 17:00', 'Sáb: 08:00 — 13:00']],
                    ] as $info)
                        <div class="flex gap-4 group">
                            <div class="w-12 h-12 rounded-xl bg-brand-100 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:scale-110 transition-all duration-300">
                                <i data-lucide="{{ $info['icon'] }}" class="w-5 h-5 text-brand-600 group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 mb-1 font-heading">{{ $info['title'] }}</h4>
                                @foreach($info['lines'] as $line)
                                    <p class="text-sm text-slate-500">{{ $line }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Social --}}
                <div class="mt-10">
                    <h4 class="text-sm font-bold text-slate-900 mb-4 font-heading">Redes Sociais</h4>
                    <div class="flex gap-3">
                        @foreach(['facebook', 'instagram', 'linkedin', 'youtube'] as $social)
                            <a href="#" class="w-10 h-10 rounded-xl bg-brand-100 text-brand-600 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i data-lucide="{{ $social }}" class="w-4 h-4"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="lg:col-span-3 reveal-right">
                <div class="card p-8">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 font-heading">Envie-nos uma Mensagem</h2>
                    <form class="space-y-5">
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="form-label">Nome Completo</label>
                                <input type="text" class="form-input" placeholder="O seu nome">
                            </div>
                            <div>
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" placeholder="email@exemplo.com">
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="form-label">Telefone</label>
                                <input type="tel" class="form-input" placeholder="+244 9XX XXX XXX">
                            </div>
                            <div>
                                <label class="form-label">Assunto</label>
                                <select class="form-input">
                                    <option value="">Seleccione...</option>
                                    <option>Informações sobre cursos</option>
                                    <option>Inscrição</option>
                                    <option>Parceria</option>
                                    <option>Reclamação</option>
                                    <option>Outro</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Mensagem</label>
                            <textarea class="form-input h-32 resize-none" placeholder="Escreva a sua mensagem..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary btn-lg w-full sm:w-auto group">
                            <i data-lucide="send" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform"></i>
                            Enviar Mensagem
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Map --}}
<section class="reveal">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125529.1950542!2d13.2!3d-8.84!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a51f15c36000001%3A0x3e34e0f5c6f7e7a8!2sLuanda%2C%20Angola!5e0!3m2!1spt-BR!2sao!4v1"
        width="100%" height="450" style="border:0;"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
        class="w-full"></iframe>
</section>

@endsection
