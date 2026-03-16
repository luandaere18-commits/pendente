{{-- Barra superior com contactos e horário --}}
<div class="bg-topbar text-topbar-foreground text-xs py-2 hidden md:block">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center gap-5">
            <a href="mailto:mucuanha.chineva@gmail.com"
               class="flex items-center gap-1.5 opacity-80 hover:opacity-100 hover:text-accent transition-all duration-200 group">
                <i data-lucide="mail" class="w-3.5 h-3.5 group-hover:scale-110 transition-transform"></i>
                mucuanha.chineva@gmail.com
            </a>
            <a href="tel:+244929643510"
               class="flex items-center gap-1.5 opacity-80 hover:opacity-100 hover:text-accent transition-all duration-200 group">
                <i data-lucide="phone" class="w-3.5 h-3.5 group-hover:scale-110 transition-transform"></i>
                +244 929-643-510
            </a>
        </div>
        <div class="flex items-center gap-5">
            <span class="flex items-center gap-1.5 opacity-70">
                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                Seg - Sex: 8h00 - 18h00
            </span>
            <div class="flex items-center gap-1">
                @foreach(['facebook', 'instagram', 'linkedin'] as $social)
                    <a href="#"
                       class="w-6 h-6 rounded flex items-center justify-center opacity-60 hover:opacity-100 hover:text-accent hover:scale-110 transition-all duration-200"
                       aria-label="{{ ucfirst($social) }}">
                        <i data-lucide="{{ $social }}" class="w-3.5 h-3.5"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
